<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\KasKeluar;

class KasKeluarPolicy
{
    public function viewAny(Admin $user): bool
    {
        return $user->is_admin;
    }

    public function view(Admin $user, KasKeluar $kasKeluar): bool
    {
        return $user->is_admin;
    }

    public function create(Admin $user): bool
    {
        return $user->is_admin;
    }

    public function update(Admin $user, KasKeluar $kasKeluar): bool
    {
        return $user->is_admin && $kasKeluar->isPending();
    }

    public function delete(Admin $user, KasKeluar $kasKeluar): bool
    {
        return $user->is_admin && $kasKeluar->isPending();
    }

    public function approve(Admin $user, KasKeluar $kasKeluar): bool
    {
        return $user->isKetua() && $kasKeluar->isPending();
    }

    public function reject(Admin $user, KasKeluar $kasKeluar): bool
    {
        return $user->isKetua() && $kasKeluar->isPending();
    }
}
