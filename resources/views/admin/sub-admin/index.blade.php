@extends('admin.layouts.master')
@section('title', 'Danh sách sub-admin')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">{{ $config['list']['list'] }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $config['list']['title'] }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ $config['list']['list'] }}</li>
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
                                            <a href="{{ route('system-admin.sub-admin.create') }}">
                                                <button type="button" class="btn btn-success add-btn"><i
                                                        class="ri-add-line align-bottom me-1"></i> Thêm mới</button>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <form action="{{ route('system-admin.sub-admin.index') }}" method="GET">
                                            <div class="d-flex justify-content-sm-end">
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
                                                <th class="sort" data-sort="id">ID</th>
                                                <th class="sort" data-sort="username">Tên tài khoản</th>
                                                <th class="sort" data-sort="email">Email</th>
                                                <th class="no-sort">Điện thoại</th>
                                                <th class="no-sort text-center">Trạng thái</th>
                                                <th class="no-sort text-center">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($sub_admins as $sub_admin)
                                                <tr>
                                                    <td class="id">
                                                        {{ ($sub_admins->currentPage() - 1) * $sub_admins->perPage() + $loop->iteration }}
                                                    </td>
                                                    <td class="username">{{ $sub_admin->username }}</td>
                                                    <td class="email">{{ $sub_admin->email }}</td>
                                                    <td class="phone">{{ $sub_admin->phone }}</td>
                                                    <td class="status js-switch-{{ $sub_admin->id }}">
                                                        <div
                                                            class="form-check form-switch form-switch-custom form-switch-success text-center">
                                                            <input class="form-check-input"
                                                                value="{{ $sub_admin->is_active }}" type="checkbox"
                                                                data-field="is_active" data-model="User"
                                                                data-modelId="{{ $sub_admin->id }}"
                                                                {{ $sub_admin->is_active == IS_ACTIVE ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td class="d-flex justify-content-center">
                                                        <div class="d-flex gap-2">
                                                            <div class="eye">
                                                                <a
                                                                    href="{{ route('system-admin.sub-admin.show', $sub_admin->id) }}">
                                                                    <button class="btn btn-soft-primary" aria-label="View"
                                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        title="Xem chi tiết">
                                                                        <i class="ri-eye-line"></i>
                                                                    </button>
                                                                </a>
                                                            </div>

                                                            <div class="edit">
                                                                <a
                                                                    href="{{ route('system-admin.sub-admin.edit', $sub_admin->id) }}">
                                                                    <button class="btn btn-warning" aria-label="Edit"
                                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        title="Sửa">
                                                                        <i class="las la-edit"></i>
                                                                    </button>
                                                                </a>
                                                            </div>
                                                            <div class="remove">
                                                                <form id="deleteForm-{{ $sub_admin->id }}"
                                                                    action="{{ route('system-admin.sub-admin.destroy', $sub_admin->id) }}"
                                                                    method="POST" class="m-0"
                                                                    style="display: inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button" class="btn btn-danger"
                                                                        aria-label="Delete" data-bs-toggle="tooltip"
                                                                        data-bs-placement="top" title="Xoá"
                                                                        onclick="confirmDelete('{{ $sub_admin->id }}')">
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

                                <div class="d-flex justify-content-end">
                                    <div class="pagination-wrap hstack gap-2">
                                        @if ($sub_admins->total() > $sub_admins->perPage())
                                            <a class="page-item pagination-prev {{ $sub_admins->onFirstPage() ? 'disabled' : '' }}"
                                                href="{{ $sub_admins->previousPageUrl() }}">Trở về</a>
                                            <ul class="pagination listjs-pagination mb-0">
                                                @foreach ($sub_admins->getUrlRange(1, $sub_admins->lastPage()) as $page => $url)
                                                    <li class="{{ $sub_admins->currentPage() == $page ? 'active' : '' }}">
                                                        <a class="page"
                                                            href="{{ $url }}">{{ $page }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <a class="page-item pagination-next {{ $sub_admins->hasMorePages() ? '' : 'disabled' }}"
                                                href="{{ $sub_admins->nextPageUrl() }}">Tiếp</a>
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
