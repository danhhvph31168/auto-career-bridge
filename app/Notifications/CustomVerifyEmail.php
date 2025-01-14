<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
    // Send the verification email
    public function toMail(object $notifiable): MailMessage
    {
        $verificationUrl = $this->generateVerificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Xác thực tài khoản của bạn')
            ->greeting('Chào ' . $notifiable->username)
            ->line('Cảm ơn bạn đã đăng ký tài khoản với chúng tôi.')
            ->action('Xác nhận tài khoản', $verificationUrl)
            ->line('Nếu bạn không yêu cầu tạo tài khoản, bạn có thể bỏ qua email này.')
            ->view('vendor.notifications.email', [
                'notifiable' => $notifiable,
                'verificationUrl' => $verificationUrl
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
    // Generate the verification URL
    protected function generateVerificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
