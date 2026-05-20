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
class DistribusiZakat extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    protected $table = 'distribusi_zakat';

    protected $fillable = [
        'tanggal',
        'mustahik_id',
        'penerimaan_zakat_id',
        'jenis_zakat',
        'bentuk_zakat',
        'jumlah_zakat',
        'satuan',
        'nominal',
        'harga_barang_fitrah',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah_zakat' => 'decimal:2',
        'nominal' => 'decimal:2',
        'harga_barang_fitrah' => 'decimal:2',
        'approved_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $distribusiZakat): void {
            if (Schema::hasColumn($distribusiZakat->getTable(), 'status')) {
                $distribusiZakat->status = self::STATUS_PENDING;
            }
        });
    }

    public function mustahik()
    {
        return $this->belongsTo(Mustahik::class, 'mustahik_id');
    }

    public function penerimaanZakat()
    {
        return $this->belongsTo(PenerimaanZakat::class, 'penerimaan_zakat_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    public function getIsBarangAttribute()
    {
        return $this->bentuk_zakat === 'Barang';
    }

    public function getLabelJumlahAttribute()
    {
        if ($this->is_barang) {
            return $this->jumlah_utama . ' ' . $this->jumlah_unit;
        }

        return '-';
    }

    public function getJumlahUtamaAttribute()
    {
        if ($this->is_barang) {
            return $this->formatNumber($this->jumlah_zakat);
        }

        return '-';
    }

    public function getJumlahUnitAttribute()
    {
        if (! $this->is_barang) {
            return null;
        }

        $unit = trim((string) $this->satuan);
        return $unit !== '' ? $unit : 'unit';
    }

    public function getNilaiDanaAttribute()
    {
        return (float) ($this->nominal ?? ($this->is_barang ? 0 : $this->jumlah_zakat));
    }

    private function formatNumber($value)
    {
        $number = (float) $value;

        if (fmod($number, 1.0) === 0.0) {
            return number_format($number, 0, ',', '.');
        }

        $formatted = number_format($number, 2, ',', '.');
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
            $distribusiZakat = self::query()->whereKey($this->getKey())->lockForUpdate()->firstOrFail();

            if (! $distribusiZakat->isPending()) {
                throw ValidationException::withMessages([
                    'status' => 'Hanya distribusi zakat berstatus pending yang bisa di-approve.',
                ]);
            }

            $distribusiZakat->forceFill([
                'status' => self::STATUS_APPROVED,
                'approved_by' => $approver->getKey(),
                'approved_at' => now(),
                'rejection_reason' => null,
            ])->save();

            $this->setRawAttributes($distribusiZakat->getAttributes(), true);
            $this->loadMissing('approver');
        });
    }

    public function reject(Admin $approver, string $reason): void
    {
        DB::transaction(function () use ($approver, $reason): void {
            $distribusiZakat = self::query()->whereKey($this->getKey())->lockForUpdate()->firstOrFail();

            if (! $distribusiZakat->isPending()) {
                throw ValidationException::withMessages([
                    'status' => 'Hanya distribusi zakat berstatus pending yang bisa ditolak.',
                ]);
            }

            $distribusiZakat->forceFill([
                'status' => self::STATUS_REJECTED,
                'approved_by' => $approver->getKey(),
                'approved_at' => now(),
                'rejection_reason' => $reason,
            ])->save();

            $this->setRawAttributes($distribusiZakat->getAttributes(), true);
            $this->loadMissing('approver');
        });
    }
}
