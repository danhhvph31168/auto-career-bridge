<?php

namespace App\Services\Admin;

use App\Notifications\AccountDeletionNotice;
use App\Notifications\UniversityApprove;
use App\Repositories\Notification\NotificationRepository;
use App\Repositories\University\UniversityRepository;
use App\Repositories\Users\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UniversityService
{
    protected $userRepository;
    protected $universityRepository;
    protected $notificationRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UniversityRepository $universityRepository,
        NotificationRepository $notificationRepository
    ) {
        $this->userRepository = $userRepository;
        $this->universityRepository = $universityRepository;
        $this->notificationRepository = $notificationRepository;
    }

    public function getUniversityAccount($condition = [])
    {
        $condition = [
            'keyword' => $condition['keyword'] ?? '',
            'status' => $condition['status'] ?? '',
            'perpage' => $condition['perpage'] ?? 5
        ];

        return $this->userRepository->getUniversityAccount($condition);
    }

    public function approve($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $user = $this->userRepository->findById($id);
                if ($user->status === 0 && !empty($user)) {
                    $data = [
                        'status' => APPROVED,
                        'is_active' => IS_ACTIVE
                    ];
                    $user = $this->userRepository->update($id, $data);
                    $university = $user->university();
                    $university->update(['is_verify' => APPROVED]);
                    $user->notify(new UniversityApprove());

                    $dataNotification = [
                        'sender_id' => auth()->id(),
                        'receiver_id' => $id,
                        'type' => 'Phê duyệt tài khoản',
                        'title' => 'Phê duyệt tài khoản',
                        'message' => 'Tài khoản của bạn đã được phê duyệt',
                    ];
                    $this->notificationRepository->create($dataNotification);
                }
            }, 2);

            return true;
        } catch (\Exception $e) {
            Log::error('ERROR APPROVE ACCOUNT ' . $e->getMessage());

            return false;
        }
    }

    public function reject($id, string $reason = '')
    {
        try {
            DB::transaction(function () use ($id, $reason) {
                $user = $this->userRepository->findById($id);
                if ($user->status === 0 && !empty($user)) {
                    $dataReject = [
                        'status' => UN_APPROVE,
                        'is_active' => IS_ACTIVE
                    ];
                    $user = $this->userRepository->update($id, $dataReject);
                    $user->notify(new UniversityApprove($reason));

                    $dataNotification = [
                        'sender_id' => auth()->id(),
                        'receiver_id' => $id,
                        'type' => 'Phê duyệt tài khoản',
                        'title' => 'Yêu cầu bị từ chối',
                        'message' => $reason,
                    ];
                    $this->notificationRepository->create($dataNotification);
                }
            });

            return true;
        } catch (\Exception $e) {
            Log::error('ERROR REJECT ACCOUNT ' . $e->getMessage());

            return false;
        }
    }

    public function destroy($id)
    {
        $user = $this->userRepository->findById($id);
        $university = $user->university;
        try {
            DB::transaction(function () use ($user, $university) {
                if (empty($university)) {
                    $user->delete();
                    return true;
                }
                $workshops = $university->workshops;
                foreach ($workshops as $workshop) {
                    foreach ($workshop->majors as $major) {
                        $workshop->majors()->updateExistingPivot($major->id, ['deleted_at' => now()]);
                    }

                    foreach ($workshop->enterprises as $enterprise) {
                        $enterprise->notify(new AccountDeletionNotice($workshop));
                        $workshop->enterprises()->updateExistingPivot($enterprise->id, ['deleted_at' => now()]);
                    }

                    $workshop->delete();
                }

                foreach ($university->majors as $major) {
                    $university->majors()->updateExistingPivot($major->id, ['deleted_at' => now()]);
                }

                foreach ($university->enterprises as $enterprise) {
                    $enterprise->notify(new AccountDeletionNotice($university));
                    $university->enterprises()->updateExistingPivot($enterprise->id, ['deleted_at' => now()]);
                }

                foreach ($university->jobs as $job) {
                    $enterprise = $job->enterprises;
                    $enterprise->notify(new AccountDeletionNotice($job));
                    $university->jobs()->updateExistingPivot($job->id, ['deleted_at' => now()]);
                }

                $this->notificationRepository->getModel()::where('receiver_id', $user->id)->orWhere('sender_id', $user->id)->delete();
                $university->delete();
                $user->delete();
                $university->notify(new UniversityApprove());
            }, 2);

            return true;
        } catch (\Exception $e) {
            Log::error('ERROR DELETE ACCOUNT ' . $e->getMessage());

            return false;
        }
    }
}
