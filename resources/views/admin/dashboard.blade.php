@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('css')
    <!-- jsvectormap css -->
    <link href="{{ asset('theme/admin/html/master/assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet"
        type="text/css">

    <!-- gridjs css -->
    <link rel="stylesheet" href="{{ asset('theme/admin/html/master/assets/libs/gridjs/theme/mermaid.min.css') }}">

    <style>
        .chart_1 p {
            font-size: 11px
        }

        .chart_1 .card-body {
            height: 120px
        }
    </style>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Thống kê</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                <li class="breadcrumb-item active">Thống kê</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row ">
                <div class="col-xl-6 chart_1">
                    <div class="d-flex flex-column h-100">
                        <div class="row">
                            <div class="col-xl-6 col-md-6">
                                <div class="card card-animate overflow-hidden">
                                    <div class="position-absolute start-0" style="z-index: 0;">
                                        <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 200 120"
                                            width="200" height="120">
                                            <style>
                                                .s0 {
                                                    opacity: .05;
                                                    fill: var(--vz-success)
                                                }
                                            </style>
                                            <path id="Shape 8" class="s0"
                                                d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="card-body" style="z-index:1 ;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Tổng công
                                                    việc</p>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
                                                        data-target="{{ $dashboardJob['countAll'] }}"></span></h4>
                                            </div>
                                            {{-- <div class="flex-shrink-0">
                                                <div id="total_jobs" data-colors='["--vz-success"]' class="apex-charts"
                                                    dir="ltr"></div>
                                            </div> --}}
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!--end col-->
                            <div class="col-xl-6 col-md-6">
                                <!-- card -->
                                <div class="card card-animate overflow-hidden">
                                    <div class="position-absolute start-0" style="z-index: 0;">
                                        <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 200 120"
                                            width="200" height="120">
                                            <style>
                                                .s0 {
                                                    opacity: .05;
                                                    fill: var(--vz-success)
                                                }
                                            </style>
                                            <path id="Shape 8" class="s0"
                                                d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="card-body" style="z-index:1 ;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Công việc
                                                    được duyệt</p>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
                                                        data-target="{{ $dashboardJob['countAccept'] }}">0</span></h4>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div id="apply_jobs" data-colors='["--vz-success"]' class="apex-charts"
                                                    dir="ltr"></div>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                            <div class="col-xl-6 col-md-6">
                                <!-- card -->
                                <div class="card card-animate overflow-hidden">
                                    <div class="position-absolute start-0" style="z-index: 0;">
                                        <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 200 120"
                                            width="200" height="120">
                                            <style>
                                                .s0 {
                                                    opacity: .05;
                                                    fill: var(--vz-success)
                                                }
                                            </style>
                                            <path id="Shape 8" class="s0"
                                                d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="card-body" style="z-index:1 ;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Tổng hội
                                                    thảo
                                                </p>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
                                                        data-target="{{ $dashboardWorkshop['countAll'] }}">0</span></h4>
                                            </div>
                                            {{-- <div class="flex-shrink-0">
                                                <div id="new_jobs_chart" data-colors='["--vz-success"]' class="apex-charts"
                                                    dir="ltr"></div>
                                            </div> --}}
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                            <div class="col-xl-6 col-md-6">
                                <!-- card -->
                                <div class="card card-animate overflow-hidden">
                                    <div class="position-absolute start-0" style="z-index: 0;">
                                        <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 200 120"
                                            width="200" height="120">
                                            <style>
                                                .s0 {
                                                    opacity: .05;
                                                    fill: var(--vz-success)
                                                }
                                            </style>
                                            <path id="Shape 8" class="s0"
                                                d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="card-body" style="z-index:1 ;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                                    Hội thảo được duyệt</p>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value"
                                                        data-target="{{ $dashboardWorkshop['countAccept'] }}">0</span></h4>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div id="interview_chart" data-colors='["--vz-danger"]'
                                                    class="apex-charts" dir="ltr"></div>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                            <div class="col-xl-6 col-md-6">
                                <div class="card card-animate overflow-hidden">
                                    <div class="position-absolute start-0" style="z-index: 0;">
                                        <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 200 120"
                                            width="200" height="120">
                                            <style>
                                                .s0 {
                                                    opacity: .05;
                                                    fill: var(--vz-success)
                                                }
                                            </style>
                                            <path id="Shape 8" class="s0"
                                                d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="card-body" style="z-index:1 ;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Tổng
                                                    trường học
                                                </p>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-0"><span
                                                        class="counter-value"
                                                        data-target="{{ $dashboardUniversity['countAll'] }}">0</span></h4>
                                            </div>
                                            {{-- <div class="flex-shrink-0">
                                                <div id="hired_chart" data-colors='["--vz-success"]' class="apex-charts"
                                                    dir="ltr"></div>
                                            </div> --}}
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!--end col-->
                            <div class="col-xl-6 col-md-6">
                                <!-- card -->
                                <div class="card card-animate overflow-hidden">
                                    <div class="position-absolute start-0" style="z-index: 0;">
                                        <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 200 120"
                                            width="200" height="120">
                                            <style>
                                                .s0 {
                                                    opacity: .05;
                                                    fill: var(--vz-success)
                                                }
                                            </style>
                                            <path id="Shape 8" class="s0"
                                                d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="card-body" style="z-index:1 ;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Tổng
                                                    doanh nghiệp
                                                </p>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-0"><span
                                                        class="counter-value"
                                                        data-target="{{ $dashboardEnterprise['countAll'] }}">0</span></h4>
                                            </div>
                                            {{-- <div class="flex-shrink-0">
                                                <div id="rejected_chart" data-colors='["--vz-danger"]'
                                                    class="apex-charts" dir="ltr"></div>
                                            </div> --}}
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                        </div><!--end row-->
                    </div>
                </div><!--end col-->
                <div class="col-xl-6">
                    <div class="card card-height-100">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Top doanh nghiệp được ứng tuyển nhiều nhất</h4>

                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table table-centered table-hover align-middle table-nowrap mb-0">
                                    <tbody>
                                        @foreach ($dashboardEnterprise['getTopApplies'] as $getTopApplies)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-xs me-2 flex-shrink-0">
                                                            <div class="avatar-title bg-secondary-subtle rounded">
                                                                <img src="{{ str_contains($getTopApplies->logo, 'http') ? $getTopApplies->logo : Storage::url($getTopApplies->logo) }}"
                                                                    alt="" height="16">
                                                            </div>
                                                        </div>
                                                        <h6 class="mb-0">
                                                            {{ Str::limit($getTopApplies->name, 35, '...') }}</h6>
                                                    </div>
                                                </td>
                                                <td>
                                                    <i class="ri-newspaper-line text-primary me-1 align-bottom"></i>
                                                    {{ $getTopApplies->jobs_sum_applicants }}
                                                </td>
                                                @php
                                                    $userId = $getTopApplies->users->first()?->id;
                                                @endphp
                                                <td>
                                                    @if ($userId)
                                                        <a href="{{ route('system-admin.enterprise.show', $userId) }}"
                                                            class="btn btn-link btn-sm material-shadow-none">
                                                            Xem doanh nghiệp<i
                                                                class="ri-arrow-right-line align-bottom"></i>
                                                        </a>
                                                    @else
                                                        <a href=""
                                                            class="btn btn-link btn-sm material-shadow-none">
                                                            Xem doanh nghiệp<i
                                                                class="ri-arrow-right-line align-bottom"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 pt-2">

                                {{ $dashboardEnterprise['getTopApplies']->links() }}
                            </div>

                        </div>
                    </div> <!-- .card-->
                </div><!--end col-->
            </div><!--end row-->

            <div class="row">
                <div class="col">
                    <div class="card card-height-100">
                        <div class="card-header border-0 align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Ứng tuyển</h4>
                            <div>
                                <select class="form-select rounded-pill change_year" aria-label="Default select example">
                                    <option selected value="">Chọn năm</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}" @selected(now()->year == $year)>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!-- end card header -->

                        <div class="card-header p-0 border-0 bg-light-subtle">
                            <div class="row g-0 text-center">
                                <div class="col-6 col-sm-3">
                                    <div class="p-3 border border-dashed border-start-0">
                                        <h5 class="mb-1"><span class="counter-value ung_tuyen_moi"
                                                data-target="{{ $dashboardJob['countApplyPending'] + $dashboardWorkshop['countApplyPending'] }}">0</span>
                                        </h5>
                                        <p class="text-muted mb-0">Ứng tuyển mới</p>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-6 col-sm-3">
                                    <div class="p-3 border border-dashed border-start-0">
                                        <h5 class="mb-1"><span class="counter-value ung_tuyen_thanh_cong"
                                                data-target="{{ $dashboardJob['countApplyAccept'] + $dashboardWorkshop['countApplyAccept'] }}">0</span>
                                        </h5>
                                        <p class="text-muted mb-0">Ứng tuyển thành công</p>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-6 col-sm-3">
                                    <div class="p-3 border border-dashed border-start-0">
                                        <h5 class="mb-1"><span class="counter-value ung_tuyen_bi_tu_choi"
                                                data-target="{{ $dashboardJob['countApplyNotAccept'] + $dashboardWorkshop['countApplyNotAccept'] }}">0</span>
                                        </h5>
                                        <p class="text-muted mb-0">Ứng tuyển bị từ chối</p>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-6 col-sm-3">
                                    <div class="p-3 border border-dashed border-start-0 border-end-0">
                                        <h5 class="mb-1 text-success"><span class="counter-value tong_ung_tuyen"
                                                data-target="{{ $dashboardJob['countApplicants'] + $dashboardWorkshop['countApplicants'] }}">0</span>
                                        </h5>
                                        <p class="text-muted mb-0">Tổng ứng tuyển</p>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                        </div><!-- end card header -->

                        <div class="card-body p-0 pb-2">
                            <div class="w-100">
                                <div id="line_chart_dashed" data-colors='["--vz-success", "--vz-info", "--vz-primary"]'
                                    data-colors-modern='["--vz-primary", "--vz-secondary", "--vz-success"]'
                                    data-colors-interactive='["--vz-secondary", "--vz-info", "--vz-primary"]'
                                    data-colors-creative='["--vz-info", "--vz-secondary", "--vz-success"]'
                                    data-colors-corporate='["--vz-secondary", "--vz-success", "--vz-primary"]'
                                    class="apex-charts" dir="ltr"></div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->
                {{-- <div class="col-xxl-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h6 class="card-title mb-0 flex-grow-1">Popular Candidates</h6>
                                <div class="flex-shrink-0">
                                    <a href="apps-job-candidate-lists.html" class="link-primary">View All <i
                                            class="ri-arrow-right-line"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="card-body border-end">
                                    <div class="search-box">
                                        <input type="text" class="form-control bg-light border-light"
                                            autocomplete="off" id="searchList" placeholder="Search candidate...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                    <div data-simplebar style="max-height: 190px" class="px-3 mx-n3">
                                        <ul class="list-unstyled mb-0 pt-2" id="candidate-list">
                                            <li>
                                                <a href="javascript:void(0);" class="d-flex align-items-center py-2">
                                                    <div class="flex-shrink-0 me-2">
                                                        <div class="avatar-xs">
                                                            <img src="assets/images/users/avatar-10.jpg" alt=""
                                                                class="img-fluid rounded-circle candidate-img">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="fs-13 mb-1 text-truncate"><span
                                                                class="candidate-name">Tonya Noble</span> <span
                                                                class="text-muted fw-normal">@tonya</span></h5>
                                                        <div class="d-none candidate-position">Web Developer</div>
                                                    </div>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="javascript:void(0);" class="d-flex align-items-center py-2">
                                                    <div class="flex-shrink-0 me-2">
                                                        <div class="avatar-xs">
                                                            <img src="assets/images/users/avatar-1.jpg" alt=""
                                                                class="img-fluid rounded-circle candidate-img">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="fs-13 mb-1 text-truncate"><span
                                                                class="candidate-name">Nicholas Ball</span> <span
                                                                class="text-muted fw-normal">@nicholas</span></h5>
                                                        <div class="d-none candidate-position">Assistant / Store Keeper
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="d-flex align-items-center py-2">
                                                    <div class="flex-shrink-0 me-2">
                                                        <div class="avatar-xs">
                                                            <img src="assets/images/users/avatar-9.jpg" alt=""
                                                                class="img-fluid rounded-circle candidate-img">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="fs-13 mb-1 text-truncate"><span
                                                                class="candidate-name">Zynthia Marrow</span> <span
                                                                class="text-muted fw-normal">@zynthia</span></h5>
                                                        <div class="d-none candidate-position">Full Stack Engineer</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="d-flex align-items-center py-2">
                                                    <div class="flex-shrink-0 me-2">
                                                        <div class="avatar-xs">
                                                            <img src="assets/images/users/avatar-2.jpg" alt=""
                                                                class="img-fluid rounded-circle candidate-img">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="fs-13 mb-1 text-truncate"><span
                                                                class="candidate-name">Cheryl Moore</span> <span
                                                                class="text-muted fw-normal">@Cheryl</span></h5>
                                                        <div class="d-none candidate-position">Product Designer</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="d-flex align-items-center py-2">
                                                    <div class="flex-shrink-0 me-2">
                                                        <div class="avatar-xs">
                                                            <img src="assets/images/users/avatar-5.jpg" alt=""
                                                                class="img-fluid rounded-circle candidate-img">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="fs-13 mb-1 text-truncate"><span
                                                                class="candidate-name">Jennifer Bailey</span> <span
                                                                class="text-muted fw-normal">@Jennifer</span></h5>
                                                        <div class="d-none candidate-position">Marketing Director</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="d-flex align-items-center py-2">
                                                    <div class="flex-shrink-0 me-2">
                                                        <div class="avatar-xs">
                                                            <img src="assets/images/users/avatar-8.jpg" alt=""
                                                                class="img-fluid rounded-circle candidate-img">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="fs-13 mb-1 text-truncate"><span
                                                                class="candidate-name">Hadley Leonard</span> <span
                                                                class="text-muted fw-normal">@hadley</span></h5>
                                                        <div class="d-none candidate-position">Executive, HR Operations
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card-body text-center">
                                    <div class="avatar-md mb-3 mx-auto">
                                        <img src="assets/images/users/avatar-10.jpg" alt="" id="candidate-img"
                                            class="img-thumbnail rounded-circle shadow-none">
                                    </div>

                                    <h5 id="candidate-name" class="mb-0">Tonya Noble</h5>
                                    <p id="candidate-position" class="text-muted">Web Developer</p>

                                    <div class="d-flex gap-2 justify-content-center mb-3">
                                        <button type="button" class="btn avatar-xs p-0 material-shadow-none"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Google">
                                            <span class="avatar-title rounded-circle bg-light text-body">
                                                <i class="ri-google-line"></i>
                                            </span>
                                        </button>

                                        <button type="button" class="btn avatar-xs p-0 material-shadow-none"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Linkedin">
                                            <span class="avatar-title rounded-circle bg-light text-body">
                                                <i class="ri-linkedin-line"></i>
                                            </span>
                                        </button>
                                        <button type="button" class="btn avatar-xs p-0 material-shadow-none"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Dribbble">
                                            <span class="avatar-title rounded-circle bg-light text-body">
                                                <i class="ri-dribbble-fill"></i>
                                            </span>
                                        </button>
                                    </div>

                                    <div>
                                        <button type="button" class="btn btn-success custom-toggle w-100"
                                            data-bs-toggle="button" aria-pressed="false">
                                            <span class="icon-on"><i class="ri-add-line align-bottom me-1"></i>
                                                Follow</span>
                                            <span class="icon-off"><i class="ri-user-unfollow-line align-bottom me-1"></i>
                                                Unfollow</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
                    <div class="card overflow-hidden shadow-none">
                        <div class="card-body bg-danger-subtle">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-danger bg-opacity-10 text-danger rounded-circle fs-17">
                                            <i class="ri-gift-line"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-16">Invite your friends to Velzon</h6>
                                    <p class="text-muted mb-0">Nor again is there anyone who loves or pursues or desires to
                                        obtain pain of itself, because it is pain, but because occasionally.</p>
                                </div>
                            </div>
                            <div class="mt-3 text-end">
                                <a href="#!" class="btn btn-danger">Invite Friends</a>
                            </div>
                        </div>
                    </div>
                </div><!-- end col --> --}}
            </div><!--end row-->
        </div>
    </div>
