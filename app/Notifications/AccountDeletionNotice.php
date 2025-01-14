<?php

namespace App\Notifications;

use App\Models\Job;
use App\Models\University;
use App\Models\Workshop;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountDeletionNotice extends Notification implements ShouldQueue
{
    use Queueable;
    protected $object;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        Model $object = null,
    ) {
        $this->object = $object;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('AutoCarrer Bridge Thông báo')
            ->action('Truy cập hệ thống', url('/'))
            ->view('vendor.notifications.deleteAccount', [
                'enterprise' => $notifiable,
                'object' => $this->object,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
