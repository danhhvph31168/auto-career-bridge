<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    public function approved()
    {
        $user = Auth::user();

        if ($user->status === APPROVED) {

            if ($user->user_type == TYPE_ENTERPRISE && $user->role_id === ROLE_ADMIN) {
                return redirect()->route('enterprise.dashboard');
            } elseif ($user->user_type == TYPE_UNIVERSITY && $user->role_id === ROLE_ADMIN) {
                return redirect()->route('university.dashboard');
            } else if ($user->user_type == TYPE_ADMIN && $user->role_id === ROLE_ADMIN) {
                return redirect()->route('system-admin.dashboard');
            }
        }

        return view('auth.approve');
    }
}
