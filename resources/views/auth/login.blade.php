@extends('auth.layouts.app')
@section('auth-title', 'Đăng nhập')
@section('auth')
    <div class="p-lg-5 p-4">
        <div>
            <h5 class="text-primary">Đăng nhập</h5>
        </div>

        <div class="mt-4">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email" value="{{ old('email') }}" class="form-control" id="email"
                        placeholder="Nhập email" tabindex="1">
                    @error('email')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="float-end">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-muted">
                                Quên mật khẩu?
                            </a>
                        @endif
                    </div>
                    <label class="form-label" for="password-input">Mật khẩu</label>
                    <div class="position-relative auth-pass-inputgroup mb-3">
                        <input type="password" name="password" class="form-control pe-5 password-input"
                            placeholder="Nhập mật khẩu" id="password-input" tabindex="2">
                        <button
                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none"
                            type="button">
                            <i class="fas fa-eye-slash align-middle"></i>
                        </button>
                        @error('password')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="mt-4">
                    <button class="btn btn-success w-100" type="submit">Đăng nhập</button>
                </div>

            </form>
        </div>

        <div class="mt-5 text-center">
            <p class="mb-0">Bạn chưa có tài khoản ? <a href="{{ route('register') }}"
                    class="fw-semibold text-primary text-decoration-underline">Đăng ký</a> </p>
        </div>
    </div>
@endsection
