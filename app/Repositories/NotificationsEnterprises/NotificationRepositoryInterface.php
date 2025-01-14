<?php

namespace App\Repositories\NotificationsEnterprises;

use App\Models\Notification;

interface NotificationRepositoryInterface
{
    public function getNotificationsByEnterprise(int $limit, int $perPage);
    public function findById($id);
    public function markAsRead(Notification $notification);
    public function isCollaborating(Notification $notification);
    public function destroy($id);
    public function deleteCheckbox($request);
}
