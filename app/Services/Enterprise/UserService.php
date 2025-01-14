<?php

namespace App\Services\Enterprise;

use App\Repositories\Enterprises\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(protected UserRepositoryInterface $userRepository) {}

    public function getAllUsers(int $perPage, string $search)
    {
        return $this->userRepository->getAllUsersPaginate($perPage, $search);
    }

    public function createUser($user)
    {
        $data = $user + [
            'enterprise_id' => Auth::user()?->enterprise_id ?? abort(403),
            'user_type' => TYPE_ENTERPRISE,
            'role_id' => ROLE_USER,
        ];

        return $this->userRepository->create($data);
    }

    public function updateUser($id, $data)
    {
        return $this->userRepository->update($id, $data);
    }

    public function findById($id)
    {
        return $this->userRepository->findById($id);
    }

    public function destroyUser(int $id)
    {
        return $this->userRepository->destroy($id);
    }

    public function importUsers(array $data)
    {
        DB::beginTransaction();

        try {
            $data_import = [
                'email' => [],
                'phone' => [],
            ];

            $data_unique = [
                'email' => [],
                'phone' => [],
            ];

            foreach ($data as $user) {
                if ($user['email'] && in_array($user['email'], $data_import['email'])) {
                    $data_unique['email'][] = $user['email'];
                } else {
                    $data_import['email'][] = $user['email'];
                }

                if (isset($user['phone']) && $user['phone'] && in_array($user['phone'], $data_import['phone'])) {
                    $data_unique['phone'][] = $user['phone'];
                } else if (isset($user['phone'])) {
                    $data_import['phone'][] = $user['phone'];
                }
            }

            $data_unique['email'] = array_unique($data_unique['email']);
            $data_unique['phone'] = array_unique($data_unique['phone']);

            if (count($data_unique['email']) > 0 || count($data_unique['phone']) > 0) {

                $messages = [];

                if (count($data_unique['email']) > 0) {
                    $messages['email'][] = 'Email trong file bị trùng: ' . implode(', ', $data_unique['email']);
                }

                if (count($data_unique['phone']) > 0) {
                    $messages['phone'][] = 'Phone trong file bị trùng: ' . implode(', ', $data_unique['phone']);
                }

                return [
                    'messages' => $messages,
                ];
            }

            $data_users = [];

            foreach ($data as $item) {
                $data_users[] = [
                    'email' => $item['email'],
                    'username' => $item['username'],
                    'phone' => isset($item['phone']) ? $item['phone'] : null,
                    'password' =>  Hash::make($item['password']),
                    'enterprise_id' => Auth::user()?->enterprise_id ?? abort(403),
                    'user_type' => config('constants.enterprise.user_type'),
                    'role_id' => config('constants.enterprise.role.user.id'),
                    'is_active' => config('constants.enterprise.is_active.active'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $this->userRepository->createManyUsers($data_users);

            DB::commit();

            session()->flash('success', 'Thêm mới thành công');

            return [
                'data' => [
                    'message' => 'Thêm mới thành công',
                ],
            ];
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();

            return [
                'message' => $th->getMessage(),
            ];
        }
    }
}
