<?php

namespace App\Services\Auth;

interface RegisterServiceInterface
{
    /**
     * Create a new university user.
     *
     * @param \Illuminate\Http\Request $request The request object containing user details.
     * @return bool True if the user is created successfully, otherwise False.
     */

    public function create($request);
}
