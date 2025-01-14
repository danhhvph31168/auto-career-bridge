<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">{{ $config['title'] }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $config['title'] }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $config['show'] }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-12">
                @php
                    $statusLabels = [
                        UN_APPROVE => ['class' => 'bg-danger', 'text' => 'Từ chối'],
                        PENDING_APPROVE => ['class' => 'bg-warning', 'text' => 'Chờ phê duyệt'],
                        APPROVED => ['class' => 'bg-success', 'text' => 'Đã phê duyệt'],
                    ];

                    $isActiveLabels = [
                        IS_ACTIVE => [
                            'class' => 'bg-success',
                            'text' => 'Hoạt động',
                        ],
                        UN_ACTIVE => [
                            'class' => 'bg-danger',
                            'text' => 'Không hoạt động',
                        ],
                    ];
                @endphp
                @php
                    $statusClasses = [
                        0 => ['bg-warning', 'Đang chờ duyệt'],
                        1 => ['bg-success', 'Đã duyệt'],
                        2 => ['bg-danger', 'Đã từ chối'],
                    ];
                    $currentStatus = $statusClasses[$user->status] ?? ['bg-secondary', 'Không xác định'];
                @endphp
                <div class="card-body">


                    <div class="row">
                        <div class="col-md-4 left-column">
                            <h4 class="fw-semibold mb-3">Thông tin tài khoản
                            </h4>
                            <div>
                                @if (!empty($user->avatar) && filter_var($user->avatar, FILTER_VALIDATE_URL))
                                    <img src="{{ $user->avatar }}" width="20%" alt="Avatar">
                                @elseif (!empty($user->avatar) && Storage::exists($user->avatar))
                                    <img src="{{ Storage::url($user->avatar) }}" width="20%" alt="Avatar">
                                @else
                                    <img src="https://placehold.co/50" alt="Default Avatar" class="img-fluid">
                                @endif
                            </div>

                            <h4 class="fw-semibold mb-3" style="margin-top: 30%;">Thông tin trường học</h4>
                            <div>
                                @if (!empty($university->logo) && filter_var($university->logo, FILTER_VALIDATE_URL))
                                    <img src="{{ $university->logo }}" width="20%" alt="logo">
                                @elseif (!empty($university->logo) && Storage::exists($university->logo))
                                    <img src="{{ Storage::url($university->logo) }}" width="20%" alt="logo">
                                @else
                                    <img src="https://placehold.co/50" alt="Default logo" class="img-fluid">
                                @endif
                            </div>
                        </div>

                        <div class="col-md-8 right-column">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tên tài khoản </label>
                                        <p class="border p-2 rounded">{{ $user->username }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <p class="border p-2 rounded">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Số điện thoại </label>
                                        <p class="border p-2 rounded">{{ $user->phone }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label class="form-label font-weight-bold">Trạng thái phê
                                                        duyệt</label><br>
                                                    <span
                                                        class="badge {{ $statusLabels[$user->status]['class'] }}  px-3 py-2 rounded-pill">
                                                        {{ $statusLabels[$user->status]['text'] }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label class="form-label font-weight-bold">Trạng thái hoạt động
                                                    </label><br>
                                                    <span
                                                        class="badge  {{ $isActiveLabels[$user->is_active]['class'] }} px-3 py-2 rounded-pill">
                                                        {{ $isActiveLabels[$user->is_active]['text'] }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tên trường </label>
                                        <p class="border p-2 rounded">{{ $university->name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email </label>
                                        <p class="border p-2 rounded">{{ $university->email }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Số điện thoại </label>
                                        <p class="border p-2 rounded">{{ $university->name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Địa chỉ </label>
                                        <p class="border p-2 rounded">{{ $university->address }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Website </label>
                                        <a class=" form-control border rounded p-2"
                                            href="{{ $university->url }}">Website của
                                            trường</a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Chuyên ngành </label>
                                        <select disabled class="form-control" id="choices-multiple-remove-button"
                                            name="majors[]" multiple>

                                            @foreach ($majors as $major)
                                                <option value="{{ $major->id }}" selected>
                                                    {{ $major->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <label class="form-label">Mô tả</label>
                                        <div class="border rounded p-3">{!! $university->description !!}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items- justify-content-between gap-3 mt-4">
                                <a href="{{ route('system-admin.university.users') }}">
                                    <button type="button" class="btn btn-light btn-label">
                                        <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                        Trở về
                                    </button>
                                </a>
                                <form action="{{ route('system-admin.university.approve', $user->id) }}"
                                    method="post">
                                    @csrf
                                    @if (!$user->status)
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn  btn-success">
                                                <i class="ri-flag-line"></i>
                                                Phê duyệt
                                            </button>
                                            <button type="button"
                                                class="btn  btn-outline-danger waves-effect waves-light material-shadow-none"
                                                onclick="showSweetAlert({{ $user->id }})" type="button">
                                                <i class="ri-delete-bin-fill "></i>
                                                Từ chối
                                            </button>
                                        </div>
                                    @else
                                        <button type="button" class="btn {{ $currentStatus[0] }}"
                                            style="color: #fff">
                                            <i class="ri-flag-line"></i>
                                            {{ $currentStatus[1] }}
                                        </button>
                                    @endif

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>




    </div><!-- container-fluid -->
</div>
<script script script defer src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>
<script>
    function showSweetAlert(id) {

        Swal.fire({
            title: "Vui lòng nhập lý do từ chối",
            input: "text",
            inputAttributes: {
                autocapitalize: "off"
            },
            inputValidator: (value) => {
                if (!value) {
                    return "Bạn chưa nhập lí do từ chối";
                }
            },
            showCancelButton: true,
            confirmButtonText: "Từ chối",
            showLoaderOnConfirm: true,
            preConfirm: async (reason) => {
                const url = `/system-admin/university/reject/${id}`
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
                    title: "Đã từ chối tài khoản",
                    icon: "success",
                    draggable: true
                }).then((result) => {
                    window.location.href = `{{ route('system-admin.university.users') }}`
                });

            }
        });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const selectElement = document.getElementById("choices-multiple-remove-button");
        const choices = new Choices(selectElement, {
            removeItemButton: false,
            searchEnabled: false,
            shouldSort: false
        });
    });
</script>
