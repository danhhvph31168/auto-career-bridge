@extends('admin.layouts.master')

@section('css')
    <style>
        .pagination-info {
            display: none !important;
        }
    </style>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Danh sách công việc</h4>
                    </div>
                </div>
            </div>

            {{-- <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">{{ config('admin.enterprise.jobs.index.filter') }}</h4>
                        </div>
                        <div class="card-body">
                            <form method="GET" id="filterForm">
                                <div class="row gy-4">
                                    <!-- Input Tên Workshop -->
                                    <div class="col-xl-3 col-md-6">
                                        <input type="text" name="title" value="{{ request('title') ?: old('title') }}"
                                            class="form-control search" placeholder="Tiêu đề">
                                    </div>
                                    <div class="col-xl-3 col-md-6">
                                        <input type="text" name="major" value="{{ request('major') ?: old('major') }}"
                                            class="form-control search" placeholder="Chuyên ngành">
                                    </div>

                                    <!-- Input Ngày bắt đầu -->
                                    <div class="col-xl-3 col-md-6">
                                        <input type="date" name="start_date"
                                            value="{{ request('start_date') ?: old('start_date') }}"
                                            class="form-control search" placeholder="Ngày bắt đầu">
                                    </div>

                                    <!-- Input Ngày kết thúc -->
                                    <div class="col-xl-3 col-md-6">
                                        <input type="date" name="end_date"
                                            value="{{ request('end_date') ?: old('end_date') }}" class="form-control search"
                                            placeholder="Ngày kết thúc">
                                    </div>

                                    <!-- Nút Lọc -->
                                </div>

                                <div class="modal-footer mt-3">
                                    <div class="hstack gap-2 justify-content-end">
                                        <a href="{{ route('enterprise.jobs.index') }}">
                                            <button type="button" class="btn btn-light w-100">
                                                Hủy
                                            </button>
                                        </a>
                                        <button class="btn btn-primary w-100">
                                            <i class="ri-equalizer-fill me-1 align-bottom"></i> Lọc
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end col -->
            </div> --}}

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex justify-content-between">
                            <div class="d-flex gap-2 align-items-center">
                                <select class="form-select w-auto per_page" aria-label="Default select example">
                                    <option value="10" {{ request()->get('perPage') == 10 ? 'selected' : '' }}>
                                        10</option>
                                    <option value="50" {{ request()->get('perPage') == 50 ? 'selected' : '' }}>50
                                    </option>
                                    <option value="100" {{ request()->get('perPage') == 100 ? 'selected' : '' }}>100
                                    </option>
                                </select>
                                <span>Số lượng bản ghi</span>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="dropdown card-header-dropdown">
                                    <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <span class="text-muted"><i
                                                class="ri-settings-4-line align-bottom me-1 fs-15"></i></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <button class="dropdown-item active_status">Bật trạng thái đã chọn</button>
                                        <button class="dropdown-item inactive_status">Tắt trạng thái đã chọn</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="listjs-table" id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <a href="{{ route('enterprise.jobs.create') }}">
                                                <button type="button" class="btn btn-success add-btn"><i
                                                        class="ri-add-line align-bottom me-1"></i>
                                                    {{ config('admin.enterprise.jobs.create .button') }}</button>
                                            </a>

                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <form id="filterForm" action="" method="GET">
                                            <div class="d-flex justify-content-sm-end">
                                                <div class="search-box ms-2">
                                                    <button class="btn m-0 p-0 search-icon"><i
                                                            class="ri-search-line "></i></button>
                                                    <input type="text" name="keyword"
                                                        value="{{ request('keyword') ?: old('keyword') }}"
                                                        class="form-control search" placeholder="Tìm kiếm">
                                                </div>

                                                <div class="search-box ms-2">
                                                    <input type="text" name="start_date"
                                                        value="{{ request('start_date') ?: old('start_date') }}"
                                                        class="form-control search " placeholder="Ngày bắt đầu"
                                                        data-provider="flatpickr" data-date-format="d/m/Y"
                                                        id="StartleaveDate">
                                                </div>

                                                <div class="search-box ms-2">
                                                    <input type="text" name="end_date"
                                                        value="{{ request('end_date') ?: old('end_date') }}"
                                                        class="form-control search " placeholder="Ngày kết thúc"
                                                        data-provider="flatpickr" data-date-format="d/m/Y"
                                                        id="EndleaveDate">
                                                </div>

                                                <div class="search-box ms-2">
                                                    {{-- <button class="btn btn-success w-100">
                                                        <i class="mdi mdi-magnify search-widget-icon"></i> Tìm kiếm
                                                    </button> --}}
                                                    <a href="{{ route('enterprise.jobs.index') }}">
                                                        <button type="button" class="btn btn-light w-100">
                                                            Hủy
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>


                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table align-middle table-nowrap" id="customerTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" style="width: 50px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="checkAll"
                                                            value="option">
                                                    </div>
                                                </th>
                                                <th class="sort" data-sort="stt">STT</th>
                                                <th class="sort" data-sort="name">Tiêu đề</th>
                                                <th class="sort" data-sort="major">Chuyên ngành</th>
                                                {{-- <th class="sort" data-sort="requirement">Yêu cầu</th> --}}
                                                <th class="sort" data-sort="applicant">Ứng tuyển thành công</th>
                                                <th class="sort" data-sort="start_date">Ngày bắt đầu</th>
                                                <th class="sort" data-sort="end_date">Ngày kết thúc</th>
                                                <th class="sort text-center" data-sort="status">Phê duyệt</th>
                                                <th class="sort text-center" data-sort="is_active">Trạng thái</th>
                                                <th class="text-center">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($jobs as $index => $job)
                                                <tr class>
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkBoxItem checkbox_all"
                                                                type="checkbox" name="chk_child"
                                                                data-id="{{ $job->id }}">
                                                        </div>
                                                    </th>
                                                    <td class="stt">
                                                        {{ $index + 1 + $jobs->perPage() * ($jobs->currentPage() - 1) }}
                                                    </td>
                                                    <td class="name">{{ Str::limit($job->title, 50, '...') }}</td>
                                                    <td class="major">{{ $job->major->name }}</td>
                                                    {{-- <td class="requirement">{{ $job->requirement }}</td> --}}
                                                    <td class="applicant">{{ $job->applicants }}</td>
                                                    <td class="start_date">
                                                        {{ \Carbon\Carbon::parse($job->start_date)->format('d/m/Y') }}</td>
                                                    <td class="end_date">
                                                        {{ \Carbon\Carbon::parse($job->end_date)->format('d/m/Y') }}</td>
                                                    @php
                                                        $statusLabels = [
                                                            PENDING_APPROVE => [
                                                                'class' => 'bg-warning',
                                                                'text' => 'Chờ duyệt',
                                                            ],
                                                            UN_APPROVE => [
                                                                'class' => 'bg-danger',
                                                                'text' => 'Từ chối',
                                                            ],
                                                            APPROVED => [
                                                                'class' => 'bg-success',
                                                                'text' => 'Đã duyệt',
                                                            ],
                                                        ];
                                                    @endphp
                                                    <td class="text-center status">
                                                        <span class="badge {{ $statusLabels[$job->status]['class'] }}">
                                                            {{ $statusLabels[$job->status]['text'] }}
                                                        </span>
                                                    </td>
                                                    @php
                                                        $isDisabled =
                                                            $job->status !== PENDING_APPROVE ? 'disabled' : '';
                                                        $isChecked = $job->is_active == IS_ACTIVE ? 'checked' : '';
                                                        // $textMutedClass = $job->status !== APPROVED ? 'text-muted' : '';
                                                    @endphp
                                                    <td class="status js-switch-{{ $job->university_id }} is_active">
                                                        <div
                                                            class="form-check form-switch form-switch-custom form-switch-success text-center">
                                                            <input class="form-check-input change_is_active"
                                                                type="checkbox" data-id="{{ $job->id }}"
                                                                {{-- value="{{ $job->is_active }}"
                                                                data-field="is_active"
                                                                data-model="Enterprise\Job"
                                                                data-modelId="{{ $job->id }}"  --}} {{ $isChecked }}>
                                                        </div>
                                                    </td>

                                                    <td class="d-flex justify-content-center">
                                                        <div class="d-flex gap-2">
                                                            <div class="eye">
                                                                <a href="{{ route('enterprise.jobs.show', $job->id) }}">
                                                                    <button data-bs-toggle="tooltip"
                                                                        data-bs-placement="top" title="Xem chi tiết"
                                                                        class="btn btn-soft-primary" aria-label="View">
                                                                        <i class="ri-eye-line"></i>
                                                                    </button>
                                                                </a>
                                                            </div>
                                                            <div class="edit">

                                                                @if ($job->status === APPROVED)
                                                                    <button class="btn btn-warning" aria-label="Edit"
                                                                        disabled>
                                                                        <i class="las la-edit"></i>
                                                                    </button>
                                                                @else
                                                                    <a
                                                                        href="{{ route('enterprise.jobs.edit', $job->id) }}">
                                                                        <button data-bs-toggle="tooltip"
                                                                            data-bs-placement="top" title="Sửa"
                                                                            {{ $isDisabled }} class="btn btn-warning"
                                                                            aria-label="Edit">
                                                                            <i class="las la-edit"></i>
                                                                        </button>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div class="remove">
                                                                <form id="deleteForm-{{ $job->id }}"
                                                                    action="{{ route('enterprise.jobs.destroy', $job->id) }}"
                                                                    method="POST" class="m-0"
                                                                    style="display: inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button data-bs-toggle="tooltip"
                                                                        data-bs-placement="top" title="Xoá"
                                                                        {{ $isDisabled }} type="button"
                                                                        class="btn btn-danger" aria-label="Delete"
                                                                        onclick="confirmDelete('{{ $job->id }}')">
                                                                        <i class="ri-delete-bin-2-line"></i>
                                                                    </button>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if ($jobs->isEmpty())
                                        <div class="noresult">
                                            <div class="text-center">
                                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                                    colors="primary:#121331,secondary:#08a88a"
                                                    style="width:75px;height:75px"></lord-icon>
                                                <h5 class="mt-2">Không có kết quả</h5>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                {{ $jobs->links('pagination::bootstrap-5') }}
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

    <script>
        document.getElementById('filterForm').addEventListener('submit', function(event) {
            let start_date = document.querySelector('input[name="start_date"]').value;
            let end_date = document.querySelector('input[name="end_date"]').value;

            function parseDate(date) {
                let parts = date.split('/');
                return new Date(parts[2], parts[1] - 1, parts[0]);
            }

            let start = parseDate(start_date);
            let end = parseDate(end_date);

            if (end && start && end < start) {
                event.preventDefault();
                flasher.error('Ngày kết thúc không được nhỏ hơn ngày bắt đầu!');
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.change_is_active').on('change', function() {
                const jobId = $(this).attr('data-id');
                const is_active = $(this).prop('checked') ?
                    '{{ IS_ACTIVE }}' :
                    '{{ UN_ACTIVE }}'

                changeManyStatus([jobId], is_active)
            });

            $('.inactive_status').on('click', function() {
                const is_active = "{{ UN_ACTIVE }}"

                getCheckbox_all(is_active, false)
            })


            $('.active_status').on('click', function() {
                const is_active = "{{ IS_ACTIVE }}"

                getCheckbox_all(is_active, true)
            })

            const getCheckbox_all = (is_active, checked) => {
                const checkbox_all = $('.checkbox_all:checked')

                const checkboxIds = $(checkbox_all).map(function() {
                    return $(this).data('id');
                }).get();

                const is_checked = checked ? true : false

                checkbox_all.each(function() {
                    const id = $(this).data('id');

                    $('.change_is_active[data-id="' + id + '"]').prop('checked', is_checked);
                });

                changeManyStatus(checkboxIds, is_active)
            }


            const changeManyStatus = (job_ids, is_active) => {

                if (job_ids.length === 0) {
                    return;
                }

                $.ajax({
                    url: "{{ route('enterprise.jobs.updateManyStatus') }}",
                    method: 'POST',
                    data: {
                        job_ids,
                        is_active,
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT',
                    },
                    success: function(res) {

                        if (res.data) {
                            flasher.success(res.data.message)
                        }

                        if (res.type == 'warning') {
                            flasher.warning(res.message)
                        }

                        if (res.type == 'error') {
                            flasher.error(res.message)
                        }

                        if (res.id_invalid) {
                            setTimeout(function() {
                                $('.change_is_active[data-id]').each(function() {
                                    const dataId = $(this).data('id');

                                    if (res.id_invalid.includes(dataId)) {
                                        $(this).prop('checked', false);
                                    }
                                });
                            }, 500);
                        }
                    },
                    error: function(err) {
                        if (err.responseJSON) {
                            flasher.error(err.responseJSON.message)
                        }
                    }
                });
            }

        });
    </script>
@endsection
