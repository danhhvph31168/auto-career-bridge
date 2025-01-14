@extends('admin.layouts.master')
@section('title', 'Danh sách tài khoản doanh nghiệp')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Danh sách tài khoản doanh nghiệp</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a
                                        href="javascript: void(0);">{{ $config['approve']['title'] }}</a></li>
                                <li class="breadcrumb-item active">{{ $config['approve']['index'] }}</li>
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
                                        <form action="{{ route('system-admin.enterprise.index') }}" method="GET">
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
                                    <table class="table align-middle table-nowrap overflow-x-auto" id="customerTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="sort" data-sort="stt">STT</th>
                                                <th class="sort" data-sort="username">Tên tài khoản</th>
                                                <th class="sort" data-sort="enterprise_name">Tên doanh nghiệp</th>
                                                <th class="sort" data-sort="email">Email</th>
                                                <th class="no-sort">Phone</th>
                                                <th class="no-sort text-center">Trạng thái</th>
                                                <th class="no-sort text-center">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($admin_enterprises as $enterprise)
                                                <tr>
                                                    <td class="stt">
                                                        {{ ($admin_enterprises->currentPage() - 1) * $admin_enterprises->perPage() + $loop->iteration }}
                                                    </td>
                                                    <td class="username">{{ $enterprise->username }}</td>
                                                    <td class="enterprise_name">{{ $enterprise->enterprise->name }}</td>
                                                    <td class="email">{{ $enterprise->email }}</td>
                                                    <td class="phone">{{ $enterprise->phone }}</td>
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
                                                        <span
                                                            class="badge {{ $statusLabels[$enterprise->status]['class'] }}">
                                                            {{ $statusLabels[$enterprise->status]['text'] }}
                                                        </span>
                                                    </td>

                                                    <td class="d-flex gap-2 justify-content-center">
                                                        <div class="eye">
                                                            <a
                                                                href="{{ route('system-admin.enterprise.show', $enterprise->id) }}">
                                                                <button class="btn btn-soft-primary" aria-label="View"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Xem chi tiết">
                                                                    <i class="ri-eye-line"></i>
                                                                </button>
                                                            </a>
                                                        </div>
                                                        <div class="remove">
                                                            <form id="deleteForm-{{ $enterprise->id }}"
                                                                action="{{ route('system-admin.enterprise.destroy', $enterprise->id) }}"
                                                                method="POST" class="m-0"
                                                                style="display: inline-block;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-danger"
                                                                    aria-label="Delete" data-bs-toggle="tooltip"
                                                                    title="Xóa"
                                                                    onclick="confirmDelete('{{ $enterprise->id }}')">
                                                                    <i class="ri-delete-bin-2-line"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if (empty($admin_enterprises) || $admin_enterprises->isEmpty())
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
                                        @if ($admin_enterprises->total() > $admin_enterprises->perPage())
                                            <a class="page-item pagination-prev {{ $admin_enterprises->onFirstPage() ? 'disabled' : '' }}"
                                                href="{{ $admin_enterprises->previousPageUrl() }}">Trở về</a>
                                            <ul class="pagination listjs-pagination mb-0">
                                                @foreach ($admin_enterprises->getUrlRange(1, $admin_enterprises->lastPage()) as $page => $url)
                                                    <li
                                                        class="{{ $admin_enterprises->currentPage() == $page ? 'active' : '' }}">
                                                        <a class="page"
                                                            href="{{ $url }}">{{ $page }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <a class="page-item pagination-next {{ $admin_enterprises->hasMorePages() ? '' : 'disabled' }}"
                                                href="{{ $admin_enterprises->nextPageUrl() }}">Tiếp</a>
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
