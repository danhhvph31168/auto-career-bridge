<div>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">{{ $config['title'] }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">{{ $config['title'] }}</li>
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
                                    <div class="col-sm-2 d-flex gap-2 align-items-center" wire:ignore>
                                        <select class="form-select" style="width: 70px"
                                            aria-label="Default select example" wire:model="perpage"
                                            wire:change="getDataSearch">
                                            @for ($i = 5; $i < 50; $i += 10)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                        <span>Số lượng bản ghi</span>
                                    </div>

                                    <div class="col-sm">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="col-sm-auto">
                                                <select class="form-select" aria-label="Default select example"
                                                    wire:model="status" wire:change="getDataSearch">
                                                    <option value="">Tất cả</option>
                                                    <option value="0">Chờ duyệt</option>
                                                    <option value="1">Đã duyệt</option>
                                                    <option value="2">Đã hủy</option>
                                                </select>
                                            </div>
                                            <div class="search-box ms-2">
                                                <input type="text" name="keyword" class="form-control search"
                                                    wire:model="keyword" placeholder="Tìm kiếm..."
                                                    wire:keydown.enter="getDataSearch">
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
                                                <th class="sort" data-sort="username">Tên tài khoản</th>
                                                <th class="sort" data-sort="name">Tên trường học</th>
                                                <th class="sort" data-sort="email">Email</th>
                                                <th class="sort" data-sort="phone">Phone</th>
                                                <th class=" text-center" data-sort="">Trạng thái</th>
                                                <th class="text-center">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($users as $key => $user)
                                                <tr class>
                                                    <td class="customer_name stt">
                                                        {{ $key + 1 + $users->perPage() * ($users->currentPage() - 1) }}
                                                    </td>
                                                    <td class="customer_name username">{{ $user->username }}</td>
                                                    <td class="name">
                                                        {{ $user->university->name ?? '' }}</td>
                                                    <td class="email">{{ $user->email }}</td>
                                                    <td class="phone">{{ str_pad($user->phone, 10, 0, STR_PAD_LEFT) }}
                                                    </td>
                                                    <td class=" text-center js-switch-{{ $user->id }}">
                                                        <span
                                                            class="badge bg-{{ $user->status == 0 ? 'warning' : ($user->status == 1 ? 'success' : 'danger') }}">
                                                            {{ $user->status == 0 ? 'Đang chờ duyệt' : ($user->status == 1 ? 'Đã duyệt' : 'Đã từ chối') }}
                                                        </span>
                                                    </td>
                                                    <td class="d-flex gap-2 justify-content-center">
                                                        <div class="show">
                                                            <a class="edit"
                                                                href="{{ route('system-admin.university.detal', $user->id) }}">
                                                                <button class="btn btn-soft-primary" aria-label="Edit"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Xem chi tiết">
                                                                    <i class="ri-eye-line"></i>
                                                                </button>
                                                            </a>
                                                        </div>
                                                        <div class="remove">
                                                            <button type="button"
                                                                onclick="showSweetAlert({{ $user->id }})"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Xóa" class="btn btn-danger"
                                                                aria-label="Delete">
                                                                <i class="ri-delete-bin-2-line"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>

                                    </table>
                                    @if (empty($users) || $users->isEmpty())
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
                                @if ($users->hasPages())
                                    <div class="d-flex justify-content-end">
                                        <div class="pagination-wrap hstack gap-2">
                                            <button class="page-item pagination-prev"
                                                wire:click="setPage({{ $users->currentPage() - 1 }})">Trở về</button>
                                            <ul class="pagination listjs-pagination mb-0">
                                                @for ($i = 1; $i <= $users->lastPage(); $i++)
                                                    <li class="{{ $users->currentPage() == $i ? 'active' : '' }}">
                                                        <button class="page"
                                                            wire:click="setPage({{ $i }})">{{ $i }}</button>
                                                    </li>
                                                @endfor
                                            </ul>
                                            <button class="page-item pagination-next"
                                                @if ($users->currentPage() !== $users->lastPage()) wire:click="setPage({{ $users->currentPage() + 1 }})" @endif>Tiếp</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script script script defer src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>
    <script>
        let isListenerAdded = false;

        function showSweetAlert(id) {
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
                    Livewire.dispatch('deleteAccount', {
                        id: id,
                    });
                    if (!isListenerAdded) {
                        Livewire.on('accountDeleted', (data) => {
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
