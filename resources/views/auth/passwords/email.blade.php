@extends('auth.layouts.app')
@section('auth-title', 'Quên mật khẩu')
@section('auth')
    <div class="p-lg-5 p-4">
        <h5 class="text-primary">Quên mật khẩu?</h5>
        <p class="text-muted">Đặt lại mật khẩu</p>

        <div class="alert border-0 alert-warning text-center mb-2 mx-2" role="alert">
            Nhập email, hệ thống sẽ gửi email đặt lại mật khẩu cho bạn
        </div>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="p-2">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-4">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Nhập email"
                        value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="text-center mt-4">
                    <button class="btn btn-success w-100" type="submit">Gửi</button>
                </div>
            </form><!-- end form -->
        </div>

        <div class="mt-5 text-center">
            <p class="mb-0">Bạn đã nhớ mật khẩu<a href="{{ route('login') }}"
                    class="fw-semibold text-primary text-decoration-underline"> Đăng nhập </a> </p>
        </div>
    </div>
@endsection