@endsection

@section('js')
    <!-- apexcharts -->
    <script src="{{ asset('theme/admin/html/master/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Vector map-->
    <script src="{{ asset('theme/admin/html/master/assets/libs/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('theme/admin/html/master/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <!--Swiper slider js-->
    <script src="{{ asset('theme/admin/html/master/assets/libs/swiper/swiper-bundle.min.js') }}"></script>
    <script>
        const acceptJobsPercentage = {{ $dashboardJob['acceptPercentage'] }}
        const acceptWorkshopsPercentage = {{ $dashboardWorkshop['acceptPercentage'] }}

        let countApplyAcceptByMonthJob = @json($dashboardJob['countApplyAcceptByMonth']);
        let countApplyNotAcceptByMonthJob = @json($dashboardJob['countApplyNotAcceptByMonth']);
        let countApplyPendingByMonthJob = @json($dashboardJob['countApplyPendingByMonth']);

        let countApplyAcceptByMonthWorkshop = @json($dashboardWorkshop['countApplyAcceptByMonth']);
        let countApplyNotAcceptByMonthWorkshop = @json($dashboardWorkshop['countApplyNotAcceptByMonth']);
        let countApplyPendingByMonthWorkshop = @json($dashboardWorkshop['countApplyPendingByMonth']);

        const mergeArrays = (arr1, arr2) => {
            return arr1.map((value, index) => value + (arr2[index] || 0));
        }

        let countApplyAcceptByMonth = []
        let countApplyNotAcceptByMonth = []
        let countApplyPendingByMonth = []

        const merge = () => {
            countApplyAcceptByMonth = mergeArrays(countApplyAcceptByMonthJob, countApplyAcceptByMonthWorkshop)
            countApplyNotAcceptByMonth = mergeArrays(countApplyNotAcceptByMonthJob,
                countApplyNotAcceptByMonthWorkshop)
            countApplyPendingByMonth = mergeArrays(countApplyPendingByMonthJob, countApplyPendingByMonthWorkshop)
        }

        merge()
    </script>
    <!-- Dashboard init -->
    <script src="{{ asset('assets/admin/dashboard.js') }}"></script>

    <script>
        $(document).ready(function() {
            $(document).on('change', '.change_year', function() {
                const year = $(this).val()

                if (year == '') return

                $.ajax({
                    type: "get",
                    url: `{{ route('system-admin.dashboard') }}?year=${year}`,
                    dataType: "json",
                    success: function(res) {
                        if (res.data) {
                            $('.ung_tuyen_moi').text(Number(res.data.dashboardJob
                                .countApplyPending) + Number(res.data.dashboardWorkshop
                                .countApplyPending));
                            $('.ung_tuyen_thanh_cong').text(Number(res.data.dashboardJob
                                .countApplyAccept) + Number(res.data.dashboardWorkshop
                                .countApplyAccept));
                            $('.ung_tuyen_bi_tu_choi').text(Number(res.data.dashboardJob
                                .countApplyNotAccept) + Number(res.data
                                .dashboardWorkshop
                                .countApplyNotAccept));
                            $('.tong_ung_tuyen').text(Number(res.data.dashboardJob
                                .countApplicants) + Number(res.data.dashboardWorkshop
                                .countApplicants));

                            countApplyAcceptByMonthJob = res.data.dashboardJob
                                .countApplyAcceptByMonth
                            countApplyNotAcceptByMonthJob = res.data.dashboardJob
                                .countApplyNotAcceptByMonth
                            countApplyPendingByMonthJob = res.data.dashboardJob
                                .countApplyPendingByMonth

                            countApplyAcceptByMonthWorkshop = res.data.dashboardWorkshop
                                .countApplyAcceptByMonth
                            countApplyNotAcceptByMonthWorkshop = res.data.dashboardWorkshop
                                .countApplyNotAcceptByMonth
                            countApplyPendingByMonthWorkshop = res.data.dashboardWorkshop
                                .countApplyPendingByMonth

                            merge()
                            loadCharts_2()
                        }
                    }
                });

            });
        });
    </script>
@endsection
