@extends('admin.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Danh sách</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Bảng</a></li>
                                <li class="breadcrumb-item active">Danh sách</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row g-4">
                                <div class="col-sm-auto">
                                    <h4 class="card-title mt-2">Danh sách thông báo</h4>
                                </div>

                                <div class="col-sm">
                                    <div class="d-flex justify-content-sm-end">
                                        <div class="centered-content">
                                            <select name="filterType" id="filterType" class="form-control">
                                                <option value="">Kiểu thông báo</option>
                                                @foreach ($notificationType as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="listjs-table" id="customerList">
                                <div class="table-responsive table-card mb-1">
                                    <table class="table align-middle table-nowrap" id="customerTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Người Gửi</th>
                                                <th>Tiêu Đề</th>
                                                <th>Thời Gian Gửi</th>
                                                <th>Kiểu Thông Báo</th>
                                                <th>Trạng thái</th>
                                                <th>Thao Tác</th>
                                            </tr>
                                        </thead>

                                        <tbody class="list form-check-all" id="notificationTable">
                                            @foreach ($notifications as $item)
                                                <tr data-type="{{ $item->type }}">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="customer_name">
                                                        @if ($item->sender->user_type == 'super-admin')
                                                            Super Admin
                                                        @else
                                                            {{ empty($item->sender->university_id) ? $item->sender->enterprise->name ?? $item->sender->username : $item->sender->university->name ?? $item->sender->username }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->title }}</td>
                                                    <td>
                                                        <span class="badge text-bg-primary">
                                                            {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge text-bg-primary">
                                                            @if ($item->type == NOTIFY_SYSTEM)
                                                                Hệ thống
                                                            @elseif ($item->type == NOTIFY_COOPERATE)
                                                                Hợp tác
                                                            @elseif ($item->type == NOTIFY_APPLY)
                                                                Công việc
                                                            @elseif ($item->type == NOTIFY_FEEDBACK)
                                                                Phản hồi
                                                            @elseif ($item->type == NOTIFY_REGISTER_TYPE)
                                                                Đăng ký
                                                            @else
                                                                Hội thảo
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>{!! $item->is_read == UN_READ
                                                        ? '<span class="badge text-bg-light">Chưa đọc</span>'
                                                        : '<span class="badge text-bg-primary">Đã đọc</span>' !!}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.notifications.show', $item) }}"
                                                            class="link-primary">
                                                            <button class="btn btn-soft-primary" aria-label="View">
                                                                <i class="ri-eye-line"></i>
                                                            </button>
                                                        </a>

                                                        <button class="btn btn-danger" data-bs-toggle="modal"
                                                            data-bs-target="#deleteRecordModal">
                                                            <i class="ri-delete-bin-2-line"></i>
                                                        </button>

                                                        <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal" aria-label="Close"
                                                                            id="btn-close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="mt-2 text-center">
                                                                            <lord-icon
                                                                                src="https://cdn.lordicon.com/gsqxdxog.json"
                                                                                trigger="loop"
                                                                                colors="primary:#f7b84b,secondary:#f06548"
                                                                                style="width:100px;height:100px"></lord-icon>
                                                                            <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                                                                <h4>Bạn có chắc ?</h4>
                                                                                <p class="text-muted mx-4 mb-0">Bạn có chắc
                                                                                    chắn muốn xóa thông báo này không</p>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                                                            <button type="button"
                                                                                class="btn w-sm btn-light"
                                                                                data-bs-dismiss="modal">Trở lại</button>
                                                                            <form
                                                                                action="{{ route('admin.notifications.delete', $item) }}"
                                                                                method="post">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button class="btn w-sm btn-danger "
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#deleteRecordModal"
                                                                                    id="delete-record">Có, Xóa đi!</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                    <div class="card-footer border border-0">
                                        {{ $notifications->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.getElementById('filterType').addEventListener('change', function() {
            const selectedType = this.value;
            const rows = document.querySelectorAll('#notificationTable tr');

            rows.forEach(row => {
                const rowType = row.getAttribute('data-type');

                if (selectedType === "" || rowType === selectedType) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    </script>
@endsection
