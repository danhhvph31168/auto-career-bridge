@extends('admin.layouts.master')
@section('title', 'Danh sách công việc')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">{{ $config['list']['title'] }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $config['index']['title'] }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ $config['list']['title'] }}</li>
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
                                    <div class="col-sm">
                                        <form action="{{ route('system-admin.job.index') }}" method="GET">
                                            <div class="d-flex justify-content-sm-end">
                                                <div class="ms-2">
                                                    <select name="status" class="form-select"
                                                        onchange="this.form.submit()">
                                                        <option value="">Tất cả trạng thái</option>
                                                        <option value="pending"
                                                            {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ phê
                                                            duyệt</option>
                                                        <option value="approved"
                                                            {{ request('status') == 'approved' ? 'selected' : '' }}>Đã phê
                                                            duyệt</option>
                                                        <option value="reject"
                                                            {{ request('status') == 'reject' ? 'selected' : '' }}>Đã từ chối
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="search-box ms-2">
                                                    <input type="text" name="q"
                                                        value="{{ request('q') ?: old('q') }}" class="form-control search"
                                                        placeholder="Tìm kiếm..." onchange="this.form.submit()">
                                                    <i class="ri-search-line search-icon"></i>
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

                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table align-middle table-nowrap" id="customerTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="sort" data-sort="stt">STT</th>
                                                <th class="sort" data-sort="title">Tiêu đề</th>
                                                <th class="sort" data-sort="enterprise_name">Doanh nghiệp</th>
                                                <th class="sort" data-sort="major_name">Chuyên ngành</th>
                                                <th class="sort" data-sort="start_date">Ngày bắt đầu</th>
                                                <th class="sort" data-sort="end_date">Ngày kết thúc</th>
                                                <th class="no-sort text-center">Trạng thái</th>
                                                <th class="no-sort text-center">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($jobs as $job)
                                                <tr>
                                                    <td class="stt">
                                                        {{ ($jobs->currentPage() - 1) * $jobs->perPage() + $loop->iteration }}
                                                    </td>
                                                    <td class="title">{{ $job->title }}</td>
                                                    <td class="enterprise_name">{{ $job->enterprises->name }}</td>
                                                    <td class="major_name">{{ $job->major->name }}</td>
                                                    <td class="start_date">
                                                        {{ \Carbon\Carbon::parse($job->start_date)->format('d/m/Y') }}</td>
                                                    <td class="end_date">
                                                        {{ \Carbon\Carbon::parse($job->end_date)->format('d/m/Y') }}</td>
                                                    @php
                                                        $statusLabels = [
                                                            UN_APPROVE => ['class' => 'bg-danger', 'text' => 'Từ chối'],
                                                            PENDING_APPROVE => [
                                                                'class' => 'bg-warning',
                                                                'text' => 'Chờ phê duyệt',
                                                            ],
                                                            APPROVED => [
                                                                'class' => 'bg-success',
                                                                'text' => 'Đã phê duyệt',
                                                            ],
                                                        ];
                                                    @endphp
                                                    <td class="text-center">
                                                        <span class="badge {{ $statusLabels[$job->status]['class'] }}">
                                                            {{ $statusLabels[$job->status]['text'] }}
                                                        </span>
                                                    </td>

                                                    <td class="d-flex justify-content-center">
                                                        <div class="d-flex gap-2">
                                                            <div class="eye">
                                                                <a href="{{ route('system-admin.job.show', $job->id) }}">
                                                                    <button class="btn btn-soft-primary" aria-label="View"
                                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        title="Xem chi tiết">
                                                                        <i class="ri-eye-line"></i>
                                                                    </button>
                                                                </a>
                                                            </div>
                                                            <div class="remove">
                                                                <form id="deleteForm-{{ $job->id }}"
                                                                    action="{{ route('system-admin.job.destroy', $job->id) }}"
                                                                    method="POST" class="m-0"
                                                                    style="display: inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button" class="btn btn-danger"
                                                                        aria-label="Delete" data-bs-toggle="tooltip"
                                                                        data-bs-placement="top" title="Xoá"
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
                                </div>
                                @if (empty($jobs) || $jobs->isEmpty())
                                    <div class="noresult">
                                        <div class="text-center">
                                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                                colors="primary:#121331,secondary:#08a88a"
                                                style="width:75px;height:75px"></lord-icon>
                                            <h5 class="mt-2">Không có kết quả tìm kiếm</h5>
                                        </div>
                                    </div>
                                @endif
                                <div class="d-flex justify-content-end">
                                    <div class="pagination-wrap hstack gap-2">
                                        @if ($jobs->total() > $jobs->perPage())
                                            <a class="page-item pagination-prev {{ $jobs->onFirstPage() ? 'disabled' : '' }}"
                                                href="{{ $jobs->previousPageUrl() }}">Trở về</a>
                                            <ul class="pagination listjs-pagination mb-0">
                                                @foreach ($jobs->getUrlRange(1, $jobs->lastPage()) as $page => $url)
                                                    <li class="{{ $jobs->currentPage() == $page ? 'active' : '' }}">
                                                        <a class="page"
                                                            href="{{ $url }}">{{ $page }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <a class="page-item pagination-next {{ $jobs->hasMorePages() ? '' : 'disabled' }}"
                                                href="{{ $jobs->nextPageUrl() }}">Tiếp</a>
                                        @endif
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
