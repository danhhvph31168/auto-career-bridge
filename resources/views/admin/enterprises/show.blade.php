@extends('admin.layouts.master')
@section('title', 'Chi tiết tài khoản doanh nghiệp')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Chi tiết tài khoản</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a
                                        href="javascript: void(0);">{{ $config['approve']['title'] }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ $config['approve']['show'] }}</li>
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
                                <h3>Thông tin tài khoản</h3>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label font-weight-bold">Tên</label>
                                        <p class="border p-2 rounded">{{ $admin_enterprise->username }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label font-weight-bold">Email</label>
                                        <p class="border p-2 rounded">{{ $admin_enterprise->email }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label font-weight-bold">Số điện thoại</label>
                                        <p class="border p-2 rounded">{{ $admin_enterprise->phone }}</p>
                                    </div>
                                </div>
                                @php
                                    $statusLabels = [
                                        UN_APPROVE => ['class' => 'bg-danger', 'text' => 'Từ chối'],
                                        PENDING_APPROVE => ['class' => 'bg-warning', 'text' => 'Chờ phê duyệt'],
                                        APPROVED => ['class' => 'bg-success', 'text' => 'Đã phê duyệt'],
                                    ];

                                    $isActiveLabels = [
                                        IS_ACTIVE => [
                                            'class' => 'bg-success',
                                            'text' => 'Hoạt động',
                                        ],
                                        UN_ACTIVE => [
                                            'class' => 'bg-danger',
                                            'text' => 'Không hoạt động',
                                        ],
                                    ];
                                @endphp
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label font-weight-bold">Trạng thái phê duyệt</label><br>
                                                <span
                                                    class="badge {{ $statusLabels[$admin_enterprise->status]['class'] }}  px-3 py-2 rounded-pill">
                                                    {{ $statusLabels[$admin_enterprise->status]['text'] }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label font-weight-bold">Trạng thái hoạt động
                                                </label><br>
                                                <span
                                                    class="badge  {{ $isActiveLabels[$admin_enterprise->is_active]['class'] }} px-3 py-2 rounded-pill">
                                                    {{ $isActiveLabels[$admin_enterprise->is_active]['text'] }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Thông tin doanh nghiệp -->
                            @if ($admin_enterprise->enterprise_id)
                                <div class="row mb-3">
                                    <h3>Thông tin doanh nghiệp</h3>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label font-weight-bold">Logo</label>
                                            @if (!empty($admin_enterprise->enterprise->logo) && filter_var($admin_enterprise->enterprise->logo, FILTER_VALIDATE_URL))
                                                <img src="{{ $admin_enterprise->enterprise->logo }}" width="50px"
                                                    alt="Avatar">
                                            @elseif (!empty($admin_enterprise->enterprise->logo) && Storage::exists($admin_enterprise->enterprise->logo))
                                                <img src="{{ Storage::url($admin_enterprise->enterprise->logo) }}"
                                                    width="50px" alt="Avatar">
                                            @else
                                                <img src="https://placehold.co/50" alt="Default Avatar" class="img-fluid">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label font-weight-bold">Tên doanh nghiệp</label>
                                            <p class="border p-2 rounded">{{ $admin_enterprise->enterprise->name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label font-weight-bold">Mã số thuế</label>
                                            <p class="border p-2 rounded">{{ $admin_enterprise->enterprise->tax_code }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label font-weight-bold">Lĩnh vực hoạt động</label>
                                            <p class="border p-2 rounded">
                                                {{ $admin_enterprise->enterprise->industry ?? 'Không có' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label font-weight-bold">Quy mô</label>
                                            <p class="border p-2 rounded">
                                                {{ $admin_enterprise->enterprise->size ? $admin_enterprise->enterprise->size . ' nhân viên' : 'Không có' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label font-weight-bold">Website</label>
                                            <p class="border p-2 rounded">{{ $admin_enterprise->enterprise->url }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label font-weight-bold">Địa chỉ</label>
                                            <p class="border p-2 rounded">{{ $admin_enterprise->enterprise->address }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label font-weight-bold">Email</label>
                                            <p class="border p-2 rounded">{{ $admin_enterprise->enterprise->email }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label font-weight-bold">Số điện thoại</label>
                                            <p class="border p-2 rounded">{{ $admin_enterprise->enterprise->phone }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label font-weight-bold">Mô tả</label>
                                            <div class="form-control border p-2 rounded" rows="5" readonly>{!! $admin_enterprise->enterprise->description !!}</div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p class="text-danger">Tài khoản chưa có thông tin doanh nghiệp.</p>
                            @endif

                            <!-- Form Cập nhật Trạng thái -->
                            @if ($admin_enterprise->status === PENDING_APPROVE && $admin_enterprise->enterprise_id)
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-end">
                                            <form
                                                action="{{ route('system-admin.enterprise.approve', $admin_enterprise->id) }}"
                                                method="POST" class="me-2">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success">Phê duyệt</button>
                                            </form>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#rejectModal" data-id="{{ $admin_enterprise->id }}">
                                                Từ chối
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div><!-- end card-body -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end container-fluid -->
    </div><!-- end page-content -->


    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="rejectForm" method="POST"
                action="{{ route('system-admin.enterprise.un-approve', $admin_enterprise->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModalLabel">Nhập lý do từ chối</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="reason" class="form-label">Lý do từ chối</label>
                            <textarea class="form-control" id="reason" name="reason" rows="3" style="resize: none"></textarea>
                            <span class="text-danger" id="error-reason"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-danger">Từ chối</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <script>
        document.getElementById('rejectForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const reason = document.getElementById('reason').value.trim();
            const errorField = document.getElementById('error-reason');

            if (!reason) {
                errorField.textContent = 'Vui lòng nhập lý do';
                return;
            } else {
                errorField.textContent = '';
            }

            if (reason.length > 255) {
                errorField.textContent = 'Không được nhập quá 255 ký tự';
                return;
            } else {
                errorField.textContent = '';
            }

            this.submit();
        });
    </script>
@endsection
