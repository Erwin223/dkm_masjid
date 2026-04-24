<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UnlockAdminAccount extends Command
{
    protected $signature = 'admin:unlock {email : Email address of the admin to unlock}';

    protected $description = 'Unlock a locked admin account';

    public function handle()
    {
        $email = $this->argument('email');

        $admin = \App\Models\Admin::where('email', $email)->first();

        if (!$admin) {
            $this->error("Admin with email {$email} not found.");
            return 1;
        }

        if (!$admin->isLocked()) {
            $this->info("Admin account is not locked.");
            return 0;
        }

        $admin->unlockAccount();

        $this->info("Admin account {$email} has been unlocked successfully.");
        \Illuminate\Support\Facades\Log::info('Admin account unlocked via command', [
            'admin_id' => $admin->id,
            'email' => $email,
            'unlocked_by' => 'console',
        ]);

        return 0;
    }
}
