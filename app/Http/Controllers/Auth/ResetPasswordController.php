<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $redirectTo;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function reset(ResetPasswordRequest $request)
    {
        $response = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        return $response == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Bạn đã đặt lại mật khẩu thành công, vui lòng đăng nhập lại để truy cập vào hệ thống')
            : back()->withErrors(['email' => [__($response)]]);
    }

    public function redirectTo()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->user_type === TYPE_ENTERPRISE && $user->role_id === ROLE_ADMIN) {
                return route('enterprise.dashboard');
            } elseif ($user->user_type === TYPE_UNIVERSITY && $user->role_id === ROLE_ADMIN) {
                return route('university.dashboard');
            } elseif ($user->role_id === TYPE_ADMIN && $user->role_id === ROLE_ADMIN) {
                return route('system-admin.dashboard');
            }
        }

        return $this->redirectTo;
    }
    protected function resetPassword($user, $password)
    {
        $user->password = bcrypt($password);
        $user->save();
    }
}
