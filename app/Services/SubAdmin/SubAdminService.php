<?php

namespace App\Services\SubAdmin;

use App\Repositories\SubAdmin\SubAdminRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SubAdminService
{
    protected $subAdminRepository;

    /**
     * Constructor
     *
     * @param SubAdminRepositoryInterface $subAdminRepository
     */
    public function __construct(SubAdminRepositoryInterface $subAdminRepository)
    {
        $this->subAdminRepository = $subAdminRepository;
    }

    /**
     * Paginate SubAdmins based on the given conditions.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($request)
    {
        $roleId = ROLE_USER;
        $condition = [
            'q' => $request->input('q'),
            'role_id' => $roleId,
            'university_id' => null,
            'enterprise_id' => null,
            'user_type' => null,
        ];
        $perPage = $request->input('perPage') ?? 10;

        return $this->subAdminRepository->getSubAdmin($condition, $perPage);
    }

    /**
     * Create a new SubAdmin record.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function create($request)
    {
        DB::beginTransaction();
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
            $data['password'] = Hash::make($request->input('password'));

            if ($request->hasFile('avatar')) {
                $imagePath = $request->file('avatar')->store('public/sub-admin');
                $data['avatar'] = $imagePath;
            }

            $data['user_type'] = $data['user_type'] ?? '';

            $this->subAdminRepository->create($data);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            report($e);
            return false;
        }
    }

    /**
     * Find a SubAdmin by its ID.
     *
     * @param int $id
     * @return \App\Models\SubAdmin|null
     */
    public function findById($id)
    {
        return $this->subAdminRepository->findById($id);
    }

    /**
     * Update a SubAdmin record.
     *
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $sub_admin = $this->subAdminRepository->findById($id);
            $data = $request->except(['_token', 'send']);
            if ($request->hasFile('avatar')) {
                if ($sub_admin->avatar) {
                    Storage::delete($sub_admin->avatar);
                }

                $avatarPath = $request->file('avatar')->store('public/sub-admin');
                $data['avatar'] = $avatarPath;
            }

            $this->subAdminRepository->update($id, $data);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * Delete a SubAdmin record.
     *
     * @param int $id
     * @return bool
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->subAdminRepository->destroy($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * Update the status of a SubAdmin record.
     *
     * @param array $post
     * @return bool
     */
    public function updateStatus($post = [])
    {
        DB::beginTransaction();
        try {
            $data[$post['field']] = (($post['value'] === IS_ACTIVE) ? UN_ACTIVE : IS_ACTIVE);
            $this->subAdminRepository->update($post['modelId'], $data);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }
}
