<?php

namespace App\Services;

use App\Models\KasKeluar;
use App\Models\KasMasuk;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class CashBalanceService
{
    public function getCurrentBalance(): float
    {
        $totalMasuk = (float) KasMasuk::query()->sum('jumlah');
        $totalKeluar = (float) KasKeluar::query()->approved()->sum('nominal');

        return $totalMasuk - $totalKeluar;
    }

    public function getLockedCurrentBalance(): float
    {
        $kasMasuk = KasMasuk::query()
            ->select(['id', 'jumlah'])
            ->lockForUpdate()
            ->get();

        $approvedKasKeluar = KasKeluar::query()
            ->approved()
            ->select(['id', 'nominal'])
            ->lockForUpdate()
            ->get();

        return $this->sumAmounts($kasMasuk, 'jumlah') - $this->sumAmounts($approvedKasKeluar, 'nominal');
    }

    public function ensureSufficientBalanceForApproval(KasKeluar $kasKeluar): void
    {
        $availableBalance = $this->getLockedCurrentBalance();

        if ($kasKeluar->nominal > $availableBalance) {
            throw ValidationException::withMessages([
                'status' => 'Approval gagal. Nominal kas keluar melebihi saldo kas saat ini.',
            ]);
        }
    }

    private function sumAmounts(Collection $items, string $field): float
    {
        return (float) $items->sum($field);
    }
}
