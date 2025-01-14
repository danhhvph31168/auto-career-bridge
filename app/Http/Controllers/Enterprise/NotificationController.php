<?php

namespace App\Http\Controllers\Enterprise;

use App\Commons\Constants\NotificationType;
use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Repositories\Job\JobRepository;
use App\Repositories\NotificationsEnterprises\NotificationRepository;
use App\Repositories\University\Workshop\WorkShopRepository;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    const PATH_VIEW = 'enterprise.notifications.';

    /**
     * Inject NotificationRepository.
     *
     * @param NotificationRepository $notificationRepository
     */
    public function __construct(
        protected NotificationRepository $notificationRepository,
        protected NotificationService $notificationService,
        protected JobRepository $jobRepository,
        protected WorkShopRepository $workShopRepository,
    ) {
    }

    /**
     * Received notification list of this business
     * @return [Return to the notification list page in the business admin]
     *
     */
    public function index()
    {
        $notifications = $this->notificationRepository->getNotificationsByEnterprise(perPage: 5);

        if (Auth::user()->role_id == ROLE_ADMIN) {
            if (Auth::user()->user_type == TYPE_ADMIN) {
                $notificationType = NotificationType::TYPE_SYSTEM;
            }

            if (Auth::user()->user_type == TYPE_ENTERPRISE) {
                $notificationType = NotificationType::TYPE_ENTERPRISE;
            }

            if (Auth::user()->user_type == TYPE_UNIVERSITY) {
                $notificationType = NotificationType::TYPE_UNIVERSITY;
            }
        } else {
            $notificationType = false;
        }

        return view(self::PATH_VIEW . __FUNCTION__, compact('notifications', 'notificationType'));
    }

    /**
     * reply to the message in the title
     * @return [json]
     */
    public function header()
    {
        $notifications = $this->notificationRepository->getNotificationsByEnterprise(limit: 5);

        $listNotify = view('enterprise.notifications.partials.header', compact('notifications'))->render();

        $countUnreadHeader = $notifications->where('is_read', UN_READ)->count();

        return response()->json([
            'listNotify' => $listNotify,
            'countUnreadHeader' => $countUnreadHeader,
        ]);
    }


    /**
     * Show details of a notification.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $notification = $this->notificationRepository->findById($id);

        if (!$notification) {
            abort(404, 'Notification not found');
        }

        $this->notificationRepository->markAsRead($notification);

        $isCollaborating = $this->notificationRepository->isCollaborating($notification);

        if ($notification->type == NOTIFY_APPLY && $notification->censor_id != null) {
            $job_university = DB::table('job_university')
                ->where('id', $notification->censor_id)
                ->whereNull('deleted_at')
                ->first();
        } else {
            $job_university = false;
        }

        if ($notification->type == NOTIFY_JOIN && $notification->censor_id != null) {
            $workshop_enterprise = DB::table('workshop_enterprise')
                ->where('id', $notification->censor_id)
                ->whereNull('deleted_at')
                ->first();
        } else {
            $workshop_enterprise = false;
        }

        if ($notification->type == NOTIFY_COOPERATE && $notification->censor_id != null) {
            $collaborations = DB::table('collaborations')
                ->where('id', $notification->censor_id)
                ->whereNull('deleted_at')
                ->first();
        } else {
            $collaborations = false;
        }

        return view(self::PATH_VIEW . __FUNCTION__, compact(
            'notification',
            'isCollaborating',
            'job_university',
            'workshop_enterprise',
            'collaborations',
        ));
    }

    /**
     * delete 1 message
     *
     * @param int $id
     * @return [back]
     */
    public function delete($id)
    {
        $this->notificationRepository->destroy($id);

        return back();
    }

    /**
     * Clear the selected record check box at
     *
     * @param $request
     * @return [return json to process ajax]
     */
    public function deleteNotifications(Request $request)
    {
        $this->notificationRepository->deleteCheckbox($request);

        return response()->json(['success' => true, 'message' => 'delete notifications']);
    }

    public function censor(Request $request)
    {
        if (isset($_POST['accept'])) {

            if ($request->type_notify == NOTIFY_APPLY && $request->censor_id != null) {
                $job_university = DB::table('job_university')
                    ->where('id', $request->censor_id)
                    ->where('status', PENDING_APPROVE)
                    ->whereNull('deleted_at')
                    ->update(['status' => APPROVED]);

                if (empty($job_university)) {
                    return back()->with('info', 'Cập nhật không thành công, công việc này có thể đã bị thay đổi hoặc xóa!');
                } else {
                    $dataNotify = DB::table('job_university')
                        ->where('id', $request->censor_id)->first();

                    $job = $this->jobRepository->findById($dataNotify->job_id);

                    $this->notificationRepository->create([
                        'sender_id' => $request->receiver_id,
                        'receiver_id' => $request->sender_id,
                        'type' => NOTIFY_FEEDBACK,
                        'title' => ACCEPT_APPLY_JOB,
                        'message' => 'Bạn đã đứng tuyển công việc ' . $job->title . ' thành công',
                    ]);
                }
            }

            if ($request->type_notify == NOTIFY_JOIN && $request->censor_id != null) {
                $workshop_enterprise = DB::table('workshop_enterprise')
                    ->where('id', $request->censor_id)
                    ->where('status', PENDING_APPROVE)
                    ->whereNull('deleted_at')
                    ->update(['status' => APPROVED]);

                if (empty($workshop_enterprise)) {
                    return back()->with('info', 'Cập nhật không thành công, hội thảo này có thể đã bị thay đổi hoặc xóa!');
                } else {
                    $dataNotify = DB::table('workshop_enterprise')
                        ->where('id', $request->censor_id)->first();

                    $workshop = $this->workShopRepository->findById($dataNotify->workshop_id);

                    $this->notificationRepository->create([
                        'sender_id' => $request->receiver_id,
                        'receiver_id' => $request->sender_id,
                        'type' => NOTIFY_FEEDBACK,
                        'title' => ACCEPT_JOIN_WORKSHOP,
                        'message' => 'Bạn đã tham gia hội thảo ' . $workshop->title . ' thành công',
                    ]);
                }
            }


            if ($request->type_notify == NOTIFY_COOPERATE && $request->censor_id != null) {
                $collaborations = DB::table('collaborations')
                    ->where('id', $request->censor_id)
                    ->where('status', PENDING_APPROVE)
                    ->whereNull('deleted_at')
                    ->update(['status' => APPROVED]);

                if (empty($collaborations)) {
                    return back()->with('info', 'Cập nhật không thành công, liên kết này có thể đã bị thay đổi hoặc xóa!');
                } else {
                    $this->notificationRepository->create([
                        'sender_id' => $request->receiver_id,
                        'receiver_id' => $request->sender_id,
                        'type' => NOTIFY_FEEDBACK,
                        'title' => ACCEPT_COLLABORATION,
                        'message' => ACCEPT_COLLABORATION,
                    ]);
                }
            }

        }



        if (isset($_POST['reject'])) {

            if ($request->type_notify == NOTIFY_APPLY && $request->censor_id != null) {
                $job_university = DB::table('job_university')
                    ->where('id', $request->censor_id)
                    ->where('status', PENDING_APPROVE)
                    ->whereNull('deleted_at')
                    ->update(['status' => UN_APPROVE]);

                if (empty($job_university)) {
                    return back()->with('info', 'Cập nhật không thành công, công việc này có thể đã bị thay đổi hoặc xóa!');
                } else {
                    $dataNotify = DB::table('job_university')
                        ->where('id', $request->censor_id)->first();

                    $job = $this->jobRepository->findById($dataNotify->job_id);

                    $this->notificationRepository->create([
                        'sender_id' => $request->receiver_id,
                        'receiver_id' => $request->sender_id,
                        'type' => NOTIFY_FEEDBACK,
                        'title' => REJECT_APPLY_JOB,
                        'message' => 'Rất tiếc bạn không phù hợp với công việc ' . $job->title . ' của chúng tôi.',
                    ]);
                }
            }

            if ($request->type_notify == NOTIFY_JOIN && $request->censor_id != null) {
                $workshop_enterprise = DB::table('workshop_enterprise')
                    ->where('id', $request->censor_id)
                    ->where('status', PENDING_APPROVE)
                    ->whereNull('deleted_at')
                    ->update(['status' => UN_APPROVE]);

                if (empty($workshop_enterprise)) {
                    return back()->with('info', 'Cập nhật không thành công, hội thảo này có thể đã bị thay đổi hoặc xóa!');
                } else {
                    $dataNotify = DB::table('workshop_enterprise')
                        ->where('id', $request->censor_id)->first();

                    $workshop = $this->workShopRepository->findById($dataNotify->workshop_id);

                    $this->notificationRepository->create([
                        'sender_id' => $request->receiver_id,
                        'receiver_id' => $request->sender_id,
                        'type' => NOTIFY_FEEDBACK,
                        'title' => REJECT_JOIN_WORKSHOP,
                        'message' => 'Rất tiếc bạn không phù hợp với hội thảo ' . $workshop->title . ' của chúng tôi.',
                    ]);
                }
            }


            if ($request->type_notify == NOTIFY_COOPERATE && $request->censor_id != null) {
                $collaborations = DB::table('collaborations')
                    ->where('id', $request->censor_id)
                    ->where('status', PENDING_APPROVE)
                    ->whereNull('deleted_at')
                    ->update(['status' => UN_APPROVE]);

                if (empty($collaborations)) {
                    return back()->with('info', 'Cập nhật không thành công, liên kết này có thể đã bị thay đổi hoặc xóa!');
                } else {
                    $this->notificationRepository->create([
                        'sender_id' => $request->receiver_id,
                        'receiver_id' => $request->sender_id,
                        'type' => NOTIFY_FEEDBACK,
                        'title' => REJECT_COLLABORATION,
                        'message' => REJECT_COLLABORATION,
                    ]);
                }
            }

        }

        return back()->with('success', 'Cập nhật thành công');
    }
}
