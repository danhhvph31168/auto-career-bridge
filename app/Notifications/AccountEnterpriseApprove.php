<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountEnterpriseApprove extends Notification implements ShouldQueue
{
    use Queueable;

    protected $enterprise;
    protected $reason;

    /**
     * Create a new notification instance.
     */
    public function __construct($enterprise, $reason = '')
    {
        $this->enterprise = $enterprise;
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
            ->subject('Thông báo phê duyệt tài khoản')
            ->view('vendor.notifications.enterprise-approve', [
                'enterprise' => $this->enterprise,
                'reason' => $this->reason,
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
