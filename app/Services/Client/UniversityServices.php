<?php

namespace App\Services\Client;

use App\Models\Notification;
use App\Repositories\University\UniversityRepository;
use Illuminate\Support\Facades\DB;
use App\Repositories\NotificationsEnterprises\NotificationRepository;
use Illuminate\Support\Facades\Auth;


class UniversityServices
{
    public function __construct(
        protected UniversityRepository $universityRepository,
        protected NotificationRepository $notificationRepository,
    ) {
    }

    /**
     * call back query in repository then use for to add value of quantity of cooperation to return view
     * @param mixed $filters
     * @param mixed $perPage
     *
     * @return [$universities]
     */
    public function listUniversities($filters, $perPage)
    {
        $universities = $this->universityRepository->getUniversities($filters, $perPage);

        foreach ($universities as $university) {
            $university->numberCooperate = $this->universityRepository->getNumberCooperate($university->id);
        }

        return $universities;
    }

    public function getUniversityDetails($slug)
    {
        $slug = str_replace('-', ' ', $slug);
        $university = $this->universityRepository->findBySlug($slug);

        $enterprisy = $this->universityRepository->getAllEnterpriseToUniversity($university->id, COOPERATE);

        $countMajor = $this->universityRepository->countMajorToUniversity($university->id);

        if (!empty(Auth::user()->enterprise)) {
            $checkCooperate = $this->universityRepository->cooperateExistsSend(Auth::user()->enterprise, $university->id);
            $checkCooperateExists = $this->universityRepository->checkCooperateExists(Auth::user()->enterprise, $university->id);
            $checkCooperateSuccess = $this->universityRepository->checkCooperateSuccess(Auth::user()->enterprise, $university->id);
            $checkCooperateRefuse = $this->universityRepository->checkCooperateRefuse(Auth::user()->enterprise, $university->id);

            if ($checkCooperateExists || $checkCooperateSuccess) {
                $notification = Notification::query()
                    ->where('sender_id', Auth::id())
                    ->where('receiver_id', $university->users()->where('role_id', ROLE_ADMIN)->value('id'))
                    ->where('type', NOTIFY_COOPERATE)
                    ->where('title', '!=', NOTIFY_TITLE_UNCOOPERATE)
                    ->latest('id')
                    ->first();

            } else {
                $notification = false;
            }

        } else {
            $checkCooperate = false;
            $checkCooperateExists = false;
            $checkCooperateSuccess = false;
            $checkCooperateRefuse = false;
            $notification = false;
        }

        return compact(
            'university',
            'enterprisy',
            'countMajor',
            'checkCooperate',
            'checkCooperateExists',
            'checkCooperateSuccess',
            'checkCooperateRefuse',
            'notification',
        );
    }

    /**
     * Process requests for cooperation from businesses to schools
     * @param mixed $universityId
     * @param mixed $title
     * @param mixed $message
     *
     * @return [return appropriate messages]
     */
    public function cooperate($universityId, $title, $message)
    {
        $user = Auth::user();

        $university = $this->universityRepository->findById($universityId);

        $idUserUniversity = $this->universityRepository->getAdminUser($university);

        if (!$user->university && $user->user_type != TYPE_ADMIN) {
            $exists = $this->universityRepository->checkCooperateExists($user->enterprise, $universityId);
            $existsSuccess = $this->universityRepository->checkCooperateSuccess($user->enterprise, $universityId);

            if (isset($_POST['cancel'])) {

                if (!$existsSuccess) {
                    $user->enterprise->universities()->detach(request()->university_id);

                    $notification = Notification::query()
                        ->where('sender_id', $user->id)
                        ->orWhere('receiver_id', $idUserUniversity->id)
                        ->orWhere('type', NOTIFY_COOPERATE)
                        ->latest('id')->first();

                    $notification->forceDelete();

                    return ['status' => 'success', 'message' => 'Bạn đã hủy yêu cầu hợp tác thành công.'];

                } else {

                    $user->enterprise->universities()->detach(request()->university_id);

                    $this->notificationRepository->create([
                        'sender_id' => $user->id,
                        'receiver_id' => $idUserUniversity->id,
                        'title' => NOTIFY_TITLE_UNCOOPERATE,
                        'message' => request()->messageCancel,
                        'type' => NOTIFY_COOPERATE,
                    ]);

                    return ['status' => 'success', 'message' => 'Bạn đã hủy hợp tác thành công.'];
                }

            }

        } else {
            $exists = false;
        }

        try {
            DB::beginTransaction();

            if ($user->user_type == TYPE_ENTERPRISE && $user->role_id == ROLE_ADMIN) {

                if (!$exists) {
                    $user->enterprise->universities()->attach($university->id, [
                        'send_name' => TYPE_ENTERPRISE,
                        'created_at' => now()
                    ]);

                    $this->notificationRepository->create([
                        'sender_id' => $user->id,
                        'receiver_id' => $idUserUniversity->id,
                        'title' => $title,
                        'message' => $message,
                        'type' => NOTIFY_COOPERATE,
                        'censor_id' => $this->universityRepository->getIdCollaborations($university->id, $user->enterprise->id),
                    ]);

                } else {
                    return ['status' => 'info', 'message' => 'Bạn đã gửi yêu cầu hợp tác với trường này rồi, vui lòng đợi phản hồi!'];
                }

            } else {
                return ['status' => 'info', 'message' => 'Tài khoản của bạn chưa phù hợp để hợp tác!'];
            }

            DB::commit();

            return ['status' => 'success', 'message' => 'Bạn đã gửi yêu cầu hợp tác thành công'];

        } catch (\Throwable $th) {
            DB::rollBack();

            return ['status' => 'error', 'message' => $th->getMessage()];
        }
    }
}
