<?php

namespace App\Services\Client;

use App\Repositories\Job\JobRepositoryInterface;
use App\Repositories\Notification\NotificationRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JobService
{
    protected $jobRepository;
    protected $notificationRepository;


    public function __construct(
        JobRepositoryInterface $jobRepository,
        NotificationRepository $notificationRepository,
    ) {
        $this->jobRepository = $jobRepository;
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * Undocumented function
     *
     * @param array $request
     * @return collection $jobs
     */
    public function pagination($request = [])
    {
        $salary = '';
        if (isset($request['salary'])) {
            $salary = explode(' - ', $request['salary']);
            for ($i = 0; $i < count($salary); $i++) {
                $salary[$i] = str_replace("\u{A0}₫", '', $salary[$i]);
                $salary[$i] = str_replace(".", '', $salary[$i]);
            }
        }

        $condition = [
            'search' => [
                'keyword' => $request['keyword'] ?? '',
                'province' => $request['province'] ?? '',
                'major' => $request['major'] ?? '',
            ],
            'filter' => [
                'type' => $request['type'] ?? '',
                'experience_level' => $request['experience_level'] ?? '',
                'minSalary' => $salary[0] ?? '',
                'maxSalary' => $salary[1] ?? ''
            ]
        ];
        $perpage = $request['perpage'] ?? 10;
        $jobs = $this->jobRepository->pagination($condition, ['*'], $perpage);

        return $jobs;
    }

    public function apply()
    {
        $user = Auth::user();

        $enterprises = $this->jobRepository->getAdminUser(request()->jobId);

        if (!$user->enterprise) {
            $exists = $this->jobRepository->checkApplyExists($user->university, request()->jobId);
        } else {
            $exists = false;
        }

        try {
            DB::beginTransaction();

            if ($user->user_type == TYPE_UNIVERSITY && $user->role_id == ROLE_ADMIN) {

                if (!$exists) {
                    $user->university->jobs()->attach(request()->jobId, ['created_at' => now()]);

                    $this->notificationRepository->create([
                        'sender_id' => $user->id,
                        'receiver_id' => $enterprises->id,
                        'title' => NOTIFY_TITLE_APPLY,
                        'message' => request()->message,
                        'type' => NOTIFY_APPLY,
                        'censor_id' => $this->jobRepository->getIdJobUniversity(request()->jobId, $user->university->id),
                    ]);

                } else {
                    return ['status' => 'info', 'message' => 'Bạn đã ứng tuyển vào công việc này rồi!'];
                }

            } else {
                return ['status' => 'info', 'message' => 'Tài khoản của bạn chưa phù hợp để ứng tuyển!'];
            }

            DB::commit();

            return ['status' => 'success', 'message' => 'Bạn đã gửi yêu cầu ứng tuyển thành công'];

        } catch (\Throwable $th) {
            DB::rollBack();

            return ['status' => 'error', 'message' => $th->getMessage()];
        }

    }
}
