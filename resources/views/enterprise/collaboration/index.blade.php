@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/info.css') }}">
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Quản lý hợp tác</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="listjs-table" id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm">
                                        <form id="filterForm" action="" method="GET">
                                            <div class="d-flex justify-content-sm-end">
                                                <div class="search-box ms-2">
                                                    <button class="btn m-0 p-0 search-icon"><i
                                                            class="ri-search-line "></i></button>
                                                    <input type="text" name="keyword"
                                                        value="{{ request('keyword') ?: old('keyword') }}"
                                                        class="form-control search" placeholder="Tìm kiếm">
                                                </div>

                                                {{-- <div class="search-box ms-2">
                                                    <input type="text" name="start_date"
                                                        value="{{ request('start_date') ?: old('start_date') }}"
                                                        class="form-control search " placeholder="Ngày bắt đầu"
                                                        data-provider="flatpickr" data-date-format="d/m/Y"
                                                        id="StartleaveDate">
                                                </div>

                                                <div class="search-box ms-2">
                                                    <input type="text" name="end_date"
                                                        value="{{ request('end_date') ?: old('end_date') }}"
                                                        class="form-control search " placeholder="Ngày kết thúc"
                                                        data-provider="flatpickr" data-date-format="d/m/Y"
                                                        id="EndleaveDate">
                                                </div> --}}

                                                <div class="search-box ms-2">
                                                    {{-- <button class="btn btn-success w-100">
                                                    <i class="mdi mdi-magnify search-widget-icon"></i> Tìm kiếm
                                                </button> --}}
                                                    <a href="{{ route('enterprise.collaborations.index') }}">
                                                        <button type="button" class="btn btn-light w-100">
                                                            Hủy
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>


                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table align-middle table-nowrap" id="customerTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="sort" data-sort="stt">STT</th>
                                                <th class="sort" data-sort="name">Tên trường</th>
                                                <th class="sort" data-sort="send_name">Gửi bởi</th>
                                                <th class="sort" data-sort="major">Ngày gửi</th>
                                                <th class="text-center">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($collaborations as $index => $university)
                                                <div class="modal fade" id="showModal{{ $university->id }}" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div
                                                        class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-light p-3">
                                                                <h5 class="modal-title" id="exampleModalLabel">THÔNG TIN
                                                                    TRƯỜNG
                                                                    HỌC</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"
                                                                    id="close-modal"></button>
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
                                                                                                <h3>{{ $university->name }}
                                                                                                </h3>
                                                                                                <ul>
                                                                                                    <li><span>Chuyên ngành:
                                                                                                        </span>
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
                                                                                    <h3>Giới thiệu:</h3>
                                                                                    <p>{{ $university->introduce }}</p>
                                                                                    <h4>Mô tả:</h4>
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
                                                                                            <div
                                                                                                class="single-footer-widget">
                                                                                                <ul class="address">
                                                                                                    <li>
                                                                                                        <i
                                                                                                            class="bx bx-phone-call"></i>
                                                                                                        <span>Phone:</span>
                                                                                                        <a>
                                                                                                            {{ $university->phone }}</a>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <i
                                                                                                            class="bx bx-envelope"></i>
                                                                                                        <span>Email:</span>
                                                                                                        <a>{{ $university->email }}</a>
                                                                                                    </li>
                                                                                                    <li class="location">
                                                                                                        <i
                                                                                                            class="bx bx-location-plus"></i>
                                                                                                        <span>Address:</span>
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
                                                <tr class>
                                                    <td class="stt">
                                                        {{ $index + 1 + $collaborations->perPage() * ($collaborations->currentPage() - 1) }}
                                                    </td>
                                                    <td class="name">{{ $university->name }}</td>
                                                    <td class="send_name">
                                                        {{ $university->pivot->send_name == TYPE_ENTERPRISE ? 'Bạn' : 'Trường học' }}
                                                    </td>
                                                    <td class="start_date">
                                                        {{ \Carbon\Carbon::parse($university->pivot->created_at)->format('d/m/Y') }}
                                                        ({{ now()->diffInDays($university->pivot->created_at) > 0 ? now()->diffInDays($university->pivot->created_at) . ' ngày trước' : 'hôm nay' }})
                                                    </td>
                                                    <td class="d-flex justify-content-center">
                                                        <div class="d-flex gap-2">
                                                            <div class="eye">
                                                                <button type="button"
                                                                    class="btn btn-soft-primary btn_modal"
                                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                                    data-bs-custom-class="custom-tooltip"
                                                                    data-bs-title="Xem chi tiết."
                                                                    data-university="{{ $university->id }}">
                                                                    <i class="ri-eye-line"></i>
                                                                </button>
                                                            </div>
                                                            <div
                                                                class="d-flex gap-2 status_university_{{ $university->id }}">
                                                                @if ($university->pivot->send_name == TYPE_UNIVERSITY)
                                                                    @if ($university->pivot->status == PENDING_APPROVE)
                                                                        <form
                                                                            action="{{ route('enterprise.collaborations.update', $university) }}"
                                                                            method="post">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="status"
                                                                                value="{{ APPROVED }}">
                                                                            <button class="btn btn-success change_status"
                                                                                data-university="{{ $university->id }}"
                                                                                data-status="{{ APPROVED }}">Đồng
                                                                                ý</button>
                                                                        </form>
                                                                        <form
                                                                            action="{{ route('enterprise.collaborations.update', $university) }}"
                                                                            method="post">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="status"
                                                                                value="{{ UN_APPROVE }}">
                                                                            <button class="btn btn-danger change_status"
                                                                                data-university="{{ $university->id }}"
                                                                                data-status="{{ UN_APPROVE }}">Từ
                                                                                chối</button>
                                                                        </form>
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
                                                                @elseif($university->pivot->send_name == TYPE_ENTERPRISE)
                                                                    @if ($university->pivot->status == PENDING_APPROVE)
                                                                        <form
                                                                            action="{{ route('enterprise.collaborations.destroy', $university) }}"
                                                                            method="post">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            {{-- <input type="hidden" name="status"
                                                                        value="{{ UN_APPROVE }}"> --}}
                                                                            <button class="btn btn-danger change_status"
                                                                                data-university="{{ $university->id }}"
                                                                                data-status="{{ UN_APPROVE }}">Hủy gửi
                                                                                hợp
                                                                                tác</button>
                                                                        </form>
                                                                    @elseif ($university->pivot->status == APPROVED)
                                                                        <p
                                                                            class="border mb-0 p-2 rounded text-success bg-success-subtle">
                                                                            Đã được đồng ý
                                                                        </p>
                                                                    @elseif ($university->pivot->status == UN_APPROVE)
                                                                        <p
                                                                            class="border mb-0 p-2 rounded text-danger bg-danger-subtle">
                                                                            Đã bị từ chối
                                                                        </p>
                                                                    @endif
                                                                @endif
                                                            </div>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if ($collaborations->isEmpty())
                                        <div class="noresult">
                                            <div class="text-center">
                                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                                    colors="primary:#121331,secondary:#08a88a"
                                                    style="width:75px;height:75px"></lord-icon>
                                                <h5 class="mt-2">Không có kết quả</h5>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="row d-flex justify-content-between align-items-center">
                                    <div class="col-10">
                                        {{ $collaborations->links('pagination::bootstrap-5') }}
                                    </div>
                                    @if ($collaborations->isNotEmpty())
                                        <div class="col-2 ">
                                            <select class="form-select mb-3 per_page" aria-label="Default select example">
                                                <option value="10"
                                                    {{ request()->get('perPage') == 10 ? 'selected' : '' }}>
                                                    10</option>
                                                <option value="50"
                                                    {{ request()->get('perPage') == 50 ? 'selected' : '' }}>50</option>
                                                <option value="100"
                                                    {{ request()->get('perPage') == 100 ? 'selected' : '' }}>100</option>
                                            </select>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.btn_modal', function() {
                const universityId = $(this).data('university');
                $(`#showModal${universityId}`).modal('show');
            });
        });
    </script>
@endsection
