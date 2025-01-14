<?php

namespace App\Repositories\Enterprises\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function getAllUsersPaginate(int $perPage, string $search)
    {
        $query =  $this->_model
            ->where('enterprise_id', Auth::user()?->enterprise_id ?? abort(403))
            ->where('role_id', config('constants.enterprise.role.user.id'));

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('email', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone', 'LIKE', '%' . $search . '%')
                    ->orWhere('username', 'LIKE', '%' . $search . '%');
            });
        }
        
        $query->orderByDesc('id');

        return $query->paginate($perPage)->withQueryString();
    }

    public function findByEmail(string $email)
    {
        return $this->_model->where('email', $email)->first();
    }
    public function findByPhone(string $phone)
    {
        return $this->_model->where('phone', $phone)->first();
    }

    public function createManyUsers(array $data)
    {
        return DB::table('users')->insert($data);
    }


    public function getUserAdmin(int $enterprise_id)
    {
        return $this->_model
            ->where('enterprise_id', $enterprise_id)
            ->where('role_id', ROLE_ADMIN)
            ->get();
    }
}
