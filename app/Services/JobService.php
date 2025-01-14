<?php

namespace App\Services;

use App\Repositories\Job\JobRepositoryInterface;

class JobService
{
    protected $jobRepository;

    public function __construct(JobRepositoryInterface $jobRepository)
    {
        $this->jobRepository = $jobRepository;
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

    public function getDashboardData(int $year)
    {
        $countAll = $this->jobRepository->countAll();

        $countAccept = $this->jobRepository->countAccept();

        $acceptPercentage = ($countAll > 0 && $countAccept > 0)  ? round(($countAccept / $countAll) * 100) : 0;

        $countApplicants = $this->jobRepository->sumApplicants($year);

        $countApplyPending = $this->jobRepository->countApply(PENDING_APPROVE, $year);

        $countApplyNotAccept = $this->jobRepository->countApply(UN_APPROVE, $year);

        $countApplyAccept = $this->jobRepository->countApply(APPROVED, $year);

        $countApplyAcceptByMonthRaw = $this->jobRepository->countApplyByMonth(APPROVED, $year);

        $countApplyNotAcceptByMonthRaw = $this->jobRepository->countApplyByMonth(UN_APPROVE, $year);

        $countApplyPendingByMonthRaw = $this->jobRepository->countApplyByMonth(PENDING_APPROVE, $year);

        $countApplyAcceptByMonth = [];
        $countApplyNotAcceptByMonth = [];
        $countApplyPendingByMonth = [];

        for ($month = 1; $month <= 12; $month++) {
            $countApplyAcceptByMonth[] = $countApplyAcceptByMonthRaw[$month] ?? 0;
            $countApplyNotAcceptByMonth[] = $countApplyNotAcceptByMonthRaw[$month] ?? 0;
            $countApplyPendingByMonth[] = $countApplyPendingByMonthRaw[$month] ?? 0;
        }

        return [
            'countAll' => $countAll,
            'countAccept' => $countAccept,
            'acceptPercentage' => $acceptPercentage,
            'countApplicants' => $countApplicants,
            'countApplyPending' => $countApplyPending,
            'countApplyNotAccept' => $countApplyNotAccept,
            'countApplyAccept' => $countApplyAccept,
            'countApplyAcceptByMonth' => $countApplyAcceptByMonth,
            'countApplyNotAcceptByMonth' => $countApplyNotAcceptByMonth,
            'countApplyPendingByMonth' => $countApplyPendingByMonth,
        ];
    }
}
