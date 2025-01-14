@extends('admin.layouts.master')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@endsection

@section('content')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">{{ $config['index']['title'] }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Quản lí workshop</a></li>
                            <li class="breadcrumb-item active">Chi tiết workshop</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label font-weight-bold">Mã</label>
                                    <p class="border p-2 rounded">{{ $workshops->slug }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label font-weight-bold">Tiêu đề</label>
                                    <p class="border p-2 rounded">{{ $workshops->title }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label font-weight-bold">Điều kiện</label>
                                    <p class="border p-2 rounded">{{ $workshops->requirement }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label font-weight-bold">Ngày bắt đầu</label>
                                    <p class="border p-2 rounded">{{ \Carbon\Carbon::parse($workshops->start_date)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label font-weight-bold">Ngày kết thúc</label>
                                    <p class="border p-2 rounded">{{ \Carbon\Carbon::parse($workshops->end_date)->format('d/m/Y') }}</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Chuyên ngành</label>
                                    <select class="form-control" id="choices-multiple-remove-button" name="majors[]" multiple disabled>
                                        @foreach($major as $item)
                                        <option value="{{ $item->id }}" selected>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('majors')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            @php
                            $statusLabels = [
                            UN_APPROVE => ['class' => 'bg-danger', 'text' => 'Từ chối', 'icon' => 'ri-close-circle-line'],
                            PENDING_APPROVE => ['class' => 'bg-warning', 'text' => 'Chờ duyệt', 'icon' => 'ri-time-line'],
                            APPROVED => ['class' => 'bg-success', 'text' => 'Đã duyệt', 'icon' => 'ri-check-line'],
                            ];
                            $status = $statusLabels[$workshops->status] ?? ['class' => 'bg-secondary', 'text' => 'Chưa xác định', 'icon' => 'ri-question-line'];
                            @endphp

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label font-weight-bold">Trạng thái phê duyệt</label>
                                    <div class="d-flex align-items-center">
                                        <i class="ri {{ $status['icon'] }} me-2 text-white"></i>
                                        <span class="badge {{ $status['class'] }} px-3 py-2 rounded-pill">{{ $status['text'] }}</span>
                                    </div>
                                </div>
                            </div>


                            @php
                            $statusLabels = [
                            IS_ACTIVE => ['class' => 'bg-success', 'text' => 'Hoạt động', 'icon' => 'ri-check-line'],
                            UN_ACTIVE => ['class' => 'bg-danger', 'text' => 'Không hoạt động', 'icon' => 'ri-time-line'],
                            ];
                            $status = $statusLabels[$workshops->is_active] ?? ['class' => 'bg-secondary', 'text' => 'Chưa xác định', 'icon' => 'ri-question-line'];
                            @endphp

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label font-weight-bold">Trạng thái hiển thị</label>
                                    <div class="d-flex align-items-center">
                                        <span class="badge {{ $status['class'] }} px-3 py-2 rounded-pill">{{ $status['text'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Mô tả -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label font-weight-bold">Mô tả</label>
                                        <div class="border p-3 rounded">
                                            <p>{!! $workshops->description !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="card card-height-100">
                                        <div class="card-header align-items-center d-flex bg-primary">
                                            <h4 class="card-title mb-0 flex-grow-1 text-white">Danh sách doanh nghiệp tham gia</h4>
                                            <div class="flex-shrink-0">
                                                <div class="dropdown card-header-dropdown">
                                                    <div class="search-box ms-2">
                                                        <input type="text" class="form-control search" placeholder="Tìm tên trường">
                                                        <i class="ri-search-line search-icon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end card header -->
                                        <div class="card-body pt-0">
                                            <ul class="list-group list-group-flush border-dashed">
                                                @foreach ($enterprises as $enterprise)
                                                <li class="list-group-item ps-0">
                                                    <div class="row align-items-center g-3">
                                                        <div class="col-auto">
                                                            <a href="">
                                                                <img class="image avatar-xs rounded-circle" alt=""
                                                                    src="{{ $enterprise->logo }}">
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <h5 class="text-muted mt-0 mb-1 fs-13"><a href="">Ngày tham gia: {{ $enterprise->created_at->format('d/m/Y') }}</a></h5>
                                                            <a href="#"
                                                                class="text-reset fs-14 mb-0">{{ $enterprise->name }}</a>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <div class="d-flex gap-2 status_enterprise_{{ $enterprise->id }}">
                                                                <div class="show">
                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-soft-primary"
                                                                        data-bs-toggle="tooltip" data-bs-placement="left"
                                                                        data-bs-custom-class="custom-tooltip"
                                                                        data-bs-title="Xem chi tiết."
                                                                        id="show-btn"
                                                                        data-id="{{ $enterprise->id }}">
                                                                        <i class="ri-eye-line"></i>
                                                                    </button>
                                                                </div>

                                                                @if ($enterprise->pivot->status == PENDING_APPROVE)
                                                                <button class="btn btn-success change_status"
                                                                    data-enterprise="{{ $enterprise->id }}"
                                                                    data-status="{{ APPROVED }}">Đồng ý</button>
                                                                <button class="btn btn-danger change_status"
                                                                    data-enterprise="{{ $enterprise->id }}"
                                                                    data-status="{{ UN_APPROVE }}">Từ chối</button>
                                                                @elseif ($enterprise->pivot->status == APPROVED)
                                                                <p class="border p-2 rounded text-success bg-success-subtle">
                                                                    Đã đồng ý
                                                                </p>
                                                                @elseif ($enterprise->pivot->status == UN_APPROVE)
                                                                <p class="border p-2 rounded text-danger bg-danger-subtle">
                                                                    Đã từ chối
                                                                </p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end row -->
                                                </li>
                                                @endforeach

                                            </ul><!-- end -->
                                            @if($enterprises->isEmpty())
                                                <div class="noresult">
                                                    <div class="text-center p-4">
                                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                                            colors="primary:#121331,secondary:#08a88a"
                                                            style="width:100px;height:100px"></lord-icon>
                                                        <h5 class="mt-3 text-muted">Hiện tại chưa có doanh nghiệp nào tham gia</h5>
                                                        <p class="text-muted mb-3">Vui lòng chờ đợi!</p>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="mt-3 ">
                                                {{ $enterprises->links() }}
                                            </div>
                                        </div><!-- end card body -->
                                    </div>
                                </div>
                            </div>
                            <!-- Button trở về -->
                            <div class="d-flex justify-content-start mt-4">
                                <a href="{{ route('university.workshop.index') }}">
                                    <button type="button" class="btn btn-light btn-label previestab">
                                        <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Trở về
                                    </button>
                                </a>
                            </div>
                        </div><!-- end card-body -->
                        <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header bg-light p-3">
                                        <h5 class="modal-title" id="exampleModalLabel">THÔNG TIN DOANH NGHIỆP</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                    </div>
                                    <div class="modal-body" id="modal-body-container">

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- end card -->
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end container-fluid -->
    </div><!-- end page-content -->

    @endsection

    @section('js')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const selectElement = document.getElementById("choices-multiple-remove-button");
            const choices = new Choices(selectElement, {
                removeItemButton: true,
                searchEnabled: true,
                placeholder: true,
                shouldSort: false
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.change_status', function() {
                const enterpriseId = $(this).data('enterprise');
                const status = $(this).data('status');
                const id = $(this).data('id');
                const url_raw =
                    `{{ route('university.workshop.enterprise', ['workshop' => $workshops->id, 'enterprise' => ':enterprise']) }}`

                const url = url_raw.replace(':enterprise', enterpriseId);

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
                        }

                        let html = ''

                        if (status == 1) {
                            html = `
                        <div class="show">
                            <button
                                type="button"
                                class="btn btn-soft-primary"
                                data-bs-toggle="tooltip" data-bs-placement="left"
                                data-bs-custom-class="custom-tooltip"
                                data-bs-title="Xem chi tiết."
                                id="show-btn"
                                data-id="${enterpriseId}">
                                <i class="ri-eye-line"></i>
                            </button>
                        </div>
                        <p class="border p-2 rounded text-success bg-success-subtle">
                            Đã đồng ý
                        </p>`
                        } else {
                            html = `
                        <p class="border p-2 rounded text-danger bg-danger-subtle">
                            Đã từ chối
                        </p>`
                        }

                        $(`.status_enterprise_${enterpriseId}`).html(html);
                    },
                    error: function(xhr) {
                        flasher.error(xhr.responseJSON.message);
                    },
                });
            });

        });
    </script>
    <script>
        const myModal = new bootstrap.Modal(document.getElementById('showModal'))

        $(document).on('click', '#show-btn', function() {
            var id = $(this).data('id');
            console.log(id);

            $.ajax({
                url: '/university/showEnterprise/' + id,
                method: 'GET',
                success: function(response) {
                    console.log('Success', response);

                    const htmlContent = `
        <div class="row">
            <!-- Phần thông tin công ty -->
            <div class="col-lg-8">
                <div class="company-info">
                    <div class="company-header d-flex align-items-center" style="
                        padding: 30px;
                        background-color: #fff;
                        box-shadow: 0px 5px 20px 3px rgba(230, 233, 249, .9);
                        transition: all ease .5s;
                        border-radius: 30px 0 30px 0;
                        margin-bottom: 30px;
                        position: relative;
                        overflow: hidden;">
                        <img src="${response.enterprise.logo}" width="100px" alt="Image" class="company-logo">
                        <div class="company-details ms-3">
                            <h3 style="font-size: 24px; font-weight: 600;">${response.enterprise.name}</h3>
                            <span class="sub-title" style="font-size: 16px; color: gray;"></span>
                            <ul style="list-style-type: none; padding-left: 0;">
                                <li><strong>Số lượng:</strong> ${response.enterprise.size}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="job-description mt-3">
                        <h4 style="font-size: 16px; font-weight: 600;">Giới thiệu công ty:</h4>
                        <p style="font-size: 14px; color: #555;">${response.enterprise.introduce}</p>
                        <h4 style="font-size: 16px; font-weight: 600;">Lĩnh vực:</h4>
                        <p style="font-size: 14px; color: #555;">${response.enterprise.industry}</p>
                        <h4 style="font-size: 16px; font-weight: 600;">Mô tả :</h4>
                        <p style="font-size: 14px; color: #555;">${response.enterprise.description}</p>
                            
                    </div>
                </div>
            </div>

            <!-- Phần sidebar thông tin công ty -->
            <div class="col-lg-4">
                <div class="company-sidebar">
                    <div class="company-widget" style="
                        padding: 30px;
                        background-color: #fff;
                        box-shadow: 0px 5px 20px 3px rgba(230, 233, 249, .9);
                        transition: all ease .5s;
                        border-radius: 30px 0 30px 0;
                        margin-bottom: 30px;
                        position: relative;
                        overflow: hidden;">
                        <h4 style="font-size: 18px; font-weight: 600;">Thông tin chung</h4>
                        <div class="company-details">
                            <p style="font-size: 14px; color: #555;"><i class="fa-solid fa-users"></i> <strong>Chuyên ngành:</strong> ${response.enterprise.industry}</p>
                            <p style="font-size: 14px; color: #555;"><i class="fa-solid fa-industry"></i> <strong>Số nhân viên:</strong> ${response.enterprise.size}</p>
                            <p style="font-size: 14px; color: #555;"><i class="fa-solid fa-location"></i> <strong>Mã số thuế:</strong> ${response.enterprise.tax_code}</p>
                        </div>
                        <div class="text-center">
                            <a href="${response.enterprise.url}" class="btn btn-link" style="font-size: 14px; color: #007bff; text-decoration: none;">Đến trang công ty</a>
                        </div>
                    </div>
                    <div class="company-widget mt-4" style="
                        padding: 30px;
                        background-color: #fff;
                        box-shadow: 0px 5px 20px 3px rgba(230, 233, 249, .9);
                        transition: all ease .5s;
                        border-radius: 30px 0 30px 0;
                        margin-bottom: 30px;
                        position: relative;
                        overflow: hidden;">
                        <h4 style="font-size: 18px; font-weight: 600;">Thông tin liên hệ</h4>
                        <div class="company-details">
                            <p style="font-size: 14px; color: #555;"><i class="fa-solid fa-users"></i> <strong>Email:</strong> ${response.enterprise.email}</p>
                            <p style="font-size: 14px; color: #555;"><i class="fa-solid fa-industry"></i> <strong>Phone:</strong> ${response.enterprise.phone}</p>
                            <p style="font-size: 14px; color: #555;"><i class="fa-solid fa-location"></i> <strong>Địa chỉ:</strong> ${response.enterprise.address}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

                    // Đổ HTML vào modal-body
                    $('#modal-body-container').html(htmlContent);
                    myModal.show()

                },
                error: function(xhr) {
                    alert('Không tìm thấy chuyên ngành');
                }
            });
        });
    </script>
    @endsection