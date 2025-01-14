@extends('admin.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Chi tiết {{ $notification->title }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.notifications.index') }}">Danh sách</a>
                                </li>
                                <li class="breadcrumb-item active">Chi tiết thông báo</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row g-4">

                        <div class="col-lg-4">

                            <div>
                                <h4>{{ $notification->title }}</h4>

                                <div class="mt-3 text-muted">
                                    <p>
                                        {!! nl2br(e($notification->message)) !!}
                                    </p>
                                </div>

                                <div class="product-content mt-3">
                                    <h5 class="fs-14 mb-3">Kiểu thông báo:
                                        <span>
                                            @if ($notification->type == NOTIFY_SYSTEM)
                                                Hệ thống
                                            @elseif ($notification->type == NOTIFY_COOPERATE)
                                                Hợp tác
                                            @elseif ($notification->type == NOTIFY_APPLY)
                                                Công việc
                                            @elseif ($notification->type == NOTIFY_FEEDBACK)
                                                Phản hồi
                                            @elseif ($notification->type == NOTIFY_REGISTER_TYPE)
                                                Đăng ký
                                            @else
                                                Hội thảo
                                            @endif
                                        </span>
                                    </h5>

                                    <h5 class="fs-14 mb-3">Trạng thái:
                                        <span>Đã đọc</span>
                                    </h5>

                                    <h5 class="fs-14 mb-3">Thời gian gửi:
                                        <span>{{ $notification->created_at->format('H:i:s - d/m/Y') }}</span>
                                    </h5>

                                </div>

                                @if ($notification->censor_id != null)
                                    <div class="mt-3">
                                        <form action="{{ route('admin.notifications.censor') }}" method="post">
                                            @csrf

                                            <input type="hidden" name="type_notify" value="{{ $notification->type }}">
                                            <input type="hidden" name="censor_id" value="{{ $notification->censor_id }}">
                                            <input type="hidden" name="sender_id" value="{{ $notification->sender_id }}">
                                            <input type="hidden" name="receiver_id"
                                                value="{{ $notification->receiver_id }}">

                                            @if ($job_university != false)
                                                @if ($job_university->status == PENDING_APPROVE)
                                                    <button class="btn btn-success" name="accept">Đồng ý</button>
                                                    <button class="btn btn-danger" name="reject">Từ chối</button>
                                                @elseif($job_university->status == APPROVED)
                                                    <a href="#" class="btn btn-success">Đã đồng ý</a>
                                                @elseif($job_university->status == UN_APPROVE)
                                                    <a href="#" class="btn btn-danger">Đã từ chối</a>
                                                @endif
                                            @endif

                                            @if ($workshop_enterprise != false)
                                                @if ($workshop_enterprise->status == PENDING_APPROVE)
                                                    <button class="btn btn-success" name="accept">Đồng ý</button>
                                                    <button class="btn btn-danger" name="reject">Từ chối</button>
                                                @elseif($workshop_enterprise->status == APPROVED)
                                                    <a href="#" class="btn btn-success">Đã đồng ý</a>
                                                @elseif($workshop_enterprise->status == UN_APPROVE)
                                                    <a href="#" class="btn btn-danger">Đã từ chối</a>
                                                @endif
                                            @endif

                                            @if ($collaborations != false)
                                                @if ($collaborations->status == PENDING_APPROVE)
                                                    <button class="btn btn-success" name="accept">Đồng ý</button>
                                                    <button class="btn btn-danger" name="reject">Từ chối</button>
                                                @elseif($collaborations->status == APPROVED)
                                                    <a href="#" class="btn btn-success">Đã đồng ý</a>
                                                @elseif($collaborations->status == UN_APPROVE)
                                                    <a href="#" class="btn btn-danger">Đã từ chối</a>
                                                @endif
                                            @endif
                                        </form>
                                    </div>
                                @endif

                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="sticky-side-div d-flex">
                                @if ($notification->sender->user_type == TYPE_ADMIN)
                                    <div class="card ribbon-box shadow-none right me-4">
                                        <img src="{{ asset('assets/image/avatar.png') }}" alt=""
                                            class="img-fluid rounded" width="200px" height="200px">
                                    </div>
                                    <div class="mt-3">
                                        <h3>Hệ thống</h3>
                                    </div>
                                @else
                                    @if (Auth::user()->university_id == null && Auth::user()->user_type == TYPE_ENTERPRISE)
                                        <div class="card ribbon-box shadow-none right me-4">
                                            @if ($isCollaborating == true)
                                                <div class="ribbon-two ribbon-two-primary"><span><i
                                                            class="ri-fire-fill align-bottom"></i> Hợp tác</span></div>
                                            @endif

                                            @php
                                                $url = $notification->sender->university->logo;

                                                if (!\Str::contains($url, 'http') && $url != null) {
                                                    $url = \Illuminate\Support\Facades\Storage::url($url);
                                                }
                                            @endphp
                                            <img src="{{ $url ?? asset('assets/image/th.png') }}" alt=""
                                                class="img-fluid rounded" width="200px" height="200px">

                                            <div class="hstack gap-2 mt-2">
                                                <a href="{{ route('universities.show', ['slug' => str_replace(' ', '-', $notification->sender->university->name)]) }}"
                                                    class="btn btn-primary w-100" target="_blank"><i
                                                        class="ri-eye-line"></i></a>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <h3>{{ $notification->sender->university->name }}</h3>
                                            <p class="mb-1 fs-14">Email: {{ $notification->sender->university->email }}</p>
                                            <p class="mb-1 fs-14">Số điện thoại:
                                                {{ $notification->sender->university->phone }}</p>
                                            <p class="mb-1 fs-14">Địa chỉ: {{ $notification->sender->university->address }}
                                            </p>
                                            <p class="text-muted">{!! $notification->sender->university->description !!}</p>
                                        </div>
                                    @endif

                                    @if (Auth::user()->enterprise_id == null && Auth::user()->user_type == TYPE_UNIVERSITY)
                                        <div class="card ribbon-box shadow-none right me-4 w-25">
                                            @if ($isCollaborating == true)
                                                <div class="ribbon-two ribbon-two-primary"><span><i
                                                            class="ri-fire-fill align-bottom"></i> Hợp tác</span></div>
                                            @endif

                                            @php
                                                $url = $notification->sender->enterprise->logo;

                                                if (!\Str::contains($url, 'http') && $url != null) {
                                                    $url = \Illuminate\Support\Facades\Storage::url($url);
                                                }
                                            @endphp
                                            <img src="{{ $url ?? asset('assets/image/dn.jpg') }}"
                                                alt="" class="img-fluid rounded" width="200px" height="200px">

                                            <div class="hstack gap-2 mt-2">
                                                <a href="{{ route('enterprises.show', $notification->sender->enterprise->slug) }}"
                                                    class="btn btn-primary w-100" target="_blank"><i
                                                        class="ri-eye-line"></i></a>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <h3>{{ $notification->sender->enterprise->name }}</h3>
                                            <p class="mb-1 fs-14">Email: {{ $notification->sender->enterprise->email }}</p>
                                            <p class="mb-1 fs-14">Số điện thoại:
                                                {{ $notification->sender->enterprise->phone }}</p>
                                            <p class="mb-1 fs-14">Địa chỉ: {{ $notification->sender->enterprise->address }}
                                            </p>
                                            <p class="text-muted">{!! $notification->sender->enterprise->description !!}</p>
                                        </div>
                                    @endif

                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #405189;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #405189;
        }
    </style>
@endsection
