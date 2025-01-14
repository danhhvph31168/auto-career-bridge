@extends('admin.layouts.master')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @if (auth()->user()->status !== APPROVED &&
                    auth()->user()->user_type === TYPE_ENTERPRISE &&
                    auth()->user()->enterprise_id === null)
                <div class="alert alert-warning text-center">
                    <h4>Bạn cần cập nhật thông tin doanh nghiệp để sử dụng các chức năng của hệ thống.</h4>
                    <p>Vui lòng truy cập trang <a class="btn btn-primary btn-sm" href="{{ route('enterprise.profile.edit') }}">Cập nhật thông tin</a> để
                        hoàn tất
                        thông tin.</p>
                </div>
            @elseif (auth()->user()->status !== APPROVED &&
                    auth()->user()->user_type === TYPE_UNIVERSITY &&
                    auth()->user()->university_id === null)
                <div class="alert alert-warning text-center">
                    <h4>Bạn cần cập nhật thông tin nhà trường để sử dụng các chức năng của hệ thống.</h4>
                    <p>Vui lòng truy cập trang <a class="btn btn-primary btn-sm" href="{{ route('university.profile.edit') }}">Cập nhật thông tin</a> để
                        hoàn tất
                        thông tin.</p>
                </div>
            @else
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-10 col-md-12">
                        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                            <div class="card-body p-5">
                                <div class="text-center">
                                    <lord-icon class="avatar-xl mb-4" src="https://cdn.lordicon.com/etwtznjn.json"
                                        trigger="loop" colors="primary:#405189,secondary:#0ab39c">
                                    </lord-icon>

                                    <h1 class="text-primary mb-3 font-weight-bold">Thông báo!</h1>
                                    <h4 class="text-muted mb-4">Bạn vui lòng chờ hệ thống phê duyệt tài khoản để truy cập 😭
                                    </h4>
                                    <a href="{{ route('home') }}" class="btn btn-success btn-lg">
                                        <i class="mdi mdi-home me-2"></i>Trở về Trang chủ
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
