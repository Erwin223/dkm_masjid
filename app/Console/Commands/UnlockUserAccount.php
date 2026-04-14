<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UnlockUserAccount extends Command
{
    protected $signature = 'user:unlock {email : Email address of the user to unlock}';

    protected $description = 'Unlock a locked user account';

    public function handle()
    {
        $email = $this->argument('email');

        $user = \App\Models\User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found.");
            return 1;
        }

        if (!$user->isLocked()) {
            $this->info("User account is not locked.");
            return 0;
        }

        $user->unlockAccount();

        $this->info("User account {$email} has been unlocked successfully.");
        \Illuminate\Support\Facades\Log::info('User account unlocked via command', [
            'user_id' => $user->id,
            'email' => $email,
            'unlocked_by' => 'console',
        ]);

        return 0;
    }
}
