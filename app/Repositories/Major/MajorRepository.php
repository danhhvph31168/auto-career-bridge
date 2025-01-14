<?php

namespace App\Repositories\Major;

use App\Models\Major;
use App\Repositories\BaseRepository;
use App\Repositories\Major\MajorRepositoryInterface;

class MajorRepository extends BaseRepository implements MajorRepositoryInterface
{
    public function getModel()
    {
        return Major::class;
    }

    public function getAll(array $column = ['*'])
    {
        $query = $this->getModel()::where('status', APPROVED);

        return $query->get();
    }

    /**
     * Join two table, check the condition, and get all major of the university
     * 
     * @param array $condition
     * 
     * @return [type]
     */
    public function getMajorUniversity(array $condition = ['*'], int $perPage = 10)
    {
        $university_id = $condition['university_id'] ?? null;
        $keyword = $condition['keyword'] ?? null;
        $query = $this->getModel()::query();

        if ($university_id) {
            $query->join('university_major', 'majors.id', '=', 'university_major.major_id')
                ->where('university_major.university_id', $university_id)
                ->select('majors.*')
                ->orderBy('majors.id', 'desc');
        }
        if (isset($condition['status']) && (!empty($condition['status']) || $condition['status'] == 0)) {
            $query->where('status', $condition['status']);
        }

        if ($keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "%{$keyword}%");
            });
        }
        if (isset($condition['page'])) {
            $query->orderBy('status', 'ASC');
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function getMajorUniversityApproved(array $condition = ['*'])
    {
        $university_id = $condition['university_id'] ?? null;

        $majors = $this->getModel()::join('university_major', 'majors.id', '=', 'university_major.major_id')
            ->where('university_major.university_id', $university_id)
            ->where('status', APPROVED)
            ->select('majors.*')
            ->get();

        return $majors;
    }
}
