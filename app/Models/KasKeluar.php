<?php

namespace App\Models;

use App\Services\CashBalanceService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class KasKeluar extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    protected $table = 'kas_keluar';

    protected $fillable = [
        'tanggal',
        'jenis_pengeluaran',
        'nominal',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'approved_at' => 'datetime',
        'nominal' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $kasKeluar): void {
            if (Schema::hasColumn($kasKeluar->getTable(), 'status')) {
                $kasKeluar->status = self::STATUS_PENDING;
            }
        });
    }

    public function kegiatan()
    {
        return $this->hasOne(JadwalKegiatan::class, 'kas_keluar_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    public function deletionRequest()
    {
        return $this->morphOne(DeletionRequest::class, 'model')->where('status', 'pending');
    }

    public function scopeApproved(Builder $query): Builder
    {
        if (! Schema::hasColumn($this->getTable(), 'status')) {
            return $query;
        }

        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopePending(Builder $query): Builder
    {
        if (! Schema::hasColumn($this->getTable(), 'status')) {
            return $query->whereRaw('1 = 0');
        }

        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeAvailableForActivity(Builder $query): Builder
    {
        return $query->approved()->whereDoesntHave('kegiatan');
    }

    public function isPending(): bool
    {
        if (! Schema::hasColumn($this->getTable(), 'status')) {
            return false;
        }

        return $this->status === self::STATUS_PENDING;
    }

    public function isFinalized(): bool
    {
        if (! Schema::hasColumn($this->getTable(), 'status')) {
            return false;
        }

        return in_array($this->status, [self::STATUS_APPROVED, self::STATUS_REJECTED], true);
    }

    public function approve(Admin $approver, CashBalanceService $cashBalanceService): void
    {
        DB::transaction(function () use ($approver, $cashBalanceService): void {
            $kasKeluar = self::query()->whereKey($this->getKey())->lockForUpdate()->firstOrFail();

            if (! $kasKeluar->isPending()) {
                throw ValidationException::withMessages([
                    'status' => 'Hanya data kas keluar berstatus pending yang bisa di-approve.',
                ]);
            }

            $cashBalanceService->ensureSufficientBalanceForApproval($kasKeluar);

            $kasKeluar->forceFill([
                'status' => self::STATUS_APPROVED,
                'approved_by' => $approver->getKey(),
                'approved_at' => now(),
                'rejection_reason' => null,
            ])->save();

            $this->setRawAttributes($kasKeluar->getAttributes(), true);
            $this->loadMissing('approver');
        });
    }

    public function reject(Admin $approver, string $reason): void
    {
        DB::transaction(function () use ($approver, $reason): void {
            $kasKeluar = self::query()->whereKey($this->getKey())->lockForUpdate()->firstOrFail();

            if (! $kasKeluar->isPending()) {
                throw ValidationException::withMessages([
                    'status' => 'Hanya data kas keluar berstatus pending yang bisa ditolak.',
                ]);
            }

            $kasKeluar->forceFill([
                'status' => self::STATUS_REJECTED,
                'approved_by' => $approver->getKey(),
                'approved_at' => now(),
                'rejection_reason' => $reason,
            ])->save();

            $this->setRawAttributes($kasKeluar->getAttributes(), true);
            $this->loadMissing('approver');
        });
    }
}
