<?php

namespace App\Services\Enterprise;

use App\Repositories\Enterprises\EnterpriseRepositoryInterface;
use App\Repositories\Users\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ProfileService
{
    protected $enterpriseRepository;
    protected $userRepository;

    /**
     * ProfileService constructor.
     *
     * @param EnterpriseRepositoryInterface $enterpriseRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        EnterpriseRepositoryInterface $enterpriseRepository,
        UserRepository $userRepository,
    ) {
        $this->enterpriseRepository = $enterpriseRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Update an existing Enterprise profile.
     *
     * @param mixed $request
     *
     * @return [type]
     */
    public function update($request)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $id = Auth::user()->enterprise_id;
            $data = $request->except(['_token', 'send']);


            if (!empty($data['name'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('public/profile');
                $data['logo'] = $logoPath;
            }

            if (empty($id)) {
                $enterprise = $this->enterpriseRepository->create($data);
                $this->userRepository->update($user->id, [
                    'enterprise_id' => $enterprise->id,
                    'status' => PENDING_APPROVE,
                ]);
            } else {
                $enterprise = $this->enterpriseRepository->getById($id);

                if ($request->hasFile('logo') && $enterprise->logo) {
                    Storage::delete($enterprise->logo);
                }

                $this->enterpriseRepository->update($user->enterprise_id, $data);
                if ($user->status === UN_APPROVE) {
                    $this->userRepository->update($user->id, ['status' => PENDING_APPROVE]);
                }
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * Find a Enterprise profile by ID, including its associated majors.
     *
     * @return array
     */
    public function findById()
    {
        $id = Auth::user()->enterprise_id;
        if (empty($id)) {
            return [];
        }
        return $this->enterpriseRepository->findById($id);
    }
}
