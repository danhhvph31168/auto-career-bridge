<?php

namespace App\Services\Admin;

use App\Notifications\WorkshopApprove;
use App\Notifications\WorkshopDeletionNotice;
use App\Repositories\Notification\NotificationRepository;
use App\Repositories\University\Workshop\WorkShopRepository;
use App\Repositories\Users\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WorkshopService
{

    protected $workShopRepository;
    protected $notificationRepository;

    public function __construct(
        WorkShopRepository $workShopRepository,
        NotificationRepository $notificationRepository,
        protected UserRepositoryInterface $userRepository
    ) {
        $this->workShopRepository = $workShopRepository;
        $this->notificationRepository = $notificationRepository;
    }

    public function getWorkshop($condition = [])
    {
        $perPage = $condition['perpage'] ?? 5;
        $condition = [
            'title' => $condition['title'] ?? '',
            'status' => $condition['status'] ?? '',
            'start_date' => $condition['start_date'] ?? '',
            'end_date' => $condition['end_date'] ?? '',
            'province' => $condition['province'] ?? '',
            'major' => $condition['major'] ?? '',
            'page' => $condition['page'] ?? 'client',
        ];
        $workshops = $this->workShopRepository->getWorkShop($condition, $perPage);

        return $workshops;
    }

    public function approve($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $workshop = $this->workShopRepository->findById($id);
                $university = $workshop->university;
                if ($workshop->status === 0 && !empty($workshop)) {
                    $data = [
                        'status' => APPROVED,
                    ];
                    $workshop = $this->workShopRepository->update($id, $data);
                    $university->notify(new WorkshopApprove($workshop));

                    $dataNotification = [
                        'sender_id' => auth()->id(),
                        'receiver_id' => $this->userRepository->getUserAdminUniversity($university->id)->first()->id,
                        'type' => 'Phê duyệt workshop',
                        'title' => 'Phê duyệt workshop',
                        'message' => 'Workshop của bạn đã được phê duyệt',
                    ];
                    $this->notificationRepository->create($dataNotification);
                }
            }, 2);

            return true;
        } catch (\Exception $e) {
            Log::error('ERROR APPROVE WORKSHOP ' . $e->getMessage());

            return false;
        }
    }

    public function reject($id, $reason)
    {
        try {
            DB::transaction(function () use ($id, $reason) {
                $workshop = $this->workShopRepository->findById($id);
                $university = $workshop->university;
                if ($workshop->status === 0 && !empty($workshop)) {
                    $dataReject = [
                        'status' => UN_APPROVE,
                    ];
                    $workshop = $this->workShopRepository->update($id, $dataReject);
                    $university->notify(new WorkshopApprove($workshop, $reason));

                    $dataNotification = [
                        'sender_id' => auth()->id(),
                        'receiver_id' =>  $this->userRepository->getUserAdminUniversity($university->id)->first()->id,
                        'type' => 'Phê duyệt workshop',
                        'title' => 'Yêu cầu bị từ chối',
                        'message' => $reason,
                    ];
                    $this->notificationRepository->create($dataNotification);
                }
            });

            return true;
        } catch (\Exception $e) {
            Log::error('ERROR REJECT WORKSHOP ' . $e->getMessage());

            return false;
        }
    }

    public function destroy($id)
    {
        $workshop = $this->workShopRepository->findById($id);
        $university = $workshop->university;
        try {
            DB::transaction(function () use ($workshop, $university) {
                if (empty($university)) {
                    $workshop->delete();

                    return true;
                }
                foreach ($workshop->majors as $major) {
                    $workshop->majors()->updateExistingPivot($major->id, ['deleted_at' => now()]);
                }
                foreach ($workshop->enterprises as $enterprise) {
                    $enterprise->notify(new WorkshopDeletionNotice($workshop));
                    $workshop->enterprises()->updateExistingPivot($enterprise->id, ['deleted_at' => now()]);
                }

                $university->notify(new WorkshopDeletionNotice($workshop));
                $workshop->delete();
            }, 2);

            return true;
        } catch (\Exception $e) {
            Log::error('ERROR DELETE WROKSHOP ' . $e->getMessage());

            return false;
        }
    }
}
