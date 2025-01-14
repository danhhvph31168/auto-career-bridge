<?php

namespace App\Repositories\Notification;

use App\Models\Notification;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    public function getModel()
    {
        return Notification::class;
    }

    public function deleteNotification(array $sender_ids, array $receiver_ids)
    {
        return $this->_model
            ->whereIn('sender_id', $sender_ids)
            ->whereIn('receiver_id', $receiver_ids)
            ->forceDelete();
    }

    public function getNotifications(array $column = ['*'])
    {
        $id = Auth::id();
        $notifications = $this->getModel()::query()
            ->join('users', 'users.id', '=', 'notifications.receiver_id')
            ->where('notifications.receiver_id', $id)
            ->limit(5)
            ->orderBy('notifications.created_at', 'DESC')
            ->get();

        return $notifications;
    }
}
