@extends('admin.layouts.master')

@section('css')
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/info.css') }}">
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">{{ config('admin.enterprise.jobs.show.title') }}</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h4 class="card-title mb-0 text-white">{{ config('admin.enterprise.jobs.show.description') }}
                            </h4>
                        </div>

                        <div class="card-body">

                            <div class="row">
                                {{-- <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Nhập mã <span
                                                            class="text-danger">(*)</span></label>
                                                    <input type="text" name="slug" class="form-control"
                                                        placeholder="Nhập mã" value="{{ old('slug') }}">
                                                    @error('slug')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                            </div> --}}
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tiêu đề</label>
                                        <p class="border p-2 rounded">{{ $job->title }}</p>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Thời gian làm việc</label>
                                                <p class="border p-2 rounded">{{ $job->working_time }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Chuyên ngành</label>
                                                <p class="border p-2 rounded">{{ $job->major->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Yêu cầu </label>
                                        <p class="border p-2 rounded">{{ $job->requirement }}</p>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Số lượng ứng viên<span
                                                    class="text-danger">(*)</span></label>
                                            <input type="text" name="applicants" class="form-control"
                                                value="{{ old('applicants') }}" placeholder="Nhập số lượng ứng viên">
                                            @error('applicants')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div> --}}
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Địa chỉ</label>
                                        <p class="border p-2 rounded">{{ $job->address }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Lợi ích </label>
                                        <p class="border p-2 rounded">{{ $job->benefit }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="mb-3">
                                                <label class="form-label">Kinh nghiệm </label>
                                                <p class="border p-2 rounded">{{ $job->experience_level }}</p>
                                            </div>
                                        </div>
                                        @php
                                            $type = [
                                                FULL_TIME => 'Toàn thời gian',
                                                PART_TIME => 'Bán thời gian',
                                                REMOTE => 'Làm việc từ xa',
                                            ];
                                        @endphp
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Cách thức làm việc </label>
                                                <p class="border p-2 rounded">{{ $type[$job->type] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Ngày bắt đầu </label>
                                                <p class="border p-2 rounded">
                                                    {{ \Carbon\Carbon::parse($job->start_date)->format('d/m/Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Ngày kết thúc </label>
                                                <p class="border p-2 rounded">
                                                    {{ \Carbon\Carbon::parse($job->end_date)->format('d/m/Y') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Lương </label>
                                        <p class="border p-2 rounded">{{ $job->salary ?? 'Trống' }}</p>
                                    </div>
                                </div>
                                @php
                                    $statusLabels = [
                                        PENDING_APPROVE => [
                                            'class' => 'bg-warning',
                                            'text' => 'Chờ duyệt',
                                        ],
                                        UN_APPROVE => [
                                            'class' => 'bg-danger',
                                            'text' => 'Từ chối',
                                        ],
                                        APPROVED => [
                                            'class' => 'bg-success',
                                            'text' => 'Đã duyệt',
                                        ],
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
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <h6 class="fw-semibold">Hiển thị
                                                </h6>
                                                <span
                                                    class="badge  {{ $isActiveLabels[$job->is_active]['class'] }} px-3 py-2 rounded-pill">
                                                    {{ $isActiveLabels[$job->is_active]['text'] }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <h6 class="fw-semibold">Phê duyệt
                                                </h6>
                                                <span
                                                    class="badge  {{ $statusLabels[$job->status]['class'] }} px-3 py-2 rounded-pill">
                                                    {{ $statusLabels[$job->status]['text'] }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ứng tuyển thành công</label>
                                        <p class="border p-2 rounded ung_tuyen">{{ $job->applicants }}</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Mô tả </label>
                                        <div class="border p-3 rounded">
                                            <p>{!! $job->description !!}</p>
                                        </div>
                                    </div>

                                </div>


                            </div><!-- end card-body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex bg-primary">
                                <h4 class="card-title mb-0 flex-grow-1 text-white">Danh sách trường học ứng tuyển</h4>
                                <div class="flex-shrink-0">
                                    <div class="dropdown card-header-dropdown">
                                        <div class="search-box ms-2 d-flex">
                                            <form id="form_search" action="" method="get">
                                                <input name="name" value="{{ request('name') }}"
                                                    style="padding-right: 25px" type="text" class="form-control search"
                                                    placeholder="Tìm tên trường">
                                                <button class="btn m-0 p-0 search-icon"><i
                                                        class="ri-search-line "></i></button>
                                                <button type="reset" class="btn m-0 p-0 search-icon btn_reset_form"
                                                    style="left: 192px;"><i class="ri-close-fill"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card header -->
                            <div class="card-body pt-0">
                                <ul class="list-group list-group-flush border-dashed">
                                    @foreach ($universities as $university)
                                        <div class="modal fade" id="showModal{{ $university->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div
                                                class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-light p-3">
                                                        <h5 class="modal-title" id="exampleModalLabel">THÔNG TIN TRƯỜNG
                                                            HỌC</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close" id="close-modal"></button>
                                                    </div>
                                                    <div class="modal-body" id="modal-body-container">
                                                        <section class="job-details-area">
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-lg-8">
                                                                        <div class="hot-jobs-list">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-lg-3">
                                                                                    <div class="hot-jobs-img">
                                                                                        <img src="{{ str_contains($university->logo, 'http') ? $university->logo : Storage::url($university->logo) }}"
                                                                                            alt="Image">
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-lg-9">
                                                                                    <div class="hot-jobs-content">
                                                                                        <h3>{{ $university->name }}</h3>
                                                                                        <ul>
                                                                                            <li><span>Chuyên ngành </span>
                                                                                                @foreach ($university->majors as $major)
                                                                                                    <span
                                                                                                        class="badge bg-info text-white">{{ $major->name }}
                                                                                                    </span>
                                                                                                @endforeach
                                                                                            </li>

                                                                                        </ul>
                                                                                    </div>
                                                                                </div>


                                                                            </div>
                                                                        </div>
                                                                        <div class="job-details-content">
                                                                            <h3>Giới thiệu</h3>
                                                                            <p>{{ $university->introduce }}</p>
                                                                            <h4>Mô tả</h4>
                                                                            <p>
                                                                                {!! $university->description !!}
                                                                            </p>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-4">
                                                                        <div class="job-details-sidebar">
                                                                            <div class="job-widget">
                                                                                <h3>{{ config('apps.clients.enterprises.show.contact') }}
                                                                                </h3>

                                                                                <div class="social-icon">
                                                                                    <div class="single-footer-widget">
                                                                                        <ul class="address">
                                                                                            <li>
                                                                                                <i
                                                                                                    class="bx bx-phone-call"></i>
                                                                                                <span>Phone</span>
                                                                                                <a>
                                                                                                    {{ $university->phone }}</a>
                                                                                            </li>
                                                                                            <li>
                                                                                                <i
                                                                                                    class="bx bx-envelope"></i>
                                                                                                <span>Email</span>
                                                                                                <a>{{ $university->email }}</a>
                                                                                            </li>
                                                                                            <li class="location">
                                                                                                <i
                                                                                                    class="bx bx-location-plus"></i>
                                                                                                <span>Address</span>
                                                                                                {{ $university->address }}
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                    <div class="text-center">
                                                                                        <a href="{{ $university->url }}"
                                                                                            target="_blank"><i
                                                                                                class="fa-solid fa-link"></i>
                                                                                            Đến
                                                                                            trang
                                                                                            công ty</a>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </section>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <li class="list-group-item ps-0">
                                            <div class="row align-items-center g-3">
                                                <div class="col-auto">

                                                    <img class="image avatar-xs rounded-circle" alt=""
                                                        src="{{ Str::contains($university->logo, 'http') ? $university->logo : Storage::url($university->logo) }}">

                                                </div>
                                                <div class="col">

                                                    <h5 class="text-muted mt-0 mb-1 fs-13">Ngày gửi:
                                                        {{ $university->pivot->created_at->format('d/m/Y') }}
                                                        ({{ now()->diffInDays($university->pivot->created_at)>0 ? now()->diffInDays($university->pivot->created_at).' ngày trước':'hôm nay' }})
                                                    </h5>
                                                    {{ $university->name }}
                                                </div>
                                                <div class="col-sm-auto">
                                                    <div class="d-flex gap-2 ">
                                                        <div class="show">
                                                            <button type="button" class="btn btn-soft-primary btn_modal"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                data-bs-custom-class="custom-tooltip"
                                                                data-bs-title="Xem chi tiết."
                                                                data-university="{{ $university->id }}">
                                                                <i class="ri-eye-line"></i>
                                                            </button>
                                                        </div>
                                                        <div class="status_university_{{ $university->id }}">

                                                            @if ($university->pivot->status == PENDING_APPROVE)
                                                                <button class="btn btn-success change_status"
                                                                    data-university="{{ $university->id }}"
                                                                    data-status="{{ APPROVED }}">Đồng ý</button>
                                                                <button class="btn btn-danger change_status"
                                                                    data-university="{{ $university->id }}"
                                                                    data-status="{{ UN_APPROVE }}">Từ chối</button>
                                                            @elseif ($university->pivot->status == APPROVED)
                                                                <p
                                                                    class="border mb-0 p-2 rounded text-success bg-success-subtle">
                                                                    Đã đồng ý
                                                                </p>
                                                            @elseif ($university->pivot->status == UN_APPROVE)
                                                                <p
                                                                    class="border mb-0 p-2 rounded text-danger bg-danger-subtle">
                                                                    Đã từ chối
                                                                </p>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end row -->
                                        </li>
                                    @endforeach

                                </ul><!-- end -->
                                @if ($universities->isEmpty())
                                    <div class="noresult">
                                        <div class="text-center">
                                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                                colors="primary:#121331,secondary:#08a88a"
                                                style="width:75px;height:75px"></lord-icon>
                                            <h5 class="mt-2">Hiện tại chưa có trường học nào tham gia</h5>
                                            <p class="text-muted mb-3">Vui lòng chờ đợi!</p>
                                        </div>
                                    </div>
                                @endif
                                <div class="mt-3 ">
                                    {{ $universities->links() }}
                                </div>
                            </div><!-- end card body -->
                        </div>
                    </div>
                </div>
                <a href="{{ route('enterprise.jobs.index') }}">
                    <button type="button" class="btn btn-outline-dark btn-label mb-3">
                        <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                        {{ config('admin.enterprise.jobs.return') }}
                    </button>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script defer src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>

    <script>
        $(document).ready(function() {
            $(document).on('click', '.btn_modal', function() {
                const universityId = $(this).data('university');
                $(`#showModal${universityId}`).modal('show');
            });

            $(document).on('click', '.btn_reset_form', function(e) {
                e.preventDefault()

                const input = $('#form_search input').val()

                if (input == '') return

                const url = new URL(window.location.href);

                url.searchParams.delete('name');
                url.searchParams.delete('page');

                window.location.href = url.href;
            });

            $(document).on('click', '.change_status', function() {
                const jobId = {{ $job->id }};
                const universityId = $(this).data('university');
                const status = $(this).data('status');
                const url_raw =
                    `{{ route('enterprise.jobs.university', ['job' => $job->id, 'university' => ':university']) }}`

                const url = url_raw.replace(':university', universityId);

                $.ajax({
                    url: url,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': `{{ csrf_token() }}`,
                    },
                    data: {
                        status,
                        _method: 'PUT',
                    },
                    success: function(res) {
                        if (res.message) {
                            flasher.error(res.message);
                        }

                        if (res.data) {
                            flasher.success(res.data.message);

                            let html = ''

                            if (status == 1) {
                                html = `<p class="border mb-0 p-2 rounded text-success bg-success-subtle">
                                            Đã đồng ý
                                        </p>`

                                $('.ung_tuyen').text(parseInt($('.ung_tuyen').text() || 0, 10) +
                                    1)
                            } else {
                                html = `
                                    <p class="border mb-0 p-2 rounded text-danger bg-danger-subtle">
                                        Đã từ chối
                                    </p>`
                            }


                            $(`.status_university_${universityId}`).html(html);
                        }
                    },
                    error: function(xhr) {
                        flasher.error(xhr.responseJSON.message);
                    },
                });
            });

        });
    </script>
@endsection
