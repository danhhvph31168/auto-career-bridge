<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    // after verification redirect to route approve
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    protected function redirectTo()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->user_type == TYPE_ENTERPRISE && $user->role_id === ROLE_ADMIN) {
                return route('enterprise.dashboard');
            } elseif ($user->user_type == TYPE_UNIVERSITY && $user->role_id === ROLE_ADMIN) {
                return  route('university.dashboard');
            } elseif ($user->user_type == TYPE_ADMIN && $user->role_id === ROLE_ADMIN) {
                return route('system-admin.dashboard');
            }
        }
    }
}
