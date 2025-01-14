<?php

namespace App\Http\Controllers\Enterprise;

use App\Http\Requests\Enterprise\Profile\StoreProfileRequest;
use App\Http\Requests\Enterprise\Profile\UpdateProfileRequest as ProfileUpdateProfileRequest;
use App\Services\Enterprise\ProfileService;
use Illuminate\Http\Request;

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
        $config = config('admin.enterprise');
        $template = 'enterprise.profile.edit';


        $enterprise = $this->profileService->findById();
        return view($template, compact('config', 'enterprise'));
    }

    /**
     * Update the specified resource in storage
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateProfileRequest $request)
    {
        if ($this->profileService->update($request)) {

            return redirect()->route('approve')->with('success', 'Cập nhật thông tin thành công.');
        }

        return back()->withInput()->with('error', 'Cập nhật thông tin thất bại. Hãy thử lại.');
    }
}
