@extends('admin.layouts.master')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @if (auth()->user()->status !== APPROVED)
                <div class="alert alert-warning text-center">
                    <h4>Bạn cần cập nhật thông tin trường học để sử dụng các chức năng của hệ thống.</h4>
                    <p>Vui lòng truy cập trang <a class="btn btn-primary btn-sm" href="{{ route('enterprise.profile.edit') }}">Cập nhật thông tin</a> để
                        hoàn tất
                        thông tin.</p>
                </div>
            @else
                <div class="row">
                    <div class="col">
                        <div class="h-100">

                            <div class="row mb-3 pb-1">
                                <div class="col-12">
                                    <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                        <div class="flex-grow-1">
                                            <h4 class="fs-16 mb-1">Chào, {{ Auth::user()->username }}</h4>
                                            <p class="text-muted mb-0">Đây là những gì đang xảy ra trong hệ thống của bạn
                                            </p>
                                        </div>

                                        {{-- <div class="mt-3 mt-lg-0">
                                        <form action="javascript:void(0);">
                                            <div class="row g-3 mb-0 align-items-center">
                                                <div class="col-sm-auto">
                                                    <div class="input-group">
                                                        <input type="text"
                                                            class="form-control border-0 minimal-border dash-filter-picker shadow"
                                                            data-provider="flatpickr" data-range-date="true"
                                                            data-date-format="d M, Y"
                                                            data-deafult-date="01 Jan 2022 to 31 Jan 2022">
                                                        <div class="input-group-text bg-primary border-primary text-white">
                                                            <i class="ri-calendar-2-line"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end row-->
                                        </form>
                                    </div> --}}

                                    </div><!-- end card header -->
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->

                            <div class="row">

                                <div class="col-xl-6">
                                    <div class="d-flex flex-column h-100">
                                        <div class="row">

                                            @php
                                                $cards = [
                                                    [
                                                        'title' => 'Tổng Job',
                                                        'id' => 'total_jobs',
                                                        'color' => '--vz-success',
                                                        'value' => $countJob,
                                                        'counter_class' => 'counter-value',
                                                        'data_target' => $countJob,
                                                    ],
                                                    [
                                                        'title' => 'Ứng tuyển Job',
                                                        'id' => 'apply_jobs',
                                                        'color' => '--vz-success',
                                                        'value' => $applySuccess,
                                                        'counter_class' => 'counter-value',
                                                        'data_target' => $applySuccess,
                                                    ],
                                                    [
                                                        'title' => 'Hợp tác',
                                                        'id' => 'new_jobs_chart',
                                                        'color' => '--vz-success',
                                                        'value' => $cooperateSuccess,
                                                        'counter_class' => 'counter-value',
                                                        'data_target' => $cooperateSuccess,
                                                    ],
                                                    [
                                                        'title' => 'Workshop',
                                                        'id' => 'interview_chart',
                                                        'color' => '--vz-success',
                                                        'value' => $workshopSuccess,
                                                        'counter_class' => 'counter-value',
                                                        'data_target' => $workshopSuccess,
                                                    ],
                                                    [
                                                        'title' => 'Từ chối hợp tác',
                                                        'id' => 'hired_chart',
                                                        'color' => '--vz-danger',
                                                        'value' => $unCooperate,
                                                        'counter_class' => 'counter-value',
                                                        'data_target' => $unCooperate,
                                                    ],
                                                    [
                                                        'title' => 'Từ chối Job',
                                                        'id' => 'rejected_chart',
                                                        'color' => '--vz-danger',
                                                        'value' => $unJob,
                                                        'counter_class' => 'counter-value',
                                                        'data_target' => $unJob,
                                                    ],
                                                ];
                                            @endphp

                                            @foreach ($cards as $card)
                                                <div class="col-xl-6 col-md-6">
                                                    <div class="card card-animate overflow-hidden">
                                                        <div class="position-absolute start-0" style="z-index: 0;">
                                                            <svg version="1.2" xmlns="http://www.w3.org/2000/svg"
                                                                viewbox="0 0 200 120" width="200" height="120">
                                                                <style>
                                                                    .s0 {
                                                                        opacity: .05;
                                                                        fill: var({{ $card['color'] }})
                                                                    }
                                                                </style>
                                                                <path id="Shape 8" class="s0"
                                                                    d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                        <div class="card-body" style="z-index: 1;">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-grow-1 overflow-hidden">
                                                                    <p
                                                                        class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                                                        {{ $card['title'] }}</p>
                                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                                                        <span class="{{ $card['counter_class'] }}"
                                                                            data-target="{{ $card['data_target'] }}">0</span>
                                                                    </h4>
                                                                </div>
                                                                <div class="flex-shrink-0">
                                                                    <div id="{{ $card['id'] }}"
                                                                        data-colors='["{{ $card['color'] }}"]'
                                                                        class="apex-charts" dir="ltr"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div><!--end row-->
                                    </div>
                                </div><!--end col-->

                                <div class="col-xl-6">
                                    <div class="card card-height-100">

                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Các job nổi bật</h4>
                                            <div class="flex-shrink-0 me-2">
                                                <a href="{{ route('enterprise.exportJob') }}"
                                                    class="btn btn-soft-primary btn-sm material-shadow-none">Xuất File</a>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <a href="{{ route('enterprise.jobs.index') }}"
                                                    class="btn btn-soft-primary btn-sm material-shadow-none">Danh sách Job<i
                                                        class="ri-arrow-right-line align-bottom"></i></a>
                                            </div>
                                        </div><!-- end card header -->

                                        <div class="card-body">
                                            <div class="table-responsive table-card">
                                                <table
                                                    class="table table-centered table-hover align-middle table-nowrap mb-0">
                                                    <tbody>
                                                        @foreach ($featuredJob as $item)
                                                            <tr>
                                                                <td>
                                                                    <span
                                                                        class="text-primary">({{ $item->universities_count }})</span>

                                                                </td>
                                                                <td>
                                                                    {{ Str::limit($item->title, 30) }}
                                                                </td>
                                                                <td class="text-muted">
                                                                    {{ \Carbon\Carbon::parse($item->start_date)->format('d/m/y') }}
                                                                </td>
                                                                <td>
                                                                    {{ \Carbon\Carbon::parse($item->end_date)->format('d/m/y') }}
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('enterprise.jobs.show', $item->id) }}"
                                                                        class="btn btn-link btn-sm material-shadow-none">Chi
                                                                        tiết
                                                                        <i class="ri-arrow-right-line align-bottom"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="align-items-center mt-4 pt-2 justify-content-between">
                                                {{ $featuredJob->links() }}
                                            </div>
                                        </div>

                                    </div> <!-- .card-->
                                </div><!--end col-->

                            </div><!--end row-->

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">

                                        <div class="card-header border-0 align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Ngày hôm nay</h4>
                                            <div class="input-group w-25">
                                                <input id="date-picker" type="text"
                                                    class="form-control border-0 minimal-border dash-filter-picker shadow"
                                                    data-provider="flatpickr" data-range-date="true"
                                                    data-date-format="d M, Y" data-deafult-date="today" />

                                                <div class="input-group-text bg-primary border-primary text-white">
                                                    <i class="ri-calendar-2-line"></i>
                                                </div>
                                            </div>
                                        </div><!-- end card header -->

                                        <div class="card-header p-0 border-0 bg-light-subtle">
                                            <div class="row g-0 text-center">

                                                @php
                                                    $data = [
                                                        [
                                                            'id' => 'countJob',
                                                            'value' => $todayCountJob,
                                                            'class' => 'text-primary',
                                                            'label' => 'Tổng Job',
                                                        ],
                                                        [
                                                            'id' => 'countCooperate',
                                                            'value' => $todayCooperateSuccess,
                                                            'class' => 'text-success',
                                                            'label' => 'Hợp tác',
                                                        ],
                                                        [
                                                            'id' => 'countApply',
                                                            'value' => $todayApplySuccess,
                                                            'class' => 'text-warning',
                                                            'label' => 'Ứng tuyển Job',
                                                        ],
                                                        [
                                                            'id' => 'countWorkshop',
                                                            'value' => $todayWorkshopSuccess,
                                                            'class' => 'text-info',
                                                            'label' => 'Workshop',
                                                        ],
                                                    ];
                                                @endphp

                                                @foreach ($data as $index => $item)
                                                    <div class="col-6 col-sm-3">
                                                        <div
                                                            class="p-3 border border-dashed border-start-0 {{ $loop->last ? 'border-end-0' : '' }}">
                                                            <h5 class="mb-1">
                                                                <span class="counter-value {{ $item['class'] }}"
                                                                    id="{{ $item['id'] }}"
                                                                    data-target="{{ $item['value'] }}">0</span>
                                                            </h5>
                                                            <p class="text-muted mb-0">{{ $item['label'] }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div><!-- end card header -->

                                        <div class="card-body p-0 pb-2">
                                            <div class="w-100">
                                                <div id="customer_impression_charts"
                                                    data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-info"]'
                                                    data-colors-minimal='["--vz-light", "--vz-primary", "--vz-info"]'
                                                    data-colors-saas='["--vz-success", "--vz-info", "--vz-danger"]'
                                                    data-colors-modern='["--vz-warning", "--vz-primary", "--vz-success"]'
                                                    data-colors-interactive='["--vz-info", "--vz-primary", "--vz-danger"]'
                                                    data-colors-creative='["--vz-warning", "--vz-primary", "--vz-danger"]'
                                                    data-colors-corporate='["--vz-light", "--vz-primary", "--vz-secondary"]'
                                                    data-colors-galaxy='["--vz-secondary", "--vz-primary", "--vz-primary-rgb, 0.50"]'
                                                    data-colors-classic='["--vz-light", "--vz-primary", "--vz-secondary"]'
                                                    data-colors-vintage='["--vz-success", "--vz-primary", "--vz-secondary"]'
                                                    class="apex-charts" dir="ltr"></div>
                                            </div>
                                        </div><!-- end card body -->

                                    </div><!-- end card -->
                                </div>
                            </div>

                        </div> <!-- end .h-100-->
                    </div> <!-- end col -->
                </div>
            @endif
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/vn.js"></script>

    <script src="{{ asset('theme/admin/html/master/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- By Date -->
    <script src="{{ asset('assets/adminEnterprises/js/dashboardDate.js') }}"></script>

    <!-- Dashboard init -->
    <script src="{{ asset('assets/adminEnterprises/js/dashboard-column-chart.init.js') }}"></script>
    <script src="{{ asset('assets/adminEnterprises/js/dashboard-job.init.js') }}"></script>
@endsection

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="percentCountJob" content="{{ json_encode($percentCountJob) }}">
    <meta name="UnPercentCountJob" content="{{ json_encode($UnPercentCountJob) }}">
    <meta name="percentApplySuccess" content="{{ json_encode($percentApplySuccess) }}">
    <meta name="percentCooperateSuccess" content="{{ json_encode($percentCooperateSuccess) }}">
    <meta name="unPercentCooperate" content="{{ json_encode($unPercentCooperate) }}">
    <meta name="percentWorkshopSuccess" content="{{ json_encode($percentWorkshopSuccess) }}">

    <meta name="jobTotalMonth" content="{{ json_encode($jobTotalMonth) }}">
    <meta name="cooperateMonth" content="{{ json_encode($cooperateMonth) }}">
    <meta name="jobApplyMonth" content="{{ json_encode($jobApplyMonth) }}">
    <meta name="workshopCount" content="{{ json_encode($workshopCount) }}">
@endsection
