@extends('auth.layouts.app')
@section('auth-title', 'Đặt lại mật khẩu')
@section('auth')
    <div class="p-lg-5 p-4">
        <h5 class="text-primary">Đặt lại mật khẩu</h5>
        <div class="p-2">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Nhập email"
                        value="{{ $email ?? old('email') }}" tabindex="1">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password-input">Mật khẩu</label>
                    <div class="position-relative auth-pass-inputgroup">
                        <input type="password" name="password" class="form-control pe-5 password-input"
                            placeholder="Nhập mật khẩu" id="password-input" tabindex="2">
                        <button
                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none"
                            type="button">
                            <i class="fas fa-eye-slash align-middle"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="confirm-password">Nhập lại mật khẩu</label>
                    <div class="position-relative auth-pass-inputgroup mb-3">
                        <input type="password" class="form-control pe-5 password-input" placeholder="Nhập lại mật khẩu"
                            id="confirm-password" name="password_confirmation" tabindex="3">
                        <button
                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none"
                            type="button">
                            <i class="fas fa-eye-slash align-middle"></i>
                        </button>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button class="btn btn-success w-100" type="submit">Đặt lại</button>
                </div>
            </form>
        </div>

        <div class="mt-5 text-center">
            <p class="mb-0">Bạn đã nhớ mật khẩu<a href="{{ route('login') }}"
                    class="fw-semibold text-primary text-decoration-underline"> Đăng nhập </a> </p>
        </div>
    </div>
@endsection
