@extends('auth.layouts.app')
@section('auth-title', 'Đăng ký')
@section('auth')
    <div class="p-lg-5 p-4">
        <div>
            <h5 class="text-primary">Đăng ký tài khoản</h5>
        </div>

        <div class="mt-4">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="hidden" name="role_id" value="1">
                <div class="mb-3">
                    <label for="useremail" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="useremail" placeholder="Nhập email" name="email"
                        value="{{ old('email') }}" tabindex="1">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Tên<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="username" placeholder="Nhập tên" name="username"
                        value="{{ old('username') }}" tabindex="2">
                    @error('username')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="phone" placeholder="Nhập số điện thoại"
                        name="phone" value="{{ old('phone') }}" tabindex="3">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password-input">Mật khẩu<span class="text-danger">*</span></label>
                    <div class="position-relative auth-pass-inputgroup">
                        <input type="password" class="form-control pe-5 password-input" placeholder="Nhập mật khẩu"
                            id="password-input" name="password" tabindex="4">
                        <button
                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none"
                            type="button">
                            <i class="fas fa-eye-slash align-middle"></i>
                        </button>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror


                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password-confirmation">Nhập lại mật
                        khẩu</label>
                    <div class="position-relative auth-pass-inputgroup">
                        <input type="password" class="form-control pe-5 password-input" placeholder="Nhập lại mật khẩu"
                            id="password-confirmation" name="password_confirmation" tabindex="5">
                        <button
                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none"
                            type="button">
                            <i class="fas fa-eye-slash align-middle"></i>
                        </button>
                        @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="mb-3">
                    <label for="type" class="form-label">Bạn là?<span class="text-danger">*</span></label>
                    <div class="mt-4 mt-lg-0">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="type-enterprise">
                                Doanh nghiệp
                            </label>
                            <input class="form-check-input" type="radio" name="user_type" id="type-enterprise"
                                value="enterprise" {{ old('user_type') == 'enterprise' ? 'checked' : '' }}>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="type-university">
                                Nhà trường
                            </label>
                            <input class="form-check-input" type="radio" name="user_type" id="type-university"
                                value="university" {{ old('user_type') == 'university' ? 'checked' : '' }}>
                        </div>
                    </div>
                    @error('user_type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mt-4">
                    <button class="btn btn-success w-100" type="submit">Đăng
                        ký</button>
                </div>

            </form>
        </div>

        <div class="mt-5 text-center">
            <p class="mb-0">Bạn đã có tài khoản ? <a href="{{ route('login') }}"
                    class="fw-semibold text-primary text-decoration-underline">
                    Đăng nhập</a> </p>
        </div>
    </div>
@endsection
