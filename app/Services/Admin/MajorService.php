<?php

namespace App\Services\Admin;

use App\Repositories\Major\MajorRepository;
use App\Repositories\Notification\NotificationRepository;
use App\Repositories\Users\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MajorService
{
    public $majorRepository;
    public $notificationRepository;

    public function __construct(
        MajorRepository $majorRepository,
        NotificationRepository $notificationRepository,
        protected UserRepositoryInterface $userRepository
    ) {
        $this->majorRepository = $majorRepository;
        $this->notificationRepository = $notificationRepository;
    }

    public function getMajorApprove($condition)
    {
        $condition = [
            'keyword' => $condition['keyword'],
            'status' => $condition['status'],
            'page' => $condition['page'],
        ];
        $perpage = $condition['perpage'] ?? 10;

        return $this->majorRepository->getMajorUniversity($condition, $perpage);
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $data = $request->only([
                'name',
                'description',
            ]);

            $this->majorRepository->create($data + ['status' => IS_ACTIVE]);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);

            return false;
        }
    }

    public function approve($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $major = $this->majorRepository->findById($id);
                $university_id = DB::table('university_major')->where('major_id', $id)->orderBy('created_at')->first()->university_id;
                if ($major->status === 0 && !empty($major)) {
                    $data = [
                        'status' => APPROVED,
                    ];
                    $major->update($data);

                    $dataNotification = [
                        'sender_id' => auth()->id(),
                        'receiver_id' => $this->userRepository->getUserAdminUniversity($university_id)->first()->id,
                        'type' => 'Phê duyệt major',
                        'title' => 'Phê duyệt major',
                        'message' => 'major của bạn đã được phê duyệt',
                    ];
                    $this->notificationRepository->create($dataNotification);
                }
            }, 2);

            return true;
        } catch (\Exception $e) {
            Log::error('ERROR APPROVE MAJOR ' . $e->getMessage());

            return false;
        }
    }

    public function reject($id, $reason)
    {
        try {
            DB::transaction(function () use ($id, $reason) {
                $major = $this->majorRepository->findById($id);
                $university_id = DB::table('university_major')->where('major_id', $id)->orderBy('created_at')->first()->university_id;
                if ($major->status === 0 && !empty($major)) {
                    $dataReject = [
                        'status' => UN_APPROVE,
                    ];
                    $major->update($dataReject);

                    $dataNotification = [
                        'sender_id' => auth()->id(),
                        'receiver_id' => $this->userRepository->getUserAdminUniversity($university_id)->first()->id,
                        'type' => 'Phê duyệt major',
                        'title' => 'Yêu cầu bị từ chối',
                        'message' => $reason,
                    ];
                    $this->notificationRepository->create($dataNotification);
                }
            });

            return true;
        } catch (\Exception $e) {
            Log::error('ERROR REJECT MAJOR ' . $e->getMessage());

            return false;
        }
    }

    public function destroy($id)
    {
        $major = $this->majorRepository->findById($id);
        $university = DB::table('university_major')->where('major_id', $id)->orderBy('created_at')->first();
        try {
            DB::transaction(function () use ($major, $university) {
                if (!$university) {
                    $major->delete();

                    return true;
                }

                $dataNotification = [
                    'sender_id' => auth()->id(),
                    'receiver_id' => $this->userRepository->getUserAdminUniversity($university->university_id)->first()->id,
                    'type' => 'Phê duyệt major',
                    'title' => 'Yêu cầu bị từ chối',
                    'message' => 'Major đã bị xóa',
                ];
                $this->notificationRepository->create($dataNotification);

                $major->delete();
                $major->universities()->detach();
            }, 2);

            return true;
        } catch (\Exception $e) {
            Log::error('ERROR DELETE MAJOR ' . $e->getMessage());

            return false;
        }
    }
}
