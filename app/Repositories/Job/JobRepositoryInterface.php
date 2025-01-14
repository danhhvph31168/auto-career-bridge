<?php

namespace App\Repositories\Job;

use App\Models\Job;
use App\Models\University;

interface JobRepositoryInterface
{
    public function pagination(array $condition, array $collum = ['*'], int $perpage);

    public function findById($id, array $collum = ['*']);

    public function getAllJobsPaginate(int $perPage, array $search);

    public function updateManyStatusJobs(array $jobIds, int $is_active);

    public function updateApplyStatus(int $status, Job $job, University $university);

    public function countAccept();

    public function sumApplicants(int $year);

    public function countApply(int $status, int $year);

    public function countApplyByMonth(int $status, int $year);

    public function checkApplyExists($university, $jobId);

    public function getAdminUser($jobId);

    public function getIdJobUniversity($jobID, $universityId);

    public function checkApplySuccess($university, $jobId);

    public function checkApplyRefuse($university, $jobId);

}
