<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobDeletedNotificationForUniversity extends Notification implements ShouldQueue
{
    use Queueable;

    protected $job;
    protected $username;

    /**
     * Create a new notification instance.
     */
    public function __construct($job, $username)
    {
        $this->job = $job;
        $this->username = $username;
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
            ->subject('Thông báo tin đăng công việc đã bị xoá')
            ->view('vendor.notifications.job-delete-university', [
                'job' => $this->job,
                'username' => $this->username,
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
