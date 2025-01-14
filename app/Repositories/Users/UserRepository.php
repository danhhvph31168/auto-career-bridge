<?php

namespace App\Repositories\Users;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function getUniversityAccount(array $condition = [], array $column = ['*'])
    {
        $query = $this->getModel()::query();

        $query = $query->where('user_type', 'university')->where('role_id', ROLE_ADMIN)->where('university_id', '<>', 'null');

        $query = $this->search($condition['keyword'], $condition['status'], $query);
        $query->orderby('status', 'ASC');

        return $query->paginate($condition['perpage'], $column);
    }

    public function search($keyword, $status, $query)
    {
        $query = $query->when(isset($keyword) && !empty($keyword), function ($query) use ($keyword) {
            $query->where(function ($subQuery) use ($keyword) {
                $subQuery->where('username', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('email', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('phone', 'LIKE', '%' . $keyword . '%');
            });
        })->when((isset($status) && !empty($status)) || $status == 0, function ($query) use ($status) {
            $query->where('status', $status);
        });

        return $query;
    }

    public function getUserAdminUniversity(int $university_id)
    {
        return $this->_model
            ->where('university_id', $university_id)
            ->where('role_id', ROLE_ADMIN)
            ->where('user_type', TYPE_UNIVERSITY)
            ->where('status', IS_ACTIVE)
            ->where('is_active', IS_ACTIVE)
            ->get();
    }

    public function getUserAdminEnterprise(int $enterprise_id)
    {
        return $this->_model
            ->where('enterprise_id', $enterprise_id)
            ->where('role_id', ROLE_ADMIN)
            ->where('user_type', TYPE_ENTERPRISE)
            ->where('status', IS_ACTIVE)
            ->where('is_active', IS_ACTIVE)
            ->get();
    }

    public function getUserSupperAdmin()
    {
        return $this->_model
            ->where('role_id', ROLE_ADMIN)
            ->where('user_type', TYPE_ADMIN)
            ->get();
    }
}
