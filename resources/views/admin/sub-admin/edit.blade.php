@extends('admin.layouts.master')
@section('title', 'Cập nhật sub-admin')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">{{ $config['list']['title'] }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $config['list']['title'] }}</a></li>
                                <li class="breadcrumb-item active">{{ $config['edit']['title'] }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">{{ $config['edit']['title'] }}</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('system-admin.sub-admin.update', $sub_admin->id) }}" method="post"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <input type="hidden" name="id" value="{{ $sub_admin->id }}" class="d-none">
                                <div class="row">
                                    <!-- Cột bên trái -->
                                    <div class="col-md-4 left-column">
                                        <h4 class="fw-semibold mb-3">Thông tin sub-admin <span
                                                class="text-danger">(*)</span>
                                        </h4>
                                        <p>Điền đầy đủ thông tin dưới đây để cập nhật sub-admin vào hệ thống.</p>
                                    </div>

                                    <!-- Cột bên phải (Form nhập liệu) -->
                                    <div class="col-md-8 right-column">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Họ và tên <span
                                                            class="text-danger">(*)</span></label>
                                                    <input type="text" class="form-control" name="username"
                                                        value="{{ old('username', $sub_admin->username) }}"
                                                        placeholder="Nhập họ tên">
                                                    @error('username')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Email <span
                                                            class="text-danger">(*)</span></label>
                                                    <input type="email" class="form-control" name="email"
                                                        value="{{ old('email', $sub_admin->email) }}"
                                                        placeholder="Nhập email">
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
                                                        @if ($sub_admin->avatar && Storage::exists($sub_admin->avatar))
                                                            <img src="{{ Storage::url($sub_admin->avatar) }}" width="30px"
                                                                class="box-image" alt="">
                                                        @else
                                                            <img src="{{ asset('theme/admin/html/master/assets/image') }}s/icon-image.png"
                                                                width="38px" class="box-image" alt="">
                                                        @endif
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
                                                        value="{{ old('phone', $sub_admin->phone) }}"
                                                        placeholder="Nhập số điện thoại">
                                                    @error('phone')
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
                                                            <input class="form-check-input" type="radio" name="is_active"
                                                                id="activeStatus" value="{{ IS_ACTIVE }}"
                                                                {{ old('is_active', $sub_admin->is_active ?? '') == IS_ACTIVE ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="activeStatus">
                                                                Hoạt động
                                                            </label>
                                                        </div>
                                                        <div
                                                            class="form-check form-radio-outline form-radio-danger mt-2 ms-3">
                                                            <input class="form-check-input" type="radio" name="is_active"
                                                                id="unactiveStatus" value="{{ UN_ACTIVE }}"
                                                                {{ old('is_active', $sub_admin->is_active ?? '') == UN_ACTIVE ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="unactiveStatus">
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
                                                <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i> Cập
                                                nhật
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
