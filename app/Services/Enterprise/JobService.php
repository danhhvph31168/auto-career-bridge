<?php

namespace App\Services\Enterprise;

use App\Models\Job;
use App\Models\University;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Job\JobRepositoryInterface;
use App\Repositories\Users\UserRepositoryInterface;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JobService
{
    public function __construct(
        protected JobRepositoryInterface $jobRepository,
        protected NotificationService $notificationService,
        protected UserRepositoryInterface $userRepository,
    ) {}

    public function getAllJobs(int $perPage, array $search)
    {
        return $this->jobRepository->getAllJobsPaginate($perPage, $search);
    }

    public function createJob(array $job)
    {
        try {
            DB::beginTransaction();

            $data = $job + [
                'enterprise_id' => Auth::user()->enterprise_id ?? abort(403),
                'slug' => Str::slug(Str::limit($job['title'], 200)  . ' ' . uniqid()),
            ];

            $result = $this->jobRepository->create($data);

            if (!$result) {
                DB::rollBack();
                return false;
            }

            $notify = [
                'title' => NOTIFY_CREATE_JOB . ' ' . $result->enterprises->name,
                'message' => NOTIFY_CREATE_MESSAGE_JOB,
                'type' => 0,
            ];

            $send_id = Auth::user()?->id;

            $receiver_id = $this->userRepository->getUserSupperAdmin()->first();

            if (!$receiver_id) {
                DB::rollBack();
                return false;
            }

            $notifyResult = $this->notificationService->createNotification($send_id, $receiver_id->id, $notify);

            if (!$notifyResult) {
                DB::rollBack();
                return false;
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('tạo job' . $th->getMessage());
            return false;
        }
    }

    public function updateJob(int $id, array $job)
    {
        try {
            DB::beginTransaction();

            $currentJob = $this->jobRepository->findById($id);

            if ($currentJob->status == IS_ACTIVE) {
                return false;
            }

            $data = $job + [
                'status' => UN_ACTIVE,
            ];

            if ($currentJob->is_active == IS_ACTIVE && $data['is_active'] == UN_ACTIVE) {
                $data['changeByUser'] = now();
            }

            $result =  $this->jobRepository->update($id, $data);

            if (!$result) {
                DB::rollBack();
                return false;
            }

            $notify = [
                'title' => NOTIFY_UPDATE_JOB . ' ' . Auth::user()?->username,
                'message' => NOTIFY_UPDATE_MESSAGE_JOB,
                'type' => 0,
            ];

            $send_id = Auth::user()?->id;

            $receiver_id = $this->userRepository->getUserSupperAdmin()->first();

            if (!$receiver_id) {
                DB::rollBack();
                return false;
            }

            $notify = $this->notificationService->createNotification($send_id, $receiver_id->id, $notify);

            if (!$notify) {
                DB::rollBack();
                return false;
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('cập nhật job' . $th->getMessage());
            return false;
        }
    }

    public function updateManyStatusJobs($data)
    {
        $jobIds = $data['job_ids'];

        $is_active = $data['is_active'];

        return $this->jobRepository->updateManyStatusJobs($jobIds, $is_active);
    }

    public function updateStatusByDate()
    {
        $jobs = $this->jobRepository->getAll();

        $currentDate = Carbon::now();

        foreach ($jobs as $job) {
            $startDate = Carbon::parse($job->start_date)->startOfDay();
            $endDate = Carbon::parse($job->end_date)->endOfDay();

            if ($currentDate->between($startDate, $endDate)) {
                if ($job->changeByUser) {
                    continue;
                }

                $job->is_active = IS_ACTIVE;
            } else {
                $job->is_active = UN_ACTIVE;
            }

            $job->save();
        }
    }

    public function destroyJob(int $id)
    {
        $job = $this->jobRepository->findById($id);

        if (!$job) return false;

        if ($job->status == IS_ACTIVE) {
            return false;
        }

        return $this->jobRepository->destroy($id);
    }

    public function updateApplyStatus(int $status, Job $job, University $university)
    {
        $result = $this->jobRepository->updateApplyStatus($status, $job, $university);

        if (!$result) return false;

        $data = [
            'title' => $status == APPROVED ? ACCEPT_APPLY_JOB : REJECT_APPLY_JOB,
            'message' => '',
            'type' => 0,
        ];

        $send_id = Auth::user()?->id;

        $receiver_id = $this->userRepository->getUserAdminUniversity($university->id)->first();

        if (!$receiver_id) return false;

        return $this->notificationService->createNotification($send_id, $receiver_id->id, $data);
    }
}
