<?php

namespace App\Repositories\University\User;

use App\Repositories\BaseRepository;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * Return the corresponding model.
     *
     * @return string The class name of the model.
     */
    public function getModel()
    {
        return User::class;
    }

    public function createManyUsers(array $data)
    {
        return DB::table('users')->insert($data);
    }

    /**
     * check condition to get query then return view
     * 
     * @param array $condition
     * @return [type]
     */
    public function getAll(array $condition = [])
    {
        $universityId  = $condition['universityId'] ?? null;
        $roleId = $condition['roleId'] ?? null;

        $query = $this->getModel()::query();
        if ($universityId) {
            $query->where('university_id', $universityId);
        }
        if ($roleId) {
            $query->where('role_id', $roleId);
        }

        return $query->with(['university', 'role'])->get();
    }

    /**
     * Retrieve a list of users belonging to a specific university and role.
     *
     * @param int $universityId The ID of the university.
     * @param int $roleId The ID of the role.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator Paginated list of users.
     */
    public function getUniversityUsers(array $condition = [], int $perPage = 10)
    {
        $universityId  = $condition['universityId'] ?? null;
        $roleId = $condition['roleId'] ?? null;
        $keyword = $condition['keyword'] ?? null;

        $query = $this->getModel()::query();
        if ($universityId) {
            $query->where('university_id', $universityId);
        }
        if ($roleId) {
            $query->where('role_id', $roleId);
        }
        if ($keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->where('username', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%")
                    ->orWhere('phone', 'like', "%{$keyword}%");
            });
        }
        $query->orderBy('id', 'desc');

        return $query->paginate($perPage)->withQueryString();
    }

    public function getUserAdmin(int $university_id)
    {
        return $this->_model
            ->where('university_id', $university_id)
            ->where('role_id', ROLE_ADMIN)
            ->get();
    }
}
