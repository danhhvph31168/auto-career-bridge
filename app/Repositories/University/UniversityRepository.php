<?php

namespace App\Repositories\University;

use App\Models\{Enterprise, University};
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UniversityRepository extends BaseRepository implements UniversityRepositoryInterface
{
    public function getModel()
    {
        return University::class;
    }

    /**
     * check condition to get each query then return view + process ajax
     * @param mixed $filters
     * @param mixed $perPage
     *
     * @return [return pagination query]
     */
    public function getUniversities($filters, $perPage)
    {
        $query = University::query()->where('is_verify', IS_ACTIVE);

        if (!empty($filters['major_id'])) {
            $query->whereHas('majors', function ($q) use ($filters) {
                $q->where('major_id', $filters['major_id']);
            });
        }

        if (!empty($filters['search_name'])) {
            $query->where('name', 'LIKE', "%{$filters['search_name']}%");
        }

        if (!empty($filters['province'])) {
            $province = preg_replace('/^(Thành phố|Tỉnh)\s+/', '', $filters['province']);
            $query->where('address', 'LIKE', "%{$province}%");
        }

        $query->leftJoin('collaborations', 'universities.id', '=', 'collaborations.university_id')
            ->select('universities.*', DB::raw('COUNT(CASE WHEN collaborations.status = 1 THEN 1 END) as numberCooperate'))
            ->where(function ($q) {
                $q->where('collaborations.status', COOPERATE)
                    ->orWhere('collaborations.status', UN_COOPERATE)
                    ->orWhereNull('collaborations.status');
            })
            ->groupBy('universities.id')
            ->orderByDesc('numberCooperate');

        return $query->paginate($perPage);
    }

    /**
     * Calculate the number of collaborations with status 1 for each school id
     * @param mixed $universityId
     *
     * @return [type]
     */
    public function getNumberCooperate($universityId)
    {
        return DB::table('collaborations')
            ->where('status', COOPERATE)
            ->where('university_id', $universityId)
            ->count();
    }

    /**
     * get a record by slug
     * @param mixed $slug
     *
     * @return University
     */
    public function findBySlug($slug)
    {
        return University::where('name', $slug)->firstOrFail();
    }

    /**
     * Get all school cooperation businesses with successful cooperation status
     * @param mixed $universityId
     * @param mixed $status
     *
     * @return [Enterprise]
     */
    public function getAllEnterpriseToUniversity($universityId, $status)
    {
        return Enterprise::query()
            ->whereHas('universities', function ($query) use ($universityId, $status) {
                $query->where('university_id', $universityId)->where('status', $status);
            })->get();
    }

    /**
     * get the number of majors of a school
     * @param mixed $universityId
     *
     * @return [university_major]
     */
    public function countMajorToUniversity($universityId)
    {
        return DB::table('university_major')
            ->where('university_id', $universityId)
            ->where('deleted_at', null)
            ->count();
    }

    /**
     * get school account with role_id = admin
     * @param mixed $university
     *
     * @return [type]
     */
    public function getAdminUser($university)
    {
        return $university->users()->select('id')
            ->where('role_id', ROLE_ADMIN)->firstOrFail();
    }

    /**
     * Check if the business and the case have cooperated
     * @param mixed $enterprise
     * @param mixed $universityId
     *
     * @return [type]
     */
    public function checkCooperateExists($enterprise, $universityId)
    {
        return $enterprise->universities()
            ->wherePivot('university_id', $universityId)
            ->exists();
    }

    public function cooperateExistsSend($enterprise, $universityId)
    {
        return $enterprise->universities()
            ->wherePivot('university_id', $universityId)
            ->wherePivot('send_name', TYPE_ENTERPRISE)
            ->wherePivot('status', PENDING_APPROVE)
            ->exists();
    }

    public function checkCooperateSuccess($enterprise, $universityId)
    {
        return $enterprise->universities()
            ->where('university_id', $universityId)
            ->wherePivot('status', COOPERATE)
            ->exists();
    }

    public function checkCooperateRefuse($enterprise, $universityId)
    {
        return $enterprise->universities()
            ->where('university_id', $universityId)
            ->wherePivot('status', UN_COOPERATE)
            ->exists();
    }

    public function getCollaborationByUniversity(int $university_id, int $perPage, string $search)
    {
        $university = $this->findById($university_id);

        if (!$university) {
            return null;
        }

        $query = $university->enterprises()
            ->orderBy('collaborations.status');

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%');
            });
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function getIdCollaborations($universityId, $enterpriseId)
    {
        return DB::table('collaborations')
            ->where('university_id', $universityId)
            ->where('enterprise_id', $enterpriseId)
            ->latest('id')
            ->value('id');
    }
}
