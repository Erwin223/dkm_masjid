<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class JadwalKegiatan extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    protected $table = 'jadwal_kegiatan';

    protected $fillable = [
        'nama_kegiatan',
        'tanggal',
        'waktu',
        'tempat',
        'penanggung_jawab',
        'estimasi_anggaran',
        'keterangan',
        'kas_keluar_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'estimasi_anggaran' => 'decimal:2',
        'approved_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $kegiatan): void {
            if (Schema::hasColumn($kegiatan->getTable(), 'status')) {
                $kegiatan->status = self::STATUS_PENDING;
            }
        });
    }

    public function kasKeluar()
    {
        return $this->belongsTo(KasKeluar::class, 'kas_keluar_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    public function getRealisasiAnggaranAttribute(): float
    {
        return (float) ($this->kasKeluar->nominal ?? 0);
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

    public function approve(Admin $approver): void
    {
        DB::transaction(function () use ($approver): void {
            $kegiatan = self::query()->whereKey($this->getKey())->lockForUpdate()->firstOrFail();

            if (! $kegiatan->isPending()) {
                throw ValidationException::withMessages([
                    'status' => 'Hanya kegiatan berstatus pending yang bisa di-approve.',
                ]);
            }

            $kegiatan->forceFill([
                'status' => self::STATUS_APPROVED,
                'approved_by' => $approver->getKey(),
                'approved_at' => now(),
                'rejection_reason' => null,
            ])->save();

            $this->setRawAttributes($kegiatan->getAttributes(), true);
            $this->loadMissing('approver');
        });
    }

    public function reject(Admin $approver, string $reason): void
    {
        DB::transaction(function () use ($approver, $reason): void {
            $kegiatan = self::query()->whereKey($this->getKey())->lockForUpdate()->firstOrFail();

            if (! $kegiatan->isPending()) {
                throw ValidationException::withMessages([
                    'status' => 'Hanya kegiatan berstatus pending yang bisa ditolak.',
                ]);
            }

            $kegiatan->forceFill([
                'status' => self::STATUS_REJECTED,
                'approved_by' => $approver->getKey(),
                'approved_at' => now(),
                'rejection_reason' => $reason,
            ])->save();

            $this->setRawAttributes($kegiatan->getAttributes(), true);
            $this->loadMissing('approver');
        });
    }
}
