<?php

namespace App\Repositories\University\Workshop;

use App\Models\Enterprise;
use App\Models\Workshop;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class WorkShopRepository extends BaseRepository implements WorkShopRepositoryInterface
{
    /**
     * Return the corresponding model.
     *
     * @return string The class name of the model.
     */
    public function getModel()
    {

        return Workshop::class;
    }

    /**
     * Check condition to get query then return view + paginate
     *
     * @param array $condition
     * @param int $perPage
     *
     * @return [type]
     */
    public function getWorkShop(array $condition = [], int $perPage = 10)
    {
        $university_id = $condition['university_id'] ?? null;
        $query = $this->getModel()::query();
        if (auth()->check() && auth()->user()->enterprise_id) {
            $query = $this->getWorkshopsWithPriority($query);
        }
        if ($university_id) {
            $query->where('university_id', $university_id);
        }
        if (!empty($condition['title'])) {
            $query->where('title', 'LIKE', '%' . $condition['title'] . '%');
        }
        if (!empty($condition['start_date']) && !empty($condition['end_date'])) {
            $query->where(function ($query) use ($condition) {
                $query->whereBetween('start_date', [$condition['start_date'], $condition['end_date']])
                    ->orWhereBetween('end_date', [$condition['start_date'], $condition['end_date']])
                    ->orWhere(function ($query) use ($condition) {
                        $query->where('start_date', '<=', $condition['start_date'])
                            ->where('end_date', '>=', $condition['end_date']);
                    });
            });
        } elseif (!empty($condition['start_date'])) {
            $query->where(function ($query) use ($condition) {
                $query->where('start_date', '>=', $condition['start_date'])
                    ->orWhere('end_date', '>=', $condition['start_date']);
            });
        } elseif (!empty($condition['end_date'])) {
            $query->where(function ($query) use ($condition) {
                $query->where('start_date', '<=', $condition['end_date'])
                    ->orWhere('end_date', '<=', $condition['end_date']);
            });
        }
        if (isset($condition['page']) && !empty($condition['page'])) {
            if ($condition['page'] === 'client') {
                $query->where('workshops.status', APPROVED)
                    ->where('workshops.is_active', IS_ACTIVE)
                    ->where('workshops.end_date', '>=', now()->toDateString())
                    ->where('workshops.start_date', '<=', now()->toDateString());
            } else {
                if (isset($condition['status']) && ($condition['status'] !== '' || $condition['status'] === UN_APPROVE)) {
                    $query->where('status', $condition['status']);
                }
            }
        }

        if (isset($condition['province']) && !empty($condition['province'])) {
            $query->where('workshops.address', 'LIKE', '%' . $condition['province'] . '%');
        }
        if (isset($condition['major']) && !empty($condition['major'])) {
            $query->whereHas('majors', function ($query) use ($condition) {
                $query->where('workshop_major.id', $condition['major']);
            });
        }

        $query->orderBy('id', 'desc');

        return $query->paginate($perPage)->withQueryString();
    }

    public function getWorkshopsWithPriority($query)
    {
        $enterpriseId = auth()->user()->enterprise_id ?? null;

        $query = $query->select('workshops.*')
            ->join('universities', 'universities.id', '=', 'workshops.university_id')
            ->leftJoin('collaborations', function ($join) use ($enterpriseId) {
                $join->on('collaborations.university_id', '=', 'universities.id')
                    ->where('collaborations.enterprise_id', '=', $enterpriseId);
            })
            ->orderByRaw('CASE WHEN collaborations.id IS NOT NULL THEN 0 ELSE 1 END')
            ->orderBy('workshops.created_at', 'desc');

        return $query;
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
        return DB::table('workshop_enterprise')
            ->where('status', $status)
            ->whereYear('created_at', $year)
            ->count('workshop_id');
    }

    public function countApplyByMonth(int $status, int $year)
    {
        return DB::table('workshop_enterprise')
            ->select(DB::raw('MONTH(created_at) as month, COUNT(workshop_id) as workshop_count'))
            ->whereYear('created_at', $year)
            ->where('status', $status)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('workshop_count', 'month');
    }

    public function updateApplyStatus(int $status, Workshop $workshop, Enterprise $enterprise)
    {
        return $workshop->enterprises()->updateExistingPivot($enterprise->id, ['status' => $status]);
    }

    public function checkJoinExists($enterprise, $workshopId)
    {
        return $enterprise->workshops()
            ->wherePivot('workshop_id', $workshopId)
            ->exists();
    }

    public function checkJoinSuccess($enterprise, $workshopId)
    {
        return $enterprise->workshops()
            ->wherePivot('workshop_id', $workshopId)
            ->wherePivot('status', APPROVED)
            ->exists();
    }

    public function checkJoinRefuse($enterprise, $workshopId)
    {
        return $enterprise->workshops()
            ->wherePivot('workshop_id', $workshopId)
            ->wherePivot('status', UN_APPROVE)
            ->exists();
    }

    public function getAdminUser($workshopId)
    {
        return Workshop::query()->findOrFail($workshopId)
            ->university->users()->where('role_id', ROLE_ADMIN)->firstOrFail();
    }

    public function getIdWorkshopEnterprise($workshopId, $enterpriseId)
    {
        return DB::table('workshop_enterprise')
            ->where('workshop_id', $workshopId)
            ->where('enterprise_id', $enterpriseId)
            ->latest('id')
            ->value('id');
    }
}
