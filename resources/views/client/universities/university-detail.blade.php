@extends('client.layouts.master')

@section('content')
    <div class="page-title-area">
        <div class="container">
            <div class="page-title-content">
                <h2>{{ $university->name }}</h2>
                <ul>
                    <li>
                        <a href="#">
                            Trang chủ
                        </a>
                    </li>
                    <li><a href="{{ route('universities.list') }}">Danh sách trường học</a></li>
                    <li class="active">{{ $university->name }}</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="employers-details-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="hot-jobs-list">
                        <div class="row align-items-center">
                            <div class="col-lg-2">
                                <div class="hot-jobs-img">
                                    <img src="{{ $university->logo ? Storage::url($university->logo) : asset('theme/client/assets/images/hot-jobs/hot-jobs-2.png') }}" alt="Logo">

                                </div>
                            </div>

                            <div class="col-lg-10">
                                <div class="hot-jobs-content">
                                    <h3>{{ $university->name }}</h3>
                                    <button class="text-primary bg-white mb-2" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseExample" aria-expanded="false"
                                        aria-controls="collapseExample">
                                        Xem chuyên ngành ({{ $countMajor }})
                                    </button>

                                    <div class="collapse" id="collapseExample">
                                        @foreach ($university->majors as $item)
                                            <span class="badge text-bg-primary">{{ $item->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="employers-details-content">
                        <h3>Giới thiệu</h3>
                        <p class="">{!! $university->introduce !!}</p>

                        <h3>Mô tả</h3>
                        <p class="">{!! $university->description !!}</p>

                        @if (isset($university->enterprises[0]))
                            <h4 class="mt-1">Doanh nghiệp đã hợp tác</h4>
                            <div class="row pb-0">
                                @foreach ($enterprisy as $item)
                                    <div class="col-lg-2">
                                        <div class="office-photo">
                                            <a href="{{ route('enterprises.show', $item->slug) }}">
                                                @php
                                                    $url = $item->logo;

                                                    if (!\Str::contains($url, 'http') && $url != null) {
                                                        $url = \Illuminate\Support\Facades\Storage::url($url);
                                                    }
                                                @endphp
                                                <img class="rounded-circle" src="{{ $url ?? asset('assets/image/dn.jpg') }}" alt="Image">
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if (isset($university->workshops[0]))
                            <h4>Các workshop đã tạo</h4>
                            <div class="row pb-4">
                                @foreach ($university->workshops as $item)
                                    <div class="col-lg-4 p-3 mb-3">
                                        <a href="{{ route('workshop.detail', $item->id) }}">
                                            <h5>{{ $item->title }}</h5>
                                        </a>
                                        <li class="mb-2" style="list-style: none;"><b>Address: </b>{{ $item->address }}
                                        </li>
                                        <li class="mb-2" style="list-style: none;"><b>Applicants:
                                            </b>{{ $item->applicants }}</li>
                                        <span
                                            class="badge text-bg-secondary">{{ \Carbon\Carbon::parse($item->start_date)->format('d/m/Y') }}</span>
                                        -
                                        <span
                                            class="badge text-bg-primary">{{ \Carbon\Carbon::parse($item->end_date)->format('d/m/Y') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="employers-details-sidebar">
                        <div class="employer-widget">
                            <h3>Thông tin liên hệ</h3>

                            <ul class="overview">
                                <li class="fw-light">
                                    <strong>Email</strong> : {{ $university->email }}
                                </li>
                                <li class="fw-light">
                                    <strong>Số điện thoại</strong> : {{ $university->phone }}
                                </li>
                                <li class="fw-light">
                                    <strong>Địa chỉ</strong> : {{ $university->address }}
                                </li>
                                <li class="fw-light text-center">
                                    <a class="text-primary" target="_blank" href="{{ $university->url }}"><i
                                            class="fa-solid fa-link"></i> Website trường học</a>
                                </li>
                            </ul>
                        </div>

                        <div class="employer-widget">
                            <h3>Gửi yêu cầu hợp tác</h3>

                            <form action="{{ route('universities.cooperate') }}" method="post" class="contact-us">
                                @csrf

                                <input type="hidden" name="university_id" value="{{ $university->id }}">

                                <div class="form-group">
                                    <label>Tiêu đề</label>
                                    <input class="form-control @error('title') is-invalid @enderror" type="text"
                                        @disabled($checkCooperateExists) name="title" required
                                        value="{{ $notification ? $notification?->title : old('title') }}">
                                    @error('title')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Nội dung</label>
                                    <textarea name="message" class="form-control @error('message') is-invalid @enderror" @disabled($checkCooperateExists)
                                        rows="3" required>{{ $notification ? $notification?->message : old('message') }}</textarea>
                                    @error('message')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if (!$checkCooperateSuccess)
                                    @if (!$checkCooperateExists)
                                        <div class="text-center">
                                            <button class="default-btn" type="submit">Gửi</button>
                                        </div>
                                    @else
                                        @if ($checkCooperate)
                                            <div class="text-center">
                                                <button class="btn btn-danger" name="cancel" type="submit">
                                                    Hủy yêu cầu
                                                </button>
                                            </div>
                                        @else
                                            @if (!$checkCooperateRefuse)
                                                <div class="text-center">
                                                    <a target="_blank" class="text-primary"
                                                        href="{{ route('enterprise.collaborations.index') }}">Trường học
                                                        này đã
                                                        gửi yêu cầu hợp tác cho bạn. Vui lòng phản hồi!</a>
                                                </div>
                                            @else
                                                <div class="text-center">
                                                    <a href="#" class="btn btn-danger">Đã từ chối</a>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                @else
                                    <div class="text-center">
                                        <button class="btn btn-danger" type="button" data-bs-target="#exampleModalToggle"
                                            data-bs-toggle="modal">
                                            Hủy hợp tác
                                        </button>
                                    </div>

                                @endif

                                <div class="modal fade" id="exampleModalToggle" aria-hidden="true"
                                    aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Hủy hợp tác</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <label class="text-secondary mb-3">Hãy nhập lý do bạn muốn hủy hợp
                                                    tác.</label>
                                                <textarea name="messageCancel" class="form-control rounded" rows="5" placeholder="Nhập tại đây ..."></textarea>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Thoát</button>
                                                <button type="submit" class="btn btn-primary"
                                                    name="cancel">Gửi</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script src="{{ asset('theme/client/assets/js/jquery.min.js') }}"></script>
@endsection
