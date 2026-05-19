<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApprovalRequested extends Notification
{
    use Queueable;

    public function __construct(
        protected string $adminName,
        protected string $moduleName
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Permintaan Persetujuan Baru',
            'message' => "Admin {$this->adminName} mengajukan persetujuan pada modul {$this->moduleName}.",
            'type' => 'approval_request',
        ];
    }
}
