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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Quản lí giáo vụ</a></li>
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
                                        <a href="{{ route('university.create') }}">
                                            <button type="button" class="btn btn-success add-btn">
                                                <i class="ri-add-line align-bottom me-1"></i> Thêm mới
                                            </button>
                                        </a>
                                        <a href="{{ route('university.exportExcelFileUser') }}">
                                            <button type="button" class="btn btn-primary btn_import">
                                                <i class="ri-download-line"></i> Export
                                            </button>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-sm">
                                    <form action="{{ route('university.index') }}" method="GET">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="search-box ms-2">
                                                <input type="text" name="keyword" value="{{ request('keyword') ?: old('keyword') }}" class="form-control search" placeholder="Tìm kiếm..." onchange="this.form.submit()">
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
                                            <th class="sort" data-sort="STT">STT</th>
                                            <th class="sort" data-sort="customer_name">Tên tài khoản</th>
                                            <th class="sort" data-sort="email">Email</th>
                                            <th class="sort" data-sort="phone">Phone</th>
                                            <th class="sort" data-sort="created_at">Ngày tạo</th>
                                            <th class="sort text-center" data-sort="status">Trạng thái</th>
                                            <th class="text-center">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach($universities as $index => $university)
                                        <tr class>
                                            <td class="STT">{{$index + 1}}</td>
                                            <td class="customer_name">{{$university->username}}</td>
                                            <td class="email">{{$university->email}}</td>
                                            <td class="phone">{{ str_pad($university->phone, 10, 0, STR_PAD_LEFT) }}</td>
                                            <td class="created_at">{{ \Carbon\Carbon::parse($university->created_at)->format('d/m/Y') }}</td>
                                            <td class="status js-switch-{{ $university->id }}">
                                                <div class="form-check form-switch form-switch-custom form-switch-success text-center">
                                                    <input class="form-check-input"
                                                        value="{{ $university->is_active }}"
                                                        type="checkbox"
                                                        data-field="is_active"
                                                        data-model="User"
                                                        data-modelId="{{ $university->id }}"
                                                        {{ ($university->is_active == IS_ACTIVE) ? 'checked' : '' }}>
                                                </div>
                                            </td>
                                            <td class="d-flex justify-content-center">
                                                <div class="d-flex gap-2">
                                                    <div class="edit">
                                                        <a href="{{ route('university.edit', $university->id) }}">
                                                            <button class="btn btn-warning" aria-label="Edit">
                                                                <i class="las la-edit"></i>
                                                            </button>
                                                        </a>
                                                    </div>
                                                    <div class="remove">
                                                        <form id="deleteForm-{{ $university->id }}" action="{{ route('university.destroy', $university->id) }}" method="POST" class="m-0" style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger" aria-label="Delete" onclick="confirmDelete('{{ $university->id }}')">
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
                                @if (empty($universities) || $universities->isEmpty())
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
                                    @if ($universities->total() >= 10)

                                    <a class="page-item pagination-prev {{ $universities->onFirstPage() ? 'disabled' : '' }}"
                                        href="{{ $universities->appends(request()->query())->previousPageUrl() }}">Trở về</a>

                                    <ul class="pagination listjs-pagination mb-0">
                                        @foreach ($universities->appends(request()->query())->getUrlRange(1, $universities->lastPage()) as $page => $url)
                                        <li class="{{ $universities->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                        @endforeach
                                    </ul>

                                    <a class="page-item pagination-next {{ $universities->hasMorePages() ? '' : 'disabled' }}"
                                        href="{{ $universities->appends(request()->query())->nextPageUrl() }}">Tiếp</a>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light p-3">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                    </div>
                    <form action="{{ route('university.importExcelFile')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="customername-field" class="form-label">Nhập file</label>
                                <input type="file" id="customername-field" name="file" class="form-control" placeholder="Nhập tên file" required="">
                                @error('file')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <div class="invalid-feedback">Please enter a customer name.</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy bỏ</button>
                                <button type="submit" class="btn btn-success" id="add-btn"><i class="ri-file-excel-2-line"></i> Import</button>
                                <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection