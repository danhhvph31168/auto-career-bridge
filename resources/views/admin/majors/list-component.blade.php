<div>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">{{ $config['index'] }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">{{ $config['index'] }}</li>
                                <li class="breadcrumb-item active">{{ $config['list'] }}</li>
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
                                    <div class="col-sm-2 d-flex align-items-center gap-2" wire:ignore>
                                        <div>
                                            <button type="button" class="btn btn-success add-btn"
                                                data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal">
                                                <i class="ri-add-line align-bottom me-1"></i> Thêm mới
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <div class="d-flex justify-content-sm-end">

                                            <div class="col-sm-auto ms-2">
                                                <select class="form-select" aria-label="Default select example"
                                                    wire:model.change="status">
                                                    <option value="">Tất cả</option>
                                                    <option value="0">Chờ phê duyệt</option>
                                                    <option value="1">Đã duyệt</option>
                                                    <option value="2">Đã hủy</option>
                                                </select>
                                            </div>
                                            <div class="search-box ms-2">
                                                <input type="text" class="form-control search"
                                                    wire:model.change="keyword" placeholder="Tìm kiếm...">
                                                <i class="ri-search-line search-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table align-middle table-nowrap" id="customerTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="sort" data-sort="stt">STT</th>
                                                <th class="sort" data-sort="username">Tên chuyên ngành</th>
                                                <th class="sort" data-sort="name">Mô tả</th>
                                                <th class=" text-center" data-sort="">Trạng thái</th>
                                                <th class="text-center">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($majors as $key => $major)
                                                <tr class>
                                                    <td class="customer_name stt">
                                                        {{ $key + 1 + $majors->perPage() * ($majors->currentPage() - 1) }}
                                                    </td>
                                                    <td class="customer_name username">{{ $major->name }}</td>
                                                    <td class="name">{{ $major->description }}</td>
                                                    <td class="text-center">
                                                        <span
                                                            class="badge bg-{{ $major->status == 0 ? 'warning' : ($major->status == 1 ? 'success' : 'danger') }}">
                                                            {{ $major->status == 0 ? 'Đang chờ duyệt' : ($major->status == 1 ? 'Đã duyệt' : 'Đã từ chối') }}
                                                        </span>
                                                    </td>
                                                    <td class="d-flex gap-2 justify-content-center">
                                                        <div class="show">
                                                            <button class="btn btn-soft-primary" aria-label="Edit"
                                                                data-bs-placement="top" data-bs-toggle="modal"
                                                                id="create-btn"
                                                                data-bs-target="#ModalMajor{{ $major->id }}">
                                                                <i class="ri-eye-line"></i>
                                                            </button>
                                                        </div>
                                                        <div class="remove">
                                                            <button type="button" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Xóa"
                                                                onclick="showDeleteAlert({{ $major->id }})"
                                                                class="btn btn-danger" aria-label="Delete">
                                                                <i class="ri-delete-bin-2-line"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="ModalMajor{{ $major->id }}"
                                                    tabindex="-1" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-light p-3">
                                                                <h5 class="modal-title" id="exampleModalLabel">
                                                                    Thông tin chuyên ngành</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"
                                                                    id="close-modal{{ $major->id }}"></button>
                                                            </div>
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="major-name-field"
                                                                        class="form-label fw-bold">Tên chuyên
                                                                        ngành</label>
                                                                    <p class="border p-2 rounded">
                                                                        {{ $major->name }}</p>

                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="major-description-field"
                                                                        class="form-label fw-bold">Mô tả chuyên
                                                                        ngành</label>
                                                                    <div class="border p-2 rounded">
                                                                        {{ $major->description }}</div>

                                                                </div>
                                                            </div>
                                                            @php
                                                                $statusClasses = [
                                                                    0 => ['bg-warning', 'Đang chờ duyệt'],
                                                                    1 => ['bg-success', 'Đã duyệt'],
                                                                    2 => ['bg-danger', 'Đã từ chối'],
                                                                ];
                                                                $currentStatus = $statusClasses[$major->status] ?? [
                                                                    'bg-secondary',
                                                                    'Không xác định',
                                                                ];
                                                            @endphp
                                                            <div class="modal-footer bg-light">
                                                                @if (!$major->status)
                                                                    <div class="d-flex gap-2">
                                                                        <form
                                                                            action="{{ route('system-admin.major.approve', $major->id) }}"
                                                                            method="post">
                                                                            @csrf
                                                                            <button type="submit"
                                                                                class="btn  btn-success">
                                                                                <i class="ri-flag-line"></i>
                                                                                Phê duyệt
                                                                            </button>
                                                                        </form>
                                                                        <button type="button"
                                                                            class="btn btn-outline-danger waves-effect waves-light material-shadow-none"
                                                                            type="button"
                                                                            onclick="showSweetAlert({{ $major->id }})">
                                                                            <i
                                                                                class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                            Từ chối
                                                                        </button>
                                                                    </div>
                                                                @else
                                                                    <button type="button"
                                                                        class="btn {{ $currentStatus[0] }}"
                                                                        style="color: #fff">
                                                                        <i class="ri-flag-line"></i>
                                                                        {{ $currentStatus[1] }}
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </tbody>

                                    </table>
                                    @if (empty($majors) || $majors->isEmpty())
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
                                @if ($majors->hasPages())
                                    <div class="d-flex justify-content-end">
                                        <div class="pagination-wrap hstack gap-2">
                                            <button class="page-item pagination-prev"
                                                wire:click="setPage({{ $majors->currentPage() - 1 }})">Trở
                                                về</button>
                                            <ul class="pagination listjs-pagination mb-0">
                                                @for ($i = 1; $i <= $majors->lastPage(); $i++)
                                                    <li class="{{ $majors->currentPage() == $i ? 'active' : '' }}">
                                                        <button class="page"
                                                            wire:click="setPage({{ $i }})">{{ $i }}</button>
                                                    </li>
                                                @endfor
                                            </ul>
                                            <button class="page-item pagination-next"
                                                @if ($majors->currentPage() !== $majors->lastPage()) wire:click="setPage({{ $majors->currentPage() + 1 }})" @endif>Tiếp</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Create Major --}}
            <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light p-3">
                            <h5 class="modal-title" id="exampleModalLabel">Thêm chuyên ngành</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                id="close-modal"></button>
                        </div>
                        <form id="major-form-add" action="{{ route('system-admin.major.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="major-name-field" class="form-label fw-bold">Tên chuyên ngành</label>
                                    <input type="text" id="major-name-field" name="name"
                                        class="form-control border-primary" placeholder="Nhập tên chuyên ngành">
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <div class="invalid-feedback">Vui lòng nhập tên chuyên ngành.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="major-description-field" class="form-label fw-bold">Mô tả chuyên
                                        ngành</label>
                                    <textarea id="major-description-field" name="description" class="form-control border-primary"
                                        placeholder="Nhập mô tả chuyên ngành"></textarea>
                                    @error('description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <div class="invalid-feedback">Vui lòng nhập mô tả chuyên ngành.</div>
                                </div>
                            </div>
                            <div class="modal-footer bg-light">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-outline-secondary"
                                        data-bs-dismiss="modal">Hủy bỏ</button>
                                    <button type="submit" class="btn btn-primary" id="add-btn"><i
                                            class="ri-save-3-line"></i> Lưu</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>
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
        function showSweetAlert(id) {
            let modal = document.getElementById('close-modal' + id)
            modal.click()
            Swal.fire({
                title: "Vui lòng nhập lý do từ chối",
                input: "text",
                inputAttributes: {
                    autocapitalize: "off",
                    forcus: "true"
                },
                inputValidator: (value) => {
                    if (!value) {
                        return "Bạn chưa nhập lí do từ chối";
                    }
                },
                showCancelButton: true,
                confirmButtonText: "Từ chối",
                showLoaderOnConfirm: true,
                customClass: {
                    confirmButton: 'btn me-2 btn-success',
                    cancelButton: 'btn btn-outline-danger',
                    input: 'form-control z-index-100'
                },
                buttonsStyling: false,
                preConfirm: async (reason) => {
                    const url = `/system-admin/major/reject/${id}`
                    const response = await fetch(url, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            reason: reason
                        })
                    });
                    const result = await response.json()

                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Đã từ chối major",
                        icon: "success",
                        draggable: true
                    }).then((result) => {
                        window.location.href = `{{ route('system-admin.major.list') }}`
                    });

                }
            });
        }
        let isListenerAdded = false;

        function showDeleteAlert(id) {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa không?',
                text: 'Dữ liệu này sẽ không thể phục hồi!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Đang xử lý...',
                        text: 'Vui lòng đợi...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    Livewire.dispatch('deleteMajor', {
                        id: id,
                    });
                    if (!isListenerAdded) {
                        Livewire.on('majorDeleted', (data) => {
                            console.log(data);

                            Swal.close();
                            if (data[0]) {
                                flasher.success('Xóa tài khoản thành công');
                            } else {
                                flasher.error('Xóa tài khoản thất bại');
                            }
                        });
                        isListenerAdded = true
                        cleanup()
                        isListenerAdded = false
                    }
                }
            });
        }
    </script>

</div>
