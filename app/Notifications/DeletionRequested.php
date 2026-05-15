<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeletionRequested extends Notification
{
    use Queueable;

    protected $adminName;
    protected $moduleName;

    /**
     * Create a new notification instance.
     */
    public function __construct($adminName, $moduleName)
    {
        $this->adminName = $adminName;
        $this->moduleName = $moduleName;
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
        return [
            'title' => 'Permintaan Hapus Data',
            'message' => "Admin {$this->adminName} mengajukan penghapusan data pada modul {$this->moduleName}.",
            'type' => 'deletion_request',
        ];
    }
}
