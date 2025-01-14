<?php

namespace App\Services\University;

use App\Models\University;
use App\Repositories\Major\MajorRepository;
use App\Repositories\University\UniversityRepositoryInterface;
use App\Repositories\Users\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ProfileService
{
    protected $universityRepository;
    protected $userRepository;
    protected $majorRepository;

    /**
     * ProfileService constructor.
     *
     * @param UniversityRepositoryInterface $universityRepository
     * @param UserRepository $userRepository
     * @param MajorRepository $majorRepository
     */
    public function __construct(
        UniversityRepositoryInterface $universityRepository,
        UserRepository $userRepository,
        MajorRepository $majorRepository
    ) {
        $this->universityRepository = $universityRepository;
        $this->userRepository = $userRepository;
        $this->majorRepository = $majorRepository;
    }

    /**
     * Retrieve all majors.
     *
     * @return mixed
     */
    public function getMajor()
    {

        return $this->majorRepository->getAll();
    }

    /**
     * Update an existing university profile.
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
            $id = Auth::user()->university_id;
            $data = $request->except(['_token', 'send']);

            if (!empty($data['name'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('public/profile');
                $data['logo'] = $logoPath;
            }


            if (empty($id)) {
                $university = $this->universityRepository->create($data);
                $this->userRepository->update($user->id, [
                    'university_id' => $university->id,
                    'status' => PENDING_APPROVE,
                ]);
            } else {
                $userUniversity = $this->universityRepository->findById($id);

                if ($request->hasFile('logo') && $userUniversity->logo) {
                    Storage::delete($userUniversity->logo);
                }

                $university = $this->universityRepository->update($id, $data);
                
            }


            if ($request->has('majors')) {
                $majorIds = $request->input('majors');
                $university->majors()->sync($majorIds);
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
     * Find a university profile by ID, including its associated majors.
     *
     * @return array
     */
    public function findById()
    {
        $id = Auth::user()->university_id;
        $university = University::with('majors')->find($id);
        if ($university) {
            $majors = $university->majors;
            return [
                'majors' => $majors,
                'university' => $university,
            ];
        }
        return $this->universityRepository->findById($id);
    }
}
