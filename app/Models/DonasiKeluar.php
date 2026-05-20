<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

/**
 * @property \Illuminate\Support\Carbon|null $tanggal
 * @property bool $is_barang
 * @property float $nilai_dana
 * @property string $label_jumlah
 */
class DonasiKeluar extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    protected $table = 'donasi_keluar';

    protected $fillable = [
        'tanggal',
        'jenis_donasi',
        'tujuan',
        'jumlah',
        'satuan',
        'nominal',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah'  => 'decimal:2',
        'nominal' => 'decimal:2',
        'approved_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $donasiKeluar): void {
            if (Schema::hasColumn($donasiKeluar->getTable(), 'status')) {
                $donasiKeluar->status = self::STATUS_PENDING;
            }
        });
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    public function getIsBarangAttribute()
    {
        return in_array($this->jenis_donasi, ['Barang', 'Makanan', 'Pakaian'], true);
    }

    public function getNilaiDanaAttribute()
    {
        return (float) ($this->is_barang ? ($this->nominal ?? 0) : ($this->jumlah ?? 0));
    }

    public function getLabelJumlahAttribute()
    {
        if (! $this->is_barang) {
            return 'Rp.' . number_format((float) $this->jumlah, 0, ',', '.');
        }

        return $this->formatNumber($this->jumlah) . ' ' . trim((string) $this->satuan);
    }

    private function formatNumber($value)
    {
        $formatted = number_format((float) $value, 2, ',', '.');
        return rtrim(rtrim($formatted, '0'), ',');
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
            $donasiKeluar = self::query()->whereKey($this->getKey())->lockForUpdate()->firstOrFail();

            if (! $donasiKeluar->isPending()) {
                throw ValidationException::withMessages([
                    'status' => 'Hanya donasi keluar berstatus pending yang bisa di-approve.',
                ]);
            }

            $donasiKeluar->forceFill([
                'status' => self::STATUS_APPROVED,
                'approved_by' => $approver->getKey(),
                'approved_at' => now(),
                'rejection_reason' => null,
            ])->save();

            $this->setRawAttributes($donasiKeluar->getAttributes(), true);
            $this->loadMissing('approver');
        });
    }

    public function reject(Admin $approver, string $reason): void
    {
        DB::transaction(function () use ($approver, $reason): void {
            $donasiKeluar = self::query()->whereKey($this->getKey())->lockForUpdate()->firstOrFail();

            if (! $donasiKeluar->isPending()) {
                throw ValidationException::withMessages([
                    'status' => 'Hanya donasi keluar berstatus pending yang bisa ditolak.',
                ]);
            }

            $donasiKeluar->forceFill([
                'status' => self::STATUS_REJECTED,
                'approved_by' => $approver->getKey(),
                'approved_at' => now(),
                'rejection_reason' => $reason,
            ])->save();

            $this->setRawAttributes($donasiKeluar->getAttributes(), true);
            $this->loadMissing('approver');
        });
    }
}
