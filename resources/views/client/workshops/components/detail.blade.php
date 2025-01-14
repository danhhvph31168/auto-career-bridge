@if (isset($workshop) && !empty($workshop))
    <section class="job-details-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="hot-jobs-list">
                        <div class="row align-items-center">
                            <div class="col-lg-2">
                                <div class="hot-jobs-img">
                                    <img src="{{ asset('theme/client/assets/images/hot-jobs/hot-jobs-1.png') }}"
                                        alt="Image">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="hot-jobs-content">
                                    <h3>{{ $workshop->title }}</h3>
                                    <span class="sub-title">{{ $university->name }}</span>
                                    <ul>
                                        <li><span>Số lượng:</span> {{ $workshop->applicants }}</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="hot-jobs-btn">
                                    @if (\Carbon\Carbon::now()->toDateString() > $workshop->end_date)
                                        <a class="btn btn-secondary">Quá hạn tham gia</a>
                                    @else
                                        @if (!$checkJoin)
                                            <a class="default-btn" data-bs-target="#exampleModalToggle"
                                                data-bs-toggle="modal">Tham gia ngay</a>
                                        @else
                                            @if ($checkJoinSuccess)
                                                <a class="btn btn-success">Tham gia thành công</a>
                                            @elseif ($checkJoinRefuse)
                                                <a class="btn btn-danger">Đã từ chối</a>
                                            @else
                                                <a class="btn btn-secondary">Chờ phản hồi</a>
                                            @endif
                                        @endif
                                    @endif
                                    <p class="mt-2"><span>Hạn nộp:
                                        </span>{{ \Carbon\Carbon::parse($workshop->end_date)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="job-details-content">
                        <h3>Mô tả buổi hội thảo</h3>
                        <p>{!! $workshop->description !!}</p>

                        <h4>Yêu cầu nhà tuyển dụng:</h4>

                        <p>
                            {!! $workshop->requirement !!}
                        </p>

                        <h4>Địa điểm diễn ra:</h4>

                        <p>{{ $workshop->address }}</p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="job-details-sidebar">
                        <div class="job-widget">
                            <h3> Thông tin liên hệ </h3>

                            <div class="social-icon">
                                <div class="mb-4">
                                    <span><i class="fa-regular fa-envelope"></i> Email:
                                        {{ $university->email }}</span>
                                </div>
                                <div class="mb-4">
                                    <span><i class="fa-solid fa-phone"></i> Số điện thoại:
                                        {{ $university->phone }}</span>
                                </div>
                                <div class="mb-4">
                                    <span><i class="fa-solid fa-location-dot"></i> Địa điểm:
                                        {{ $university->address }}</span>
                                </div>
                                <div class="text-center">
                                    <a href=""><i class="fa-solid fa-link"></i> Đến trang trường học</a>
                                </div>
                            </div>

                        </div>
                        <div class="job-widget">
                            <h3>Thông tin chi tiết </h3>

                            <div class="social-icon">
                                <div class="mb-4">
                                    <span><i class="fa-regular fa-calendar"></i> Ngày bắt đầu:
                                        {{ \Carbon\Carbon::parse($workshop->start_date)->format('d/m/Y') }}</span>
                                </div>
                                <div class="mb-4">
                                    <span><i class="fa-regular fa-calendar"></i> Ngày kết thúc:
                                        {{ \Carbon\Carbon::parse($workshop->end_date)->format('d/m/Y') }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <b class="modal-title fw-blod fs-5" id="exampleModalToggleLabel">Tham gia: <span
                            class="text-primary">{{ Str::upper($workshop->title) }}</span></b>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('workshop.apply') }}" method="post">
                    @csrf
                    <input type="hidden" name="workshopId" value="{{ $workshop->id }}">

                    <div class="modal-body">
                        <label class="fw-bold">Thư giới thiệu:</label>
                        <label class="text-secondary mb-3">Một thư giới thiệu ngắn gọn, chỉn chu sẽ giúp bạn trở nên
                            chuyên nghiệp và gây ấn tượng hơn với nhà tuyển dụng.</label>
                        <textarea name="message" class="form-control rounded" rows="5" placeholder="Nhập tại đây ..."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Xác
                            nhận</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endif
