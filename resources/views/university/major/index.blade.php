@extends('admin.layouts.master')
@section('content')
<style>
    .toast-success {
        background-color: #059669 !important;
        color: #fff !important;
    }

    .toast-error {
        background-color: #e74c3c !important;
        color: #fff !important;
    }
</style>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">{{ $config['major']['index']['title'] }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Quản lí ngành học</a></li>
                            <li class="breadcrumb-item active">Danh sách</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">{{ $config['major']['index']['table'] }}</h4>

                    </div>

                    <div class="card-body">
                        <div class="listjs-table" id="customerList">
                            <div class="row g-4 mb-3">
                                <div class="col-sm-auto">
                                    <div>
                                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal">
                                            <i class="ri-add-line align-bottom me-1"></i> Thêm mới
                                        </button>
                                    </div>
                                </div>

                                <div class="col-sm">
                                    <form action="{{ route('university.major.index') }}" method="GET">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="search-box ms-2">
                                                <input type="text" name="keyword" value="{{ request('keyword') ?: old('keyword') }}" class="form-control search" placeholder="Tìm kiếm..." onchange="this.form.submit()">
                                                <i class="ri-search-line search-icon"></i>
                                            </div>
                                            <div class="search-box ms-2">
                                                <button type="submit" class="btn btn-success w-100">
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
                                            <th class="sort" data-sort="customer_name">Tên chuyên ngành</th>
                                            <th class="sort" data-sort="description">Mô tả</th>
                                            <th class="sort" data-sort="created_at">Ngày tạo</th>
                                            <th class="sort text-center" data-sort="status">Trạng thái</th>
                                            <th class="text-center" data-sort="status">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach($majors as $index => $major)
                                        <tr class>
                                            <td class="STT">{{$index + 1}}</td>
                                            <td class="customer_name">{{$major->name}}</td>
                                            <td class="description">{{$major->description}}</td>
                                            <td class="created_at">{{ \Carbon\Carbon::parse($major->created_at)->format('d/m/Y') }}</td>
                                            @php
                                            $statusLabels = [
                                            UN_APPROVE => ['class' => 'bg-danger', 'text' => 'Từ chối'],
                                            PENDING_APPROVE => ['class' => 'bg-warning', 'text' => 'Chờ duyệt'],
                                            APPROVED => ['class' => 'bg-success', 'text' => 'Đã duyệt'],
                                            ];
                                            @endphp
                                            <td class="text-center status">
                                                <span class="badge {{ $statusLabels[$major->status]['class'] }}">
                                                    {{ $statusLabels[$major->status]['text'] }}
                                                </span>
                                            </td>
                                            <td class="d-flex justify-content-center">
                                                <div class="d-flex gap-2">
                                                    @if($major->status === PENDING_APPROVE || $major->status === UN_APPROVE)
                                                    <!-- Cho phép sửa và xóa nếu trạng thái là "Chưa duyệt" -->
                                                    <div class="edit">
                                                        <button
                                                            type="button"
                                                            class="btn btn-warning"
                                                            data-bs-toggle="modal"
                                                            id="create-btn"
                                                            data-bs-target="#showModalEdit"
                                                            data-id="{{ $major->id }}">
                                                            <i class="las la-edit"></i>
                                                        </button>
                                                    </div>
                                                    @else

                                                    <div class="edit">
                                                        <button class="btn btn-warning" aria-label="Edit" disabled>
                                                            <i class="las la-edit"></i>
                                                        </button>
                                                    </div>
                                                    @endif

                                                    <div class="remove">
                                                        <form id="deleteForm-{{ $major->id }}" action="{{ route('university.major.destroy', $major->id ) }}" method="POST" class="m-0" style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger" aria-label="Delete" onclick="confirmDelete('{{ $major->id }}')">
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
                            @if(empty($majors) || $majors->isEmpty())
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
                                    @if ($majors->total() >= 10)

                                    <a class="page-item pagination-prev {{ $majors->onFirstPage() ? 'disabled' : '' }}"
                                        href="{{ $majors->appends(request()->query())->previousPageUrl() }}">Trở về</a>

                                    <ul class="pagination listjs-pagination mb-0">
                                        @foreach ($majors->appends(request()->query())->getUrlRange(1, $majors->lastPage()) as $page => $url)
                                        <li class="{{ $majors->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                        @endforeach
                                    </ul>

                                    <a class="page-item pagination-next {{ $majors->hasMorePages() ? '' : 'disabled' }}"
                                        href="{{ $majors->appends(request()->query())->nextPageUrl() }}">Tiếp</a>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create -->
        <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light p-3">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm chuyên ngành</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                    </div>
                    <form id="major-form-add" action="{{ route('university.major.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="major-name-field" class="form-label fw-bold">Tên chuyên ngành</label>
                                <input type="text" id="major-name-field" name="name" class="form-control border-primary" placeholder="Nhập tên chuyên ngành">
                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <div class="invalid-feedback">Vui lòng nhập tên chuyên ngành.</div>
                            </div>
                            <div class="mb-3">
                                <label for="major-description-field" class="form-label fw-bold">Mô tả chuyên ngành</label>
                                <textarea id="major-description-field" name="description" class="form-control border-primary" placeholder="Nhập mô tả chuyên ngành"></textarea>
                                @error('description')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <div class="invalid-feedback">Vui lòng nhập mô tả chuyên ngành.</div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                                <button type="submit" class="btn btn-primary" id="add-btn"><i class="ri-save-3-line"></i> Lưu</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="showModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light p-3">
                        <h5 class="modal-title" id="exampleModalLabel">Cập nhật chuyên ngành</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                    </div>
                    <form id="major-form" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <input type="hidden" id="major-id1" value="">
                                <label for="major-name-field" class="form-label fw-bold">Tên chuyên ngành</label>
                                <input type="text" id="major-name-field1" name="name" class="form-control border-primary" value="" placeholder="Nhập tên chuyên ngành">
                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="major-description-field" class="form-label fw-bold">Mô tả chuyên ngành</label>
                                <textarea id="major-description-field1" name="description" class="form-control border-primary" placeholder="Nhập mô tả chuyên ngành"></textarea>
                                @error('description')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                                <button type="submit" class="btn btn-primary" id="update-btn"><i class="ri-save-3-line"></i> Lưu</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
