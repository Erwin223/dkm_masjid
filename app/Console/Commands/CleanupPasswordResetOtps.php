<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupPasswordResetOtps extends Command
{
    protected $signature = 'otp:cleanup';

    protected $description = 'Hapus data OTP reset password yang sudah kedaluwarsa';

    public function handle(): int
    {
        $cutoff = Carbon::now()->subMinutes(15);

        $deleted = DB::table('password_reset_otps')
            ->where('created_at', '<', $cutoff)
            ->delete();

        $this->info('Deleted '.$deleted.' expired OTP record(s).');

        return self::SUCCESS;
    }
}

