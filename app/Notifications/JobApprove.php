<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobApprove extends Notification implements ShouldQueue
{
    use Queueable;

    protected $job;
    protected $managerName;
    protected $reason;

    /**
     * Create a new notification instance.
     */
    public function __construct($job, $managerName, $reason = '')
    {
        $this->job = $job;
        $this->managerName = $managerName;
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
            ->subject('Thông báo tin đăng công việc')
            ->view('vendor.notifications.job-approve', [
                'job' => $this->job,
                'username' => $this->managerName,
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
