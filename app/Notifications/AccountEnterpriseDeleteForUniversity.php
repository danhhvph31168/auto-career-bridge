<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountEnterpriseDeleteForUniversity extends Notification implements ShouldQueue
{
    use Queueable;
    protected $enterprise;

    /**
     * Create a new notification instance.
     */
    public function __construct($enterprise)
    {
        $this->enterprise = $enterprise;
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
            ->subject("Thông báo tài khoản doanh nghiệp không còn hoạt động")
            ->line("Thông báo: Doanh nghiệp '{$this->enterprise->name}' mà bạn đang hợp tác hoặc ứng tuyển đã bị xóa khỏi hệ thống.")
            ->view('vendor.notifications.enterprise-delete-to-university', ['enterprise' => $this->enterprise]);
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
