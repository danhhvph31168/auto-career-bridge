<?php

namespace App\Services\Client;

use App\Repositories\University\Workshop\WorkShopRepositoryInterface;
use App\Repositories\Notification\NotificationRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkshopService
{
    protected $workshopRepository;
    protected $notificationRepository;

    public function __construct(
        WorkShopRepositoryInterface $workshopRepository,
        NotificationRepository $notificationRepository,
    ) {
        $this->workshopRepository = $workshopRepository;
        $this->notificationRepository = $notificationRepository;
    }

    public function join()
    {
        $user = Auth::user();

        $universities = $this->workshopRepository->getAdminUser(request()->workshopId);

        if (!$user->university) {
            $exists = $this->workshopRepository->checkJoinExists($user->enterprise, request()->workshopId);
        } else {
            $exists = false;
        }

        try {
            DB::beginTransaction();

            if ($user->user_type == TYPE_ENTERPRISE && $user->role_id == ROLE_ADMIN) {

                if (!$exists) {
                    $user->enterprise->workshops()->attach(request()->workshopId);

                    $this->notificationRepository->create([
                        'sender_id' => $user->id,
                        'receiver_id' => $universities->id,
                        'title' => NOTIFY_TITLE_JOIN,
                        'message' => request()->message,
                        'type' => NOTIFY_JOIN,
                        'censor_id' => $this->workshopRepository->getIdWorkshopEnterprise(request()->workshopId, $user->enterprise->id),
                    ]);

                } else {
                    return ['status' => 'info', 'message' => 'Bạn đã tham gia vào hội thảo này rồi!'];
                }

            } else {
                return ['status' => 'info', 'message' => 'Tài khoản của bạn chưa phù hợp để tham gia!'];
            }

            DB::commit();

            return ['status' => 'success', 'message' => 'Bạn đã gửi yêu cầu tham gia thành công'];

        } catch (\Throwable $th) {
            DB::rollBack();

            return ['status' => 'error', 'message' => $th->getMessage()];
        }

    }
}
