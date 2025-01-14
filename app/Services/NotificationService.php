<?php

namespace App\Services;

use App\Repositories\Notification\NotificationRepositoryInterface;

class NotificationService
{
    public function __construct(protected NotificationRepositoryInterface $notificationRepository) {}

    public function createNotification(int $sender_id, int $receiver_id,  array $data)
    {
        return $this->notificationRepository->create([
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            ...$data
        ]);
    }

    public function deleteNotification(array $sender_ids, array $receiver_ids)
    {
        return $this->notificationRepository->deleteNotification($sender_ids, $receiver_ids);
    }
}
