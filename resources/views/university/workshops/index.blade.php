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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Quản lí workshop</a></li>
                            <li class="breadcrumb-item active">Danh sách</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="listjs-table" id="customerList">
                            <div class="row g-4 mb-3">
                                <div class="col-sm-auto">
                                    <div>
                                        <a href="{{ route('university.workshop.create') }}">
                                            <button type="button" class="btn btn-success add-btn"><i
                                                    class="ri-add-line align-bottom me-1"></i> Thêm mới</button>
                                        </a>

                                    </div>
                                </div>
                                <div class="col-sm">
                                    <form id="filterForm" action="{{ route('university.workshop.index') }}"
                                        method="GET">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="search-box ms-2">
                                                <i class="ri-search-line search-icon"></i>
                                                <input type="text" name="name"
                                                    value="{{ request('name') ?: old('name') }}"
                                                    class="form-control search" placeholder="Tên workshop">
                                            </div>

                                            <div class="search-box ms-2">
                                                <input type="date" name="start_date"
                                                    value="{{ request('start_date') ?: old('start_date') }}"
                                                    class="form-control search" placeholder="Ngày bắt đầu"
                                                    data-provider="flatpickr" data-date-format="d/m/Y"
                                                    id="StartleaveDate">
                                            </div>

                                            <div class="search-box ms-2">
                                                <input type="date" name="end_date"
                                                    value="{{ request('end_date') ?: old('end_date') }}"
                                                    class="form-control search" placeholder="Ngày kết thúc"
                                                    data-provider="flatpickr" data-date-format="d/m/Y" id="EndleaveDate">
                                            </div>

                                            <div class="search-box ms-2">
                                                <button class="btn btn-success w-100">
                                                    <i class="mdi mdi-magnify search-widget-icon"></i> Tìm kiếm
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                </div>

                            </div>


                        </div>

                        <div class="table-responsive table-card mt-3 mb-1">
                            <table class="table align-middle table-nowrap" id="customerTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="sort" data-sort="stt">STT</th>
                                        <th class="sort" data-sort="title">Tiêu đề</th>
                                        <th class="sort" data-sort="requirement">Điều kiện</th>
                                        <th class="sort" data-sort="start_date">Ngày bắt đầu</th>
                                        <th class="sort" data-sort="end_date">Ngày kết thúc</th>
                                        <th class="sort text-center" data-sort="approval_status">Xác nhận</th>
                                        <th class="sort text-center" data-sort="active_status">Trạng thái</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($workshops as $index => $workshop)
                                    <tr>
                                        <td class="stt">{{ $index + 1 }}</td>
                                        <td class="title">{{ $workshop->title }}</td>
                                        <td class="requirement">{{ $workshop->requirement }}</td>
                                        <td class="start_date">
                                            {{ \Carbon\Carbon::parse($workshop->start_date)->format('d/m/Y') }}
                                        </td>
                                        <td class="end_date">
                                            {{ \Carbon\Carbon::parse($workshop->end_date)->format('d/m/Y') }}
                                        </td>
                                        <td class="text-center">
                                            @php
                                            $statusLabels = [
                                            UN_APPROVE => ['class' => 'bg-danger', 'text' => 'Từ chối'],
                                            PENDING_APPROVE => [
                                            'class' => 'bg-warning',
                                            'text' => 'Chờ duyệt',
                                            ],
                                            APPROVED => ['class' => 'bg-success', 'text' => 'Đã duyệt'],
                                            ];
                                            @endphp
                                            <span class="badge {{ $statusLabels[$workshop->status]['class'] }}">
                                                {{ $statusLabels[$workshop->status]['text'] }}
                                            </span>
                                        </td>
                                        @php
                                        $isDisabled = $workshop->status !== APPROVED ? 'disabled' : '';
                                        $isChecked = $workshop->is_active == APPROVED ? 'checked' : '';
                                        $textMutedClass =
                                        $workshop->status !== APPROVED ? 'text-muted' : '';
                                        @endphp

                                        <td class="status {{ $textMutedClass }}">
                                            <div
                                                class="form-check form-switch form-switch-custom form-switch-success text-center">
                                                <input class="form-check-input" value="{{ $workshop->is_active }}"
                                                    type="checkbox" data-field="is_active"
                                                    data-model="University\Workshop"
                                                    data-modelId="{{ $workshop->id }}" {{ $isChecked }}
                                                    >
                                            </div>
                                        </td>
                                        <td class="d-flex justify-content-center">
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('university.workshop.show', $workshop->id) }}"
                                                    class="btn btn-soft-primary" aria-label="View">
                                                    <i class="ri-eye-line"></i>
                                                </a>

                                                @if ($workshop->status === APPROVED)
                                                <button class="btn btn-warning" aria-label="Edit" disabled>
                                                    <i class="las la-edit"></i>
                                                </button>
                                                @else
                                                <a href="{{ route('university.workshop.edit', $workshop->id) }}"
                                                    class="btn btn-warning" aria-label="Edit">
                                                    <i class="las la-edit"></i>
                                                </a>
                                                @endif
                                                <form id="deleteForm-{{ $workshop->id }}"
                                                    action="{{ route('university.workshop.destroy', $workshop->id) }}"
                                                    method="POST" class="m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger"
                                                        aria-label="Delete"
                                                        onclick="confirmDelete('{{ $workshop->id }}')">
                                                        <i class="ri-delete-bin-2-line"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if (empty($workshops) || $workshops->isEmpty())
                            <div class="noresult">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#121331,secondary:#08a88a"
                                        style="width:75px;height:75px"></lord-icon>
                                    <h5 class="mt-2">Không có kết quả tìm kiếm</h5>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                @if ($workshops->total() >= 10)

                                <a class="page-item pagination-prev {{ $workshops->onFirstPage() ? 'disabled' : '' }}"
                                    href="{{ $workshops->appends(request()->query())->previousPageUrl() }}">Trở về</a>

                                <ul class="pagination listjs-pagination mb-0">
                                    @foreach ($workshops->appends(request()->query())->getUrlRange(1, $workshops->lastPage()) as $page => $url)
                                    <li class="{{ $workshops->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                    @endforeach
                                </ul>

                                <a class="page-item pagination-next {{ $workshops->hasMorePages() ? '' : 'disabled' }}"
                                    href="{{ $workshops->appends(request()->query())->nextPageUrl() }}">Tiếp</a>
                                @endif
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
<script defer src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>
<script src="{{ asset('assets/index/sortAndPerPage.js') }}"></script>
<script>
    document.getElementById('filterForm').addEventListener('submit', function(event) {
        let name = document.querySelector('input[name="name"]').value;
        let start_date = document.querySelector('input[name="start_date"]').value;
        let end_date = document.querySelector('input[name="end_date"]').value;

        let start = new Date(start_date);
        let end = new Date(end_date);

        if (end < start) {
            event.preventDefault();
            flasher.error('Ngày kết thúc không được nhỏ hơn ngày bắt đầu!', 'Thông báo');
            return;
        }
    });

    function confirmDelete(id) {
        console.log(id);

        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa không?',
            text: 'Dữ liệu này sẽ không thể phục hồi!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Gửi form xóa nếu người dùng xác nhận
                document.getElementById('deleteForm-' + id).submit();
            }
        });

        function confirmDelete(id) {
            console.log(id);

            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa không?',
                text: 'Dữ liệu này sẽ không thể phục hồi!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Gửi form xóa nếu người dùng xác nhận
                    document.getElementById('deleteForm-' + id).submit();
                }
            });
        }
</script>
@endsection