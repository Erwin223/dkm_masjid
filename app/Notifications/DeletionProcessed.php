<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeletionProcessed extends Notification
{
    use Queueable;

    protected $moduleName;
    protected $isApproved;

    /**
     * Create a new notification instance.
     */
    public function __construct($moduleName, $isApproved)
    {
        $this->moduleName = $moduleName;
        $this->isApproved = $isApproved;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $status = $this->isApproved ? 'disetujui' : 'ditolak';
        return [
            'title' => 'Status Permintaan Hapus',
            'message' => "Pengajuan penghapusan data Anda pada modul {$this->moduleName} telah {$status} oleh Ketua.",
            'type' => 'deletion_processed',
            'is_approved' => $this->isApproved,
        ];
    }
}