</div>

<script>
    document.getElementById('major-form-add').addEventListener('submit', function(event) {

        const majorNameField = document.getElementById('major-name-field');
        const majorDescriptionField = document.getElementById('major-description-field');

        let isValid = true;

        if (!majorNameField.value.trim()) {
            majorNameField.classList.add('is-invalid');
            isValid = false;
        } else if (majorNameField.value.trim().length > 50) {
            majorNameField.classList.add('is-invalid');
            majorNameField.nextElementSibling.innerText = "Tên không được quá 50 ký tự.";
            isValid = false;
        } else {
            majorNameField.classList.remove('is-invalid');
            majorNameField.nextElementSibling.innerText = ""; 
        }
        if (!majorDescriptionField.value.trim()) {
            majorDescriptionField.classList.add('is-invalid');
            isValid = false;
        } else {
            majorDescriptionField.classList.remove('is-invalid');
        }

        if (!isValid) {
            event.preventDefault();
        }
    });
</script>


<script>
    $(document).on('click', '.btn-warning', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '/university/major/edit/' + id,
            method: 'GET',
            success: function(response) {
                console.log($('#major-form').data('id', id));

                $('#major-id1').val(id);
                $('#major-name-field1').val(response.name);
                $('#major-description-field1').val(response.description);
                $('#showModalEdit').modal('show');

            },
            error: function(xhr) {
                alert('Không tìm thấy chuyên ngành');
            }
        });
    });

    $(document).on('submit', '#major-form', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Bạn có chắc chắn muốn cập nhật không?',
            text: 'Dữ liệu này sẽ không thể phục hồi!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Cập nhật',
            cancelButtonText: 'Hủy',
            reverseButtons: true
        }).then((result) => {

            if (result.isConfirmed) {
                var id = $('#major-id1').val();
                console.log(id);

                var formData = {
                    name: $('#major-name-field1').val(),
                    description: $('#major-description-field1').val(),
                    _token: $('input[name="_token"]').val(),
                    _method: 'PUT'
                };
                console.log(formData);

                $.ajax({
                    url: '/university/major/update/' + id,
                    method: 'PUT',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.href = '/university/major';
                            $('#showModalEdit').modal('hide');
                        } else {
                            toastr.error(response.message, 'Error', {
                                closeButton: true,
                                progressBar: true,
                                positionClass: 'toast-top-right',
                                timeOut: 5000
                            });
                        }
                    },
                    error: function(xhr) {
                        alert('Có lỗi xảy ra: ' + xhr.responseText);
                    }
                });
            } else {
                console.log('Cập nhật đã bị hủy');
            }
        });
    });
</script>
@endsection