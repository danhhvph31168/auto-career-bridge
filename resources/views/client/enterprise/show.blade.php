@extends('client.layouts.master')

@section('content')
    @include('client.enterprise.components.title')
    {{-- @dd($enterprise) --}}
    <section class="job-details-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="hot-jobs-list">
                        <div class="row align-items-center">
                            <div class="col-lg-2">
                                <div class="hot-jobs-img">
                                    <img src="{{ str_contains($enterprise->logo, 'http') ? $enterprise->logo : Storage::url($enterprise->logo) }}"
                                        alt="Image">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="hot-jobs-content">
                                    <h3>{{ $enterprise->name }}</h3>
                                    <ul>
                                        <li><span>Chuyên ngành: </span> {{ $enterprise->industry }}</li>
                                        <li><span>Số nhân viên: </span> {{ $enterprise->size }}</li>
                                        <li><span>Mã số thuế: </span> {{ $enterprise->tax_code }}</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="hot-jobs-btn text-center">
                                    @if (auth()?->user()?->enterprise_id)
                                        <button class="default-btn collaboration " disabled>Hợp tác</button>
                                    @elseif (!$enterprise->has_collaboration)
                                        <form action="{{ route('universities.enterprise.send', $enterprise) }}"
                                            method="post">
                                            @csrf
                                            <button class="default-btn collaboration">Hợp tác</button>
                                        </form>
                                    @elseif ($enterprise->has_collaboration->status == PENDING_APPROVE)
                                        @if ($enterprise->has_collaboration->send_name == TYPE_UNIVERSITY)
                                            <form action="{{ route('universities.enterprise.un_send', $enterprise) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="default-btn collaboration">Hủy gửi hợp tác</button>
                                            </form>
                                        @elseif($enterprise->has_collaboration->send_name == TYPE_ENTERPRISE)
                                            <form action="{{ route('university.collaborations.update', $enterprise) }}"
                                                method="post">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="{{ APPROVED }}">
                                                <button class="default-btn collaboration">Đồng
                                                    ý</button>
                                            </form>
                                            <form action="{{ route('university.collaborations.update', $enterprise) }}"
                                                method="post">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="{{ UN_APPROVE }}">
                                                <button class="default-btn bg-danger collaboration">Từ
                                                    chối</button>
                                            </form>
                                        @endif
                                    @elseif ($enterprise->has_collaboration->status == APPROVED)
                                        <button class="default-btn collaboration" disabled>Đã đồng ý</button>
                                    @elseif ($enterprise->has_collaboration->status == UN_APPROVE)
                                        <button class="default-btn collaboration" disabled>Đã từ chối</button>
                                    @endif
                                    <p><span>Ngày tạo: {{ date('d/m/Y', strtotime($enterprise->created_at)) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="job-details-content">
                        <h3>Giới thiệu:</h3>
                        <p>{{ $enterprise->introduce }}</p>

                        <h4>Mô tả:</h4>

                        <p>
                            {!! $enterprise->description !!}
                        </p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="job-details-sidebar">
                        <div class="job-widget">
                            <h3>{{ config('apps.clients.enterprises.show.contact') }}</h3>

                            <div class="social-icon">
                                <div class="single-footer-widget">
                                    <ul class="address">
                                        <li>
                                            <i class="bx bx-phone-call"></i>
                                            <span>Phone:</span>
                                            <a> {{ $enterprise->phone }}</a>
                                        </li>
                                        <li>
                                            <i class="bx bx-envelope"></i>
                                            <span>Email:</span>
                                            <a>{{ $enterprise->email }}</a>
                                        </li>
                                        <li class="location">
                                            <i class="bx bx-location-plus"></i>
                                            <span>Address:</span>
                                            {{ $enterprise->address }}
                                        </li>
                                    </ul>
                                </div>
                                <div class="text-center">
                                    <a href="{{ $enterprise->url }}" target="_blank"><i class="fa-solid fa-link"></i> Đến
                                        trang
                                        công ty</a>
                                </div>
                            </div>

                        </div>

                        {{-- <div class="job-widget">
                            <h3>Thông tin chung</h3>

                            <ul class="overview">
                                <li>
                                    Số lượng
                                    <span>: 01</span>
                                </li>
                                <li>
                                    Hình thức
                                    <span>: type</span>
                                </li>
                                <li>
                                    Kinh nghiệm
                                    <span>: kn</span>
                                </li>
                                <li>
                                    Mức lương
                                    <span>: luong</span>
                                </li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
