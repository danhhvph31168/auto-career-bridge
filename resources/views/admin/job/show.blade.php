@extends('admin.layouts.master')
@section('title', 'Chi tiết công việc')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">{{ $config['index']['title'] }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $config['index']['title'] }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ $config['show']['title'] }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h4 class="card-title mb-0 text-white">{{ $config['show']['title'] }}
                            </h4>
                        </div>

                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tiêu đề: </label>
                                        <p class="border p-2 rounded">{{ $job->title }}</p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Doanh nghiệp: </label>
                                        <p class="border p-2 rounded">{{ $job->enterprises->name }}</p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Thời gian làm việc:</label>
                                                <p class="border p-2 rounded">{{ $job->working_time }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Chuyên ngành:</label>
                                                <p class="border p-2 rounded">{{ $job->major->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Yêu cầu ứng viên</label>
                                        <p class="border p-2 rounded">{{ $job->requirement }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Địa chỉ làm việc</label>
                                        <p class="border p-2 rounded">{{ $job->address }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Quyền lợi</label>
                                        <p class="border p-2 rounded">{{ $job->benefit }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="mb-3">
                                                <label class="form-label">Kinh nghiệm </label>
                                                <p class="border p-2 rounded">{{ $job->experience_level }}</p>
                                            </div>
                                        </div>
                                        @php
                                            $type = [
                                                FULL_TIME => 'Toàn thời gian',
                                                PART_TIME => 'Bán thời gian',
                                                REMOTE => 'Làm việc từ xa',
                                            ];
                                        @endphp
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Hình thức làm việc </label>
                                                <p class="border p-2 rounded">{{ $type[$job->type] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Ngày bắt đầu </label>
                                                <p class="border p-2 rounded">
                                                    {{ \Carbon\Carbon::parse($job->start_date)->format('d/m/Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Ngày kết thúc </label>
                                                <p class="border p-2 rounded">
                                                    {{ \Carbon\Carbon::parse($job->end_date)->format('d/m/Y') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Mức lương</label>
                                        <p class="border p-2 rounded">{{ $job->salary ?? 'Trống' }}</p>
                                    </div>
                                </div>

                                @php
                                    $statusLabels = [
                                        PENDING_APPROVE => [
                                            'class' => 'bg-warning',
                                            'text' => 'Chờ phê duyệt',
                                        ],
                                        UN_APPROVE => [
                                            'class' => 'bg-danger',
                                            'text' => 'Từ chối',
                                        ],
                                        APPROVED => [
                                            'class' => 'bg-success',
                                            'text' => 'Đã phê duyệt',
                                        ],
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
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <h6 class="fw-semibold">Trạng thái hoạt động
                                                </h6>
                                                <span
                                                    class="badge  {{ $isActiveLabels[$job->is_active]['class'] }} px-3 py-2 rounded-pill">
                                                    {{ $isActiveLabels[$job->is_active]['text'] }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <h6 class="fw-semibold">Trạng thái phê duyệt
                                                </h6>
                                                <span
                                                    class="badge  {{ $statusLabels[$job->status]['class'] }} px-3 py-2 rounded-pill">
                                                    {{ $statusLabels[$job->status]['text'] }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Mô tả: </label>
                                        <div class="border p-2 rounded">
                                            <p>{!! $job->description !!}</p>
                                        </div>
                                    </div>

                                </div>

                                @if ($job->status === PENDING_APPROVE)
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-end">
                                                <form action="{{ route('system-admin.job.approve', $job->id) }}"
                                                    method="POST" class="me-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success">Phê duyệt</button>
                                                </form>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#rejectModal" data-id="{{ $job->id }}">
                                                    Từ chối
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif


                            </div><!-- end card-body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div>
            </div>
        </div><!-- end container-fluid -->
    </div><!-- end page-content -->


    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="rejectForm" method="POST" action="{{ route('system-admin.job.un-approve', $job->id) }}">
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
