<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UniversityApprove extends Notification implements ShouldQueue
{
    use Queueable;

    private $reason;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $reason = '')
    {
        $this->reason = $reason;
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
            ->subject('Phê duyệt tài khoản')
            ->action('Truy cập hệ thống', url('/'))
            ->view('vendor.notifications.university-approve', ['user' => $notifiable, 'reason' => $this->reason]);
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
