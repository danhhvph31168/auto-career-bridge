<?php

namespace App\Repositories\Job;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Job\JobRepositoryInterface;

class JobRepository extends BaseRepository implements JobRepositoryInterface
{
    public function getModel()
    {
        return Job::class;
    }

    public function pagination(array $condition, array $collum = ['*'], int $perpage = 10)
    {
        $query = $this->getModel()::where('jobs.status', APPROVED)->where('jobs.is_active', IS_ACTIVE);
        $query = $this->getJobsWithPriority($query);
        $query = $this->search($condition['search'], $query);
        $query = $this->filter($condition['filter'], $query);

        return $query->paginate($perpage, $collum)->withQueryString();
    }

    public function getJobsWithPriority($query)
    {
        $universityId = auth()->user()->university_id ?? null;

        $query = $query->select('jobs.*')
            ->join('enterprises', 'enterprises.id', '=', 'jobs.enterprise_id')
            ->leftJoin('collaborations', function ($join) use ($universityId) {
                $join->on('collaborations.enterprise_id', '=', 'enterprises.id')
                    ->where('collaborations.university_id', '=', $universityId);
            })
            ->orderByRaw('CASE WHEN collaborations.id IS NOT NULL THEN 0 ELSE 1 END')
            ->orderBy('jobs.created_at', 'desc');

        return $query;
    }

    protected function search(array $condition, $query)
    {
        $query = $query->when(isset($condition['keyword']) && !empty($condition['keyword']), function ($query) use ($condition) {
            $query->where(function ($query) use ($condition) {
                $query->where('title', 'LIKE', '%' . $condition['keyword'] . '%')
                    ->orWhereHas('enterprises', function ($query) use ($condition) {
                        $query->where('name', 'LIKE', '%' . $condition['keyword'] . '%');
                    });
            });
        })->when(isset($condition['province']) && !empty($condition['province']), function ($query) use ($condition) {
            $query->where('jobs.address', 'LIKE', '%' . $condition['province'] . '%');
        })->when(isset($condition['major']) && !empty($condition['major']), function ($query) use ($condition) {
            $query->where('jobs.major_id', $condition['major']);
        });

        return $query;
    }

    protected function filter(array $condition, $query)
    {
        if (isset($condition['type']) && !empty($condition['type'])) {
            $query->where('type', $condition['type']);
        }
        if (isset($condition['experience_level']) && !empty($condition['experience_level'])) {
            $query->where('experience_level', 'LIKE', $condition['experience_level']);
        }
        if (isset($condition['minSalary']) && !empty($condition['minSalary'])) {
            $query->where('salary', '>=', $condition['minSalary']);
        }
        if (isset($condition['maxSalary']) && !empty($condition['maxSalary'])) {
            $query->where('salary', '<=', $condition['maxSalary']);
        }

        return $query;
    }

    public function getAllJobsPaginate(int $perPage, array $search)
    {
        $query = $this->_model->with('major')
            ->where('enterprise_id', Auth::user()->enterprise_id ?? abort(403));

        if (!empty($search['keyword'])) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search['keyword'] . '%')
                    ->orWhereHas('major', function ($query) use ($search) {
                        $query->where('name', 'LIKE', '%' . $search['keyword'] . '%');
                    });
            });
        }

        if (!empty($search['start_date'])) {
            $search['start_date'] = Carbon::createFromFormat('d/m/Y', $search['start_date'])->format('Y-m-d');
        }
        if (!empty($search['end_date'])) {
            $search['end_date'] = Carbon::createFromFormat('d/m/Y', $search['end_date'])->format('Y-m-d');
        }

        if (!empty($search['start_date']) && !empty($search['end_date'])) {
            $query->where(function ($query) use ($search) {
                $query->whereBetween('start_date', [$search['start_date'], $search['end_date']])
                    ->orWhereBetween('end_date', [$search['start_date'], $search['end_date']])
                    ->orWhere(function ($query) use ($search) {
                        $query->where('start_date', '<=', $search['start_date'])
                            ->where('end_date', '>=', $search['end_date']);
                    });
            });
        } elseif (!empty($search['start_date'])) {
            $query->where('start_date', '>=', $search['start_date']);
        } elseif (!empty($search['end_date'])) {
            $query->where('end_date', '<=', $search['end_date']);
        }

        $query->orderBy('id', 'desc');

        return $query->paginate($perPage)->withQueryString();
    }


    public function updateManyStatusJobs(array $jobIds, int $is_active)
    {
        $result = [];

        $currentDate = Carbon::now();

        $result["id_invalid"] = $this->_model::whereIn('id', $jobIds)
            ->where(function ($query) use ($currentDate) {
                $query->where('start_date', '>', $currentDate->toDateString())
                    ->orWhere('end_date', '<', $currentDate->toDateString());
            })
            ->pluck('id')->toArray();

        $result['update'] = $this->_model::whereIn('id', $jobIds)
            ->where('start_date', '<=', $currentDate->toDateString())
            ->where('end_date', '>=', $currentDate->toDateString())
            ->update(['is_active' => $is_active, 'changeByUser' => now()]);

        return $result;
    }

    public function updateApplyStatus(int $status, Job $job, University $university)
    {
        if ($status == APPROVED) {
            $job->increment('applicants');
        }

        return $job->universities()->updateExistingPivot($university->id, ['status' => $status]);
    }

    public function countAccept()
    {
        return $this->_model->where('status', APPROVED)->count();
    }

    public function sumApplicants(int $year)
    {
        return $this->_model
            ->whereYear('created_at', $year)
            ->sum('applicants');
    }

    public function countApply(int $status, int $year)
    {
        return DB::table('job_university')
            ->where('status', $status)
            ->whereYear('created_at', $year)
            ->count('job_id');
    }

    public function countApplyByMonth(int $status, int $year)
    {
        return DB::table('job_university')
            ->select(DB::raw('MONTH(created_at) as month, COUNT(job_id) as job_count'))
            ->whereYear('created_at', $year)
            ->where('status', $status)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('job_count', 'month');
    }

    public function checkApplyExists($university, $jobId)
    {
        return $university->jobs()
            ->wherePivot('job_id', $jobId)
            ->exists();
    }

    public function checkApplySuccess($university, $jobId)
    {
        return $university->jobs()
            ->wherePivot('job_id', $jobId)
            ->wherePivot('status', APPROVED)
            ->exists();
    }

    public function checkApplyRefuse($university, $jobId)
    {
        return $university->jobs()
            ->wherePivot('job_id', $jobId)
            ->wherePivot('status', UN_APPROVE)
            ->exists();
    }

    public function getAdminUser($jobId)
    {
        return Job::query()->findOrFail($jobId)
            ->enterprises->users()->where('role_id', ROLE_ADMIN)->firstOrFail();
    }

    public function getIdJobUniversity($jobID, $universityId)
    {
        return DB::table('job_university')
            ->where('job_id', $jobID)
            ->where('university_id', $universityId)
            ->latest('id')
            ->value('id');
    }
}
