<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">{{ $config['index'] }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $config['index'] }}</a>
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
                    $currentStatus = $statusClasses[$workshop->status] ?? ['bg-secondary', 'Không xác định'];
                @endphp
                <div class="card-body">


                    <div class="row">
                        <div class="col-md-4 left-column">
                            <h4 class="fw-semibold mb-3">Thông tin hội thảo</h4>
                            <p>Thông tin chi tiết của buổi hội thảo và nơi tổ chức</p>


                        </div>

                        <div class="col-md-8 right-column">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tên trường</label>
                                        <p class="border p-2 rounded">{{ $university->name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <p class="border p-2 rounded">{{ $university->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Số điện thoại </label>
                                        <p class="border p-2 rounded">{{ $university->phone }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Chuyên ngành</label>
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
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tên hội thảo </label>
                                        <p class="border p-2 rounded">{{ $workshop->title }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Website </label>
                                        <p class="border p-2 rounded">{{ $university->url }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ngày bắt đầu </label>
                                        <p class="border p-2 rounded">
                                            {{ \Carbon\Carbon::parse($workshop->start_date)->format('d-m-Y') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ngày kết thúc </label>
                                        <p class="border p-2 rounded">
                                            {{ \Carbon\Carbon::parse($workshop->start_date)->format('d-m-Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label class="form-label font-weight-bold">Trạng thái phê
                                                        duyệt</label><br>
                                                    <span
                                                        class="badge {{ $statusLabels[$workshop->status]['class'] }}  px-3 py-2 rounded-pill">
                                                        {{ $statusLabels[$workshop->status]['text'] }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-2">
                                                    <label class="form-label font-weight-bold">Trạng thái hoạt động
                                                    </label><br>
                                                    <span
                                                        class="badge  {{ $isActiveLabels[$workshop->is_active]['class'] }} px-3 py-2 rounded-pill">
                                                        {{ $isActiveLabels[$workshop->is_active]['text'] }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <label class="form-label">Yêu cầu</label>
                                        <div class="border p-2 rounded">{!! $workshop->requirement !!}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <label class="form-label">Mô tả</label>
                                        <div class="border p-2 rounded">{!! $workshop->description !!}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items- justify-content-between gap-3 mt-4">
                                <a href="{{ route('system-admin.workshop.list') }}">
                                    <button type="button" class="btn btn-light btn-label">
                                        <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                        Trở về
                                    </button>
                                </a>
                                <form action="{{ route('system-admin.workshop.approve', $workshop->id) }}"
                                    method="post">
                                    @csrf
                                    @if (!$workshop->status)
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn  btn-success">
                                                <i class="ri-flag-line"></i>
                                                Phê duyệt
                                            </button>
                                            <button type="button"
                                                class="btn  btn-outline-danger waves-effect waves-light material-shadow-none"
                                                onclick="showSweetAlert({{ $workshop->id }})" type="button">
                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                Từ chối
                                            </button>
                                        </div>
                                    @else
                                        <button type="button" class="btn {{ $currentStatus[0] }}" style="color: #fff">
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
                const url = `/system-admin/workshop/reject/${id}`
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
                    title: "Đã từ chối workshop",
                    icon: "success",
                    draggable: true
                }).then((result) => {
                    window.location.href = `{{ route('system-admin.workshop.list') }}`
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
            renderChoiceLimit: 0,
            noChoicesText: '',
            closeDropdownOnSelect: true
        });
    });
</script>
