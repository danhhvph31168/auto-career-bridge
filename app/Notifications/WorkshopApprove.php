<?php

namespace App\Notifications;

use App\Models\Workshop;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkshopApprove extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reason;
    protected $workshop;
    /**
     * Create a new notification instance.
     */
    public function __construct($workshop, string $reason = '')
    {
        $this->reason = $reason;
        $this->workshop = $workshop;
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
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!')
            ->view('vendor.notifications.workshop-approve', [
                'university' => $notifiable,
                'reason' => $this->reason,
                'workshop' => $this->workshop,
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
