@if (isset($job) && !empty($job))
    <section class="job-details-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="hot-jobs-list">
                        <div class="row align-items-center">
                            <div class="col-lg-2">
                                <div class="hot-jobs-img">
                                    @if (!empty($job->enterprises->logo) && filter_var($job->enterprises->logo, FILTER_VALIDATE_URL))
                                        <img src="{{ $job->enterprises->logo }}" width="50px" alt="logo">
                                    @elseif (!empty($job->enterprises->logo) && Storage::exists($job->enterprises->logo))
                                        <img src="{{ Storage::url($job->enterprises->logo) }}" width="60px"
                                            alt="logo">
                                    @else
                                        <img src="https://placehold.co/50" width="50px" alt="Default logo">
                                    @endif

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="hot-jobs-content">
                                    <h3>{{ Str::limit($job->title, 25, '...') }}</h3>
                                    <span class="sub-title">{{ $enterprise->name }}</span>
                                    <ul>
                                        <li><span>Số lượng:</span> {{ $job->applicants }}</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="hot-jobs-btn">
                                    @if (\Carbon\Carbon::now()->toDateString() > $job->end_date)
                                        <a class="btn btn-secondary">Quá hạn ứng tuyển</a>
                                    @else
                                        @if (!$checkApply)
                                            <a class="default-btn" data-bs-target="#exampleModalToggle"
                                                data-bs-toggle="modal">Ứng tuyển ngay</a>
                                        @else
                                            @if ($checkApplySuccess)
                                                <a class="btn btn-success">Ứng tuyển thành công</a>
                                            @elseif ($checkApplyRefuse)
                                                <a class="btn btn-danger">Đã từ chối</a>
                                            @else
                                                <a class="btn btn-secondary">Bạn đã ứng tuyển</a>
                                            @endif
                                        @endif
                                    @endif
                                    <p class="mt-2"><span>Hạn nộp:
                                        </span>{{ \Carbon\Carbon::parse($job->end_date)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="job-details-content">
                        <h3>Mô tả công việc</h3>
                        <p>{!! $job->description !!}</p>

                        <h4>Yêu cầu ứng viên:</h4>

                        <p>
                            {!! $job->requirement !!}
                        </p>

                        <h4>Quyền lợi:</h4>

                        <p>
                            {!! $job->benefit !!}
                        </p>

                        <h4>Địa điểm làm việc:</h4>

                        <p>{{ $job->address }}</p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="job-details-sidebar">
                        <div class="job-widget">
                            <h3>{{ $enterprise->name }}</h3>

                            <div class="social-icon">
                                <div class="mb-4" style="font-weight: 600; font-size: 15px; color: #1a1a1a">
                                    <span><i class="fa-solid fa-users"></i> Quy mô: {{ $enterprise->size }}</span>
                                </div>
                                <div class="mb-4" style="font-weight: 600; font-size: 15px; color: #1a1a1a">
                                    <span><i class="fa-solid fa-industry"></i> Lĩnh vực:
                                        {{ $enterprise->industry }}</span>
                                </div>
                                <div class="mb-4" style="font-weight: 600; font-size: 15px; color: #1a1a1a">
                                    <span><i class="fa-solid fa-location"></i> Địa điểm:
                                        {{ $enterprise->address }}</span>
                                </div>
                                <div class="text-center">
                                    <a href=""><i class="fa-solid fa-link"></i> Đến trang công ty</a>
                                </div>
                            </div>

                        </div>

                        <div class="job-widget">
                            <h3>Thông tin chung</h3>

                            <ul class="overview">
                                <li>
                                    Số lượng
                                    <span>: 01</span>
                                </li>
                                @php
                                    $type = [
                                        FULL_TIME => 'Toàn thời gian',
                                        PART_TIME => 'Bán thời gian',
                                        REMOTE => 'Làm việc từ xa',
                                    ];
                                @endphp
                                <li>
                                    Hình thức
                                    <span>: {{ $type[$job->type] }}</span>
                                </li>
                                <li>
                                    Kinh nghiệm
                                    <span>: {{ $job->experience_level }}</span>
                                </li>
                                <li>
                                    Mức lương
                                    <span>: {{ $job->salary }}</span>
                                </li>
                            </ul>
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
                    <b class="modal-title fw-blod fs-5" id="exampleModalToggleLabel">Ứng tuyển: <span
                            class="text-primary">{{ Str::limit($job->title, 50, '...') }}</span></b>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('job.apply') }}" method="post">
                    @csrf
                    <input type="hidden" name="jobId" value="{{ $job->id }}">

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
