@extends('admin.layouts.master')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">{{ $config['index']['title'] }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Quản lí giáo vụ</a></li>
                            <li class="breadcrumb-item active">Cập nhật giáo vụ</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">
                        <form action="{{ route('university.update', $userUniversity->id) }}" method="post" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <!-- Cột bên trái -->
                                <div class="col-md-4 left-column">
                                    <h4 class="fw-semibold mb-3">Thông tin giáo vụ <span class="text-danger">(*)</span></h4>
                                    <p>Điền đầy đủ thông tin dưới đây để cập nhật giáo vụ vào hệ thống.</p>
                                </div>

                                <!-- Cột bên phải (Form nhập liệu) -->
                                <div class="col-md-8 right-column">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Họ và tên <span class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control" name="username" value="{{ old('username',$userUniversity->username) }}" placeholder="Nhập họ tên">
                                                @error('username')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Email <span class="text-danger">(*)</span></label>
                                                <input type="email" class="form-control" name="email" value="{{ old('email',$userUniversity->email) }}" placeholder="Nhập email">
                                                @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="cleave-ccard" class="form-label">Hình ảnh</label>
                                                <div class="d-flex">
                                                    @if(isset($userUniversity->avatar))
                                                    <img src="{{ Storage::url($userUniversity->avatar) }}" width="50px" class="box-image" alt="">
                                                    @else
                                                    <img src="{{ asset('theme/admin/html/master/assets/image')}}s/icon-image.png" width="38px" class="box-image" alt="">
                                                    @endif
                                                    <input type="file" name="avatar" class="form-control">
                                                </div>


                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Số điện thoại <span class="text-danger">(*)</span></label>
                                                <input type="hidden" class="form-control" name="user_type" value="{{ $userUniversity->user_type }}">
                                                <input type="text" name="phone" class="form-control" value="{{ old('phone',$userUniversity->phone) }}" placeholder="Nhập số điện thoại">
                                                @error('phone')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Mật khẩu <span class="text-danger">(*)</span></label>
                                                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" value="{{ old('password') }}">
                                                @error('password')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Nhập lại mật khẩu <span class="text-danger">(*)</span></label>
                                                <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}" placeholder="Xác nhận mật khẩu">
                                                @error('password_confirmation')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <h6 class="fw-semibold">Trạng thái <span class="text-danger">(*)</span></h6>
                                                <div class="d-flex">
                                                    <div class="form-check form-radio-outline form-radio-success mt-2">
                                                        <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="is_active"
                                                            id="activeStatus"
                                                            value="{{ IS_ACTIVE }}"
                                                            {{ isset($userUniversity->is_active) && $userUniversity->is_active == IS_ACTIVE ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="activeStatus">
                                                            Hoạt động
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-radio-outline form-radio-danger mt-2 ms-3">
                                                        <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="is_active"
                                                            id="unactiveStatus"
                                                            value="{{ UN_ACTIVE }}"
                                                            {{ isset($userUniversity->is_active) && $userUniversity->is_active == UN_ACTIVE ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="unactiveStatus">
                                                            Không hoạt động
                                                        </label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <h6 class="fw-semibold">Vai trò <span class="text-danger">(*)</span></h6>
                                                <select class="form-control select-flag-templating" name="role_id">
                                                    <optgroup label="Chọn vai trò">
                                                        <option value="1" {{ $userUniversity->role_id == ROLE_ADMIN ? 'selected' : '' }}>Admin</option>
                                                        <option value="2" {{ $userUniversity->role_id == ROLE_USER ? 'selected' : '' }}>Giáo vụ</option>
                                                    </optgroup>
                                                </select>
                                                @error('role_id')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror

                                            </div>
                                        </div>


                                    </div>
                                    <div class="d-flex align-items-start gap-3 mt-4">
                                        <a href="{{ route('university.index') }}">
                                            <button type="button" class="btn btn-light btn-label">
                                                <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Trở về
                                            </button>
                                        </a>
                                        <button type="submit" class="btn btn-success btn-label right ms-auto">
                                            <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i> Cập nhật
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