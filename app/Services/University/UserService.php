<?php

namespace App\Services\University;

use App\Repositories\University\User\UserRepositoryInterface as UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    protected $userRepository;

    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Retrieve all users associated with the authenticated user's university and role.
     *
     * @return mixed
     */
    public function getAll()
    {
        $universityId = Auth::user()->university_id;
        $roleId = ROLE_USER;
        $condition = [
            'universityId' => $universityId,
            'roleId' => $roleId
        ];

        return $this->userRepository->getUniversityUsers($condition);
    }

    /**
     * Paginate users based on the provided keyword and pagination settings.
     *
     * @param mixed $request
     *
     * @return mixed
     */
    public function paginate($request)
    {
        $universityId = Auth::user()->university_id;
        $roleId = ROLE_USER;
        $condition = [
            'keyword' => $request->input('keyword'),
            'universityId' => $universityId,
            'roleId' => $roleId
        ];
        $perPage = $request->input('perPage') ?? 10;

        return $this->userRepository->getUniversityUsers($condition, $perPage);
    }

    /**
     * Create a new user for the authenticated user's university.
     * This method starts a database transaction, creates a new user, and commits the transaction.
     * If any exception occurs, the transaction is rolled back.
     *
     * @param mixed $request
     *
     * @return [type]
     */
    public function create($request)
    {

        DB::beginTransaction();
        $universityId = Auth::user()->university_id;
        try {
            $data = $request->only([
                'username',
                'email',
                'password',
                'avatar',
                'phone',
                'role_id',
                'is_active',
            ]);
            $data['user_type'] = TYPE_UNIVERSITY;
            $data['university_id'] = $universityId;
            if ($request->hasFile('avatar')) {
                $imagePath = $request->file('avatar')->store('public/universities');
                $data['avatar'] = $imagePath;
            }

            $this->userRepository->create($data);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);

            return false;
        }
    }

    /**
     * Find a user by their ID.
     *
     * @param mixed $id
     *
     * @return [type]
     */
    public function findById($id)
    {

        return $this->userRepository->findById($id);
    }

    /**
     *  Update a user's information.
     *
     * This method starts a database transaction, updates the user's information,
     * and commits the transaction. If an error occurs, the transaction is rolled back.
     *
     * @param mixed $id
     * @param mixed $request
     *
     * @return [type]
     */
    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $userUniversity = $this->userRepository->findById($id);
            $data = $request->except(['_token', 'send']);
            if ($request->hasFile('avatar')) {
                if ($userUniversity->avatar) {
                    Storage::delete($userUniversity->avatar);
                }

                $avatarPath = $request->file('avatar')->store('public/universities');
                $data['avatar'] = $avatarPath;
            }

            $this->userRepository->update($id, $data);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    /**
     * Delete a user by their ID.
     *
     * This method starts a transaction, deletes the user, and commits the transaction.
     * If any error occurs, the transaction is rolled back.
     *
     * @param mixed $id
     *
     * @return [type]
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->userRepository->destroy($id);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
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
                    'university_id' => Auth::user()?->university_id ?? abort(403),
                    'user_type' => TYPE_UNIVERSITY,
                    'role_id' => ROLE_USER,
                    'is_active' => IS_ACTIVE,
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

    /**
     * Update a user's status (active or unactive).
     *
     * @param array $post
     *
     * @return [type]
     */
    public function updateStatus($post = [])
    {
        DB::beginTransaction();
        try {
            $data[$post['field']] = (($post['value'] === IS_ACTIVE) ? UN_ACTIVE : IS_ACTIVE);
            $this->userRepository->update($post['modelId'], $data);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
