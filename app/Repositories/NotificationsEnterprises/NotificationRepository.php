<?php

namespace App\Repositories\NotificationsEnterprises;

use App\Models\Notification;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    public function getModel()
    {
        return Notification::class;
    }

    /**
     * Get a list of notifications by business
     *
     * @param int $limit
     * @param int $perPage
     * @return [Returns record limit data if $limit has a value]
     * @return [Returns pagination if $perPage has a value]
     * @return [Return normal data if $limit and $perPage are null]
     */
    public function getNotificationsByEnterprise(int $limit = null, int $perPage = null)
    {
        $query = Notification::query()
            ->selectRaw('notifications.*')
            ->join('users', 'users.id', '=', 'notifications.receiver_id')
            ->where('notifications.receiver_id', '=', Auth::id())
            ->latest('id');

        if ($limit) {
            return $query->limit($limit)->get();
        }

        if ($perPage) {
            return $query->paginate($perPage);
        }

        return $query->get();
    }


    /**
     * Get notifications by ID.
     *
     * @param int $id
     * @return Notification
     */
    public function findById($id, $column = [])
    {
        return Notification::query()->where('id', $id)->first();
    }

    /**
     * Mark notifications as read.
     *
     * @param Notification $notification
     * @return bool
     */
    public function markAsRead(Notification $notification)
    {
        return $notification->update(['is_read' => READ]);
    }

    /**
     * Check if there is any cooperation between the business and the university of the announcement.
     *
     * @param Notification $notification
     * @return bool
     */
    public function isCollaborating(Notification $notification)
    {
        if (Auth::user()->university_id == null && Auth::user()->role_id == ROLE_ADMIN && Auth::user()->user_type == TYPE_UNIVERSITY) {
            if ($notification->sender->university) {
                return $notification->receiver->enterprise
                    ->universities()
                    ->where('universities.id', $notification->sender->university->id)
                    ->wherePivot('status', 1)
                    ->exists();
            }
        }

        if (Auth::user()->enterprise_id == null && Auth::user()->role_id == ROLE_ADMIN && Auth::user()->user_type == TYPE_ENTERPRISE) {
            if ($notification->sender->enterprise) {
                return $notification->receiver->university
                    ->enterprises()
                    ->where('enterprises.id', $notification->sender->enterprise->id)
                    ->wherePivot('status', 1)
                    ->exists();
            }
        }

        return false;
    }

    /**
     * delete 1 message
     *
     * @param int $id
     * @return Notification
     */
    public function destroy($id)
    {
        return Notification::find($id)->delete();
    }

    /**
     * Clear the selected record check box at
     *
     * @param $request
     * @return [Notification]
     */
    public function deleteCheckbox($request)
    {
        $ids = explode(',', $request->query('ids'));

        return Notification::whereIn('id', $ids)->delete();
    }
}
