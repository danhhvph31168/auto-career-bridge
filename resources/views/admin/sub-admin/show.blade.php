@extends('admin.layouts.master')
@section('title', 'Chi tiết sub-admin')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Chi tiết tài khoản</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $config['list']['title'] }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ $config['show']['title'] }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h4 class="card-title mb-0 text-white">Chi tiết tài khoản</h4>
                        </div>
                        <div class="card-body">
                            <!-- Thông tin cá nhân -->
                            <div class="row mb-3">
                                <h3>Thông tin cá nhân</h3>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label font-weight-bold">Hình ảnh</label>
                                        @if (!empty($sub_admin->avatar) && filter_var($sub_admin->avatar, FILTER_VALIDATE_URL))
                                        <img src="{{ $sub_admin->avatar }}" width="50px"
                                            alt="Avatar">
                                    @elseif (!empty($sub_admin->avatar) && Storage::exists($sub_admin->avatar))
                                        <img src="{{ Storage::url($sub_admin->avatar) }}"
                                            width="50px" alt="Avatar">
                                    @else
                                        <img src="https://placehold.co/50" width="50px"
                                            alt="Default Avatar">
                                    @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label font-weight-bold">Tên</label>
                                        <p class="border p-2 rounded">{{ $sub_admin->username }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label font-weight-bold">Email</label>
                                        <p class="border p-2 rounded">{{ $sub_admin->email }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label font-weight-bold">Số điện thoại</label>
                                        <p class="border p-2 rounded">{{ $sub_admin->phone }}</p>
                                    </div>
                                </div>
                                @php
                                    $statusLabels = [
                                        UN_ACTIVE => ['class' => 'bg-warning', 'text' => 'Không hoạt động'],
                                        IS_ACTIVE => ['class' => 'bg-success', 'text' => 'Đang hoạt động'],
                                    ];
                                @endphp
                                <div class="col-md-6">
                                    <label class="form-label font-weight-bold">Trạng thái</label><br>
                                    <span class="badge {{ $statusLabels[$sub_admin->is_active]['class'] }}">
                                        {{ $statusLabels[$sub_admin->is_active]['text'] }}
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start mt-4">
                                <a href="{{ route('system-admin.sub-admin.index') }}">
                                    <button type="button" class="btn btn-light btn-label previestab">
                                        <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Trở về
                                    </button>
                                </a>
                            </div>
                        </div><!-- end card-body -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end container-fluid -->
    </div><!-- end page-content -->
@endsection
