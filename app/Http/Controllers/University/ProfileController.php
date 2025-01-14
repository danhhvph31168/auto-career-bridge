<?php

namespace App\Http\Controllers\University;

use App\Http\Requests\University\StoreProfileRequest;
use App\Http\Requests\University\UpdateProfileRequest;
use Illuminate\Http\Request;
use App\Services\University\ProfileService;

class ProfileController
{
    protected $profileService;

    /**
     * @param ProfileService $profileService
     */
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return [type]
     */
    public function edit()
    {
        $config = config('admin.university');
        $template = 'university.profile.edit';
        $majors = $this->profileService->getMajor();
        $data = $this->profileService->findById();

        $university = $data['university'] ?? null;
        $major = $data['majors'] ?? [];

        return view($template, compact('config', 'majors', 'major', 'university'));
    }

    /**
     * Update the specified resource in storage
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProfileRequest $request)
    {
        if ($this->profileService->update($request)) {

            return redirect()->route('approve')->with('success', 'Cập nhật thông tin thành công.');
        }

        return back()->withInput()->with('error', 'Cập nhật thông tin thất bại. Hãy thử lại.');
    }
}
