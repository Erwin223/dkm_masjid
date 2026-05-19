<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\JadwalKegiatan;

class JadwalKegiatanPolicy
{
    public function viewAny(Admin $user): bool
    {
        return $user->is_admin;
    }

    public function view(Admin $user, JadwalKegiatan $jadwalKegiatan): bool
    {
        return $user->is_admin;
    }

    public function create(Admin $user): bool
    {
        return $user->is_admin;
    }

    public function update(Admin $user, JadwalKegiatan $jadwalKegiatan): bool
    {
        return $user->is_admin && $jadwalKegiatan->isPending();
    }

    public function delete(Admin $user, JadwalKegiatan $jadwalKegiatan): bool
    {
        return $user->is_admin && $jadwalKegiatan->isPending();
    }

    public function approve(Admin $user, JadwalKegiatan $jadwalKegiatan): bool
    {
        return $user->isKetua() && $jadwalKegiatan->isPending();
    }

    public function reject(Admin $user, JadwalKegiatan $jadwalKegiatan): bool
    {
        return $user->isKetua() && $jadwalKegiatan->isPending();
    }
}
