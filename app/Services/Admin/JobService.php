<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Notifications\JobApprove;
use App\Notifications\JobDeletedNotificationForEnterprise;
use App\Notifications\JobDeletedNotificationForUniversity;
use App\Repositories\Admin\Job\JobRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Users\UserRepositoryInterface;
use App\Services\NotificationService;

class JobService
{

    protected $jobRepository;
    protected $notificationService;

    public function __construct(JobRepositoryInterface $jobRepository, NotificationService $notificationService)

    {
        $this->jobRepository = $jobRepository;
        $this->notificationService = $notificationService;
    }

    public function getAll($request)
    {
        $search = $request->only(['q', 'status']);
        return $this->jobRepository->getAllJob(10, $search);
    }

    public function findById($id)
    {
        return $this->jobRepository->findById($id);
    }

    public function approve($id)
    {
        $job = $this->jobRepository->findById($id);
        DB::beginTransaction();
        try {
            if ($job && $job->status === PENDING_APPROVE) {
                $this->jobRepository->update($id, ['status' => APPROVED, 'is_active' => IS_ACTIVE]);
                $enterprise_admin = User::where('enterprise_id', $job->enterprise_id)->first();
                if ($enterprise_admin) {
                    $enterprise_admin->notify(new JobApprove($job, $enterprise_admin->username, null));

                    $super_admin = User::where('user_type', 'super-admin')->first();

                    $data_notify = [
                        'type' => 'system',
                        'title' => 'Thông báo phê duyệt job',
                        'message' => 'Tin đăng job: ' . $job->title . ' đã được phê duyệt',
                    ];

                    $this->notificationService->createNotification($super_admin->id, $enterprise_admin->id, $data_notify);
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function unApprove(string $reason, $id)
    {
        $job = $this->jobRepository->findById($id);
        DB::beginTransaction();
        try {
            if ($job && $job->status === PENDING_APPROVE) {
                $this->jobRepository->update($id, [
                    'status' => UN_APPROVE,
                    'rejection_reason' => $reason
                ]);

                $enterprise_admin = User::where('enterprise_id', $job->enterprise_id)->first();
                if ($enterprise_admin) {
                    $enterprise_admin->notify(new JobApprove($job, $enterprise_admin->username, $reason));

                    $super_admin = User::where('user_type', 'super-admin')->first();

                    $data_notify = [
                        'type' => 'system',
                        'title' => 'Thông báo huỷ phê duyệt job',
                        'message' => 'Tin đăng Job: ' . $job->title . ' bị huỷ phê duyệt',
                    ];

                    $this->notificationService->createNotification($super_admin->id, $enterprise_admin->id, $data_notify);
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }


    public function destroy($id)
    {
        $super_admin = User::where('user_type', 'super-admin')->first();
        DB::beginTransaction();
        try {
            $job = $this->jobRepository->findById($id);

            if ($job) {
                if (
                    $job->status == UN_APPROVE ||
                    $job->status == PENDING_APPROVE ||
                    ($job->status == APPROVED && DB::table('job_university')->where('job_id', $job->id)->count() == 0) ||
                    $job->end_date < now()
                ) {
                    DB::table('job_university')
                        ->where('job_id', $job->id)
                        ->update(['deleted_at' => now()]);

                    $job->delete();
                } else {
                    $job_universities = DB::table('job_university')->where('job_id', $job->id)->get();
                    $canDelete = true;
                    $message = '';

                    foreach ($job_universities as $job_university) {
                        if ($job_university->status == 0 || $job_university->status == 1 || $job_university->status == 2) {
                            $canDelete = false;
                            $message = "Công việc đã có trường học tham gia. Vui lòng chờ công việc hết hạn";
                            break;
                        }
                    }

                    if ($canDelete || $job->end_date < now()) {
                        DB::table('job_university')
                            ->where('job_id', $job->id)
                            ->update(['deleted_at' => now()]);

                        $job->delete();
                    } else {
                        DB::rollBack();
                        return $message ?: 'Có lỗi khi xóa công việc';
                    }
                }

                $enterprise_admin = User::where('enterprise_id', $job->enterprise_id)->first();
                if ($enterprise_admin) {
                    $enterprise_admin->notify(new JobDeletedNotificationForEnterprise($job, $enterprise_admin->username));

                    $data_notify = [
                        'type' => 'system',
                        'title' => 'Thông báo xoá công việc',
                        'message' => 'Công việc: ' . $job->title . ' đã bị xoá',
                    ];

                    $this->notificationService->createNotification($super_admin->id, $enterprise_admin->id, $data_notify);
                }

                foreach ($job->universities as $university) {
                    $university_managers = $university->users;
                    foreach ($university_managers as $manager) {
                        $manager->notify(new JobDeletedNotificationForUniversity($job, $manager->username));

                        $data_notify = [
                            'type' => 'system',
                            'title' => 'Thông báo công việc không còn hoạt động',
                            'message' => 'Công việc: ' . $job->title . ' mà bạn tham gia đã không còn hoạt động',
                        ];

                        $this->notificationService->createNotification($super_admin->id, $manager->id, $data_notify);
                    }
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return 'Có lỗi khi xóa công việc';
        }
    }
}
