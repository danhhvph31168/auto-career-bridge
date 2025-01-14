@extends('admin.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">{{ config('admin.enterprise.users.title') }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a
                                        href="javascript: void(0);">{{ config('admin.enterprise.users.title') }}</a></li>
                                <li class="breadcrumb-item active">{{ config('admin.enterprise.users.index.title') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
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
                        </div>
                        <div class="card-body">
                            <div class="listjs-table" id="customerList">
                                <div class=" g-4 mb-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a href="{{ route('enterprise.users.create') }}">
                                                <button type="button" class="btn btn-success add-btn"><i
                                                        class="ri-add-line align-bottom me-1"></i>{{ config('admin.enterprise.users.create .button') }}</button>
                                            </a>
                                            <a href="{{ route('enterprise.users.export') }}"><button type="button"
                                                    class="btn btn-primary btn_import">
                                                    <i class="{{ config('admin.enterprise.users.create .export.icon') }}">
                                                    </i>
                                                    {{ config('admin.enterprise.users.create .export.button') }}
                                                </button>
                                            </a>
                                        </div>
                                        <div class="search-box ms-2 d-flex">
                                            <form id="form_search" action="" method="get">
                                                <input name="keyword" value="{{ request('keyword') }}"
                                                    style="padding-right: 25px" type="text" class="form-control search"
                                                    placeholder="Tìm kiếm">
                                                <button class="btn m-0 p-0 search-icon"><i
                                                        class="ri-search-line "></i></button>
                                            </form>
                                            <a href="{{ route('enterprise.users.index') }}"><button
                                                    class="btn m-0 p-0 search-icon btn_reset_form" style="left: 192px;"><i
                                                        class="ri-close-fill"></i></button></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table align-middle table-nowrap" id="customerTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="sort" data-sort="stt">STT</th>
                                                <th class="sort" data-sort="email">Email</th>
                                                <th class="sort" data-sort="username">Tên tài khoản</th>
                                                <th class="sort" data-sort="phone">Số điện thoại</th>
                                                <th class="sort" data-sort="create_at">Ngày tạo</th>
                                                <th class="sort" data-sort="status">Trạng thái</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($users as $index => $user)
                                                <tr>
                                                    <td class="stt">
                                                        {{ $index + 1 + $users->perPage() * ($users->currentPage() - 1) }}
                                                    </td>
                                                    <td class="email">{{ $user->email }}</td>
                                                    <td class="username">{{ $user->username }}</td>
                                                    <td class="phone">{{ $user->phone }}</td>
                                                    <td class="create_at">
                                                        {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}
                                                    </td>
                                                    <td class="status">
                                                        <div class="form-check form-switch form-switch-success">
                                                            <input class="form-check-input change_is_active" type="checkbox"
                                                                role="switch" id="SwitchCheck3"
                                                                data-id="{{ $user->id }}" @checked($user->is_active)>
                                                            <label class="form-check-label" for="SwitchCheck3"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ route('enterprise.users.edit', $user) }}">
                                                                <button data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Sửa" class="btn btn-warning"
                                                                    aria-label="Edit">
                                                                    <i class="las la-edit"></i>
                                                                </button>
                                                            </a>
                                                            <div class="remove">
                                                                <form id="deleteForm-{{ $user->id }}"
                                                                    action="{{ route('enterprise.users.destroy', $user->id) }}"
                                                                    method="POST" class="m-0"
                                                                    style="display: inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        title="Xoá" type="button" class="btn btn-danger"
                                                                        aria-label="Delete"
                                                                        onclick="confirmDelete('{{ $user->id }}')">
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

                                    @if ($users->isEmpty())
                                        <div class="noresult">
                                            <div class="text-center">
                                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                                    colors="primary:#121331,secondary:#08a88a"
                                                    style="width:75px;height:75px"></lord-icon>
                                                <h5 class="mt-2">{{ config('admin.enterprise.users.notFound') }}</h5>
                                                {{-- <p class="text-muted mb-0">We've searched more than 150+ Orders We
                                                    did not find any orders for you search.</p> --}}
                                            </div>
                                        </div>
                                    @endif

                                </div>
                                {{ $users->links('pagination::bootstrap-5') }}
                            </div>
                        </div><!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                            colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>{{ config('admin.enterprise.users.delete.confirm') }}</h4>

                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <form method="post" class="form_delete">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn w-sm btn-light"
                                data-bs-dismiss="modal">{{ config('admin.enterprise.users.cancel') }}</button>
                            <button class="btn w-sm btn-danger "
                                id="delete-record">{{ config('admin.enterprise.users.delete.title') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.change_is_active').on('change', function() {
                const user_id = $(this).attr('data-id');
                const is_active = $(this).prop('checked') ?
                    '{{ IS_ACTIVE }}' :
                    '{{ UN_ACTIVE }}'

                const url_raw = `{{ route('enterprise.users.updateIsActive', ['user' => ':user']) }}`
                const url = url_raw.replace(':user', user_id)

                $.ajax({
                    url,
                    method: 'POST',
                    data: {
                        is_active,
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT',
                    },
                    success: function(res) {
                        if (res.message) {
                            flasher.error(res.message)
                        }

                        if (res.data) {
                            flasher.success(res.data.message)
                        }
                    },
                    error: function(err) {
                        if (err.responseJSON) {
                            flasher.error(err.responseJSON.message)
                        }
                    }
                });
            });
        });
    </script>
@endsection
