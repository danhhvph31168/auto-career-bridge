@extends('admin.layouts.master')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<script src="{{ asset('theme/admin/html/master/assets/js/pages/password-addon.init.js') }}"></script>
@section('title', 'Thêm mới sub-admin')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">{{ $config['create']['title'] }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a
                                        href="javascript: void(0);">{{ $config['list']['title'] }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ $config['create']['title'] }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('system-admin.sub-admin.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="role_id" value="2">
                                <div class="row">
                                    <div class="col-md-4 left-column">
                                        <h4 class="fw-semibold mb-3">Thông tin sub-admin</span>
                                        </h4>
                                        <p>Điền đầy đủ thông tin dưới đây để thêm mới sub-admin vào hệ thống.</p>
                                    </div>

                                    <div class="col-md-8 right-column">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Tên<span class="text-danger">
                                                            (*)</span></label>
                                                    <input type="text" class="form-control" name="username"
                                                        value="{{ old('username') }}" placeholder="Nhập tên">
                                                    @error('username')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Email <span
                                                            class="text-danger">(*)</span></label>
                                                    <input type="text" class="form-control" name="email"
                                                        value="{{ old('email') }}" placeholder="Nhập email">
                                                    @error('email')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Hình ảnh</label>
                                                    <div class="d-flex">
                                                        <input type="file" name="avatar" class="form-control">
                                                    </div>
                                                    @error('avatar')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Số điện thoại <span
                                                            class="text-danger">(*)</span></label>
                                                    <input type="text" name="phone" class="form-control"
                                                        value="{{ old('phone') }}" placeholder="Nhập số điện thoại">
                                                    @error('phone')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Mật khẩu <span
                                                        class="text-danger">(*)</span></label>
                                                <div class="position-relative">
                                                    <input type="password" name="password" class="form-control"
                                                        id="password" placeholder="Nhập mật khẩu">
                                                    <button type="button"
                                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted"
                                                        onclick="togglePassword('password', this)">
                                                        <i class="fas fa-eye-slash align-middle"></i>
                                                    </button>
                                                    @error('password')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Nhập lại mật khẩu <span
                                                        class="text-danger">(*)</span></label>
                                                <div class="position-relative">
                                                    <input type="password" name="password_confirmation" class="form-control"
                                                        id="password_confirmation" placeholder="Xác nhận mật khẩu">
                                                    <button type="button"
                                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted"
                                                        onclick="togglePassword('password_confirmation', this)">
                                                        <i class="fas fa-eye-slash align-middle"></i>
                                                    </button>
                                                    @error('password_confirmation')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <h6 class="fw-semibold">Trạng thái <span class="text-danger">(*)</span>
                                                    </h6>
                                                    <div class="d-flex">
                                                        <div class="form-check form-radio-outline form-radio-success mt-2">
                                                            <input class="form-check-input" type="radio"
                                                                name="is_active" id="activeStatus" value="1"
                                                                checked>
                                                            <label class="form-check-label" for="activeStatus">
                                                                Hoạt động
                                                            </label>
                                                        </div>
                                                        <div
                                                            class="form-check form-radio-outline form-radio-danger mt-2 ms-3">
                                                            <input class="form-check-input" type="radio"
                                                                name="is_active" id="inactiveStatus" value="0">
                                                            <label class="form-check-label" for="inactiveStatus">
                                                                Không hoạt động
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-start gap-3 mt-4">
                                            <a href="{{ route('system-admin.sub-admin.index') }}">
                                                <button type="button" class="btn btn-light btn-label">
                                                    <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                                    Trở về
                                                </button>
                                            </a>
                                            <button type="submit" class="btn btn-success btn-label right ms-auto">
                                                <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i> Thêm
                                                mới
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><!-- end card-body -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div>
        </div>
    </div>
@endsection
<script>
    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);
        const icon = button.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }
</script>
