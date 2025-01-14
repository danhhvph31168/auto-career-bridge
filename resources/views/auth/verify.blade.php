@extends('auth.layouts.app')
@section('auth-title', 'Xác thực Email')
@section('auth')
    <div class="p-lg-5 p-4 text-center">
        <h5 class="text-primary">Xác nhận địa chỉ email của bạn
        </h5>

        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                Một liên kết xác nhận mới đã được gửi đến địa chỉ email của bạn
            </div>
        @endif

        <p>
            Vui lòng kiểm tra email của bạn để tìm liên kết xác nhận</p>
        <p>Nếu bạn không nhận được email
        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="text-center btn btn-link p-0 m-0 align-baseline">Nhấn vào đây để yêu cầu
                lại</button>.
        </form>
        </p>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="dropdown-item">
                <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                <span class="align-middle" data-key="t-logout">Đăng xuất</span>
            </button>
        </form>
    </div>
    </div>
    </div>
@endsection
