@extends('client.layouts.master')
@section('content')
<!-- Start Banner Area -->
<section class="banner-area ptb-100">
    <div class="d-table">
        <div class="d-table-cell">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <div class="banner-content" data-cues="slideInUp" data-group="images">
                            <h1>Tìm Kiếm Việc Làm </h1>
                            <p>Có hơn {{ $status['totalJobsToDay'] ?? '' }} việc làm ngay hôm nay!</p>

                            <form class="search-job" action="{{ route('job.search') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-5 col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="job-title" name="keyword"
                                                placeholder="Vị trí tuyển dụng, tên công ty">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="job-title-2" name="province"
                                                placeholder="Tỉnh/thành phố">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-sm-6 offset-sm-3 offset-lg-0">
                                        <button type="submit" class="default-btn">
                                            <i class="bx bx-search"></i>
                                            Tìm kiếm
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="total-job-count">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6 col-md-4">
                                        <div class="job-count">
                                            <h3><span>Công việc hiện tại: </span>{{ $status['totalJobs'] ?? '' }}</h3>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-sm-6 col-md-4">
                                        <div class="job-count">
                                            <h3><span>Công ty hiện tại: </span>{{ $status['totalEnterprise'] ?? '' }}</h3>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-sm-6 col-md-4 offset-sm-3 offset-lg-0 offset-md-0">
                                        <div class="job-count">
                                            <h3><span>Công việc mới: </span>{{ $status['newJobs'] ?? '' }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="banner-img">
                            <img src="{{ asset('theme/client/assets/images/banner/banner-img.png') }}" alt="Image">

                            <div class="video-content">
                                <a href="https://www.youtube.com/watch?v=BVnMXNW_grk" class="popup-youtube">
                                    <i class="flaticon-play-button-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- End Banner Area -->

<!-- Start Working Area -->
<section class="working-area bg-color pt-100 pb-70">
    <div class="container">
        <div class="section-title" data-cues="slideInUp">
            <span>Quy Trình Làm Việc</span>
            <h2>Cách Jubi Hoạt Động</h2>
        </div>

        <div class="row justify-content-center" data-cues="slideInUp">
            <div class="col-lg-3 col-sm-6">
                <div class="single-working">
                    <i class="flaticon-find-my-friend"></i>
                    <a href="{{ route('job.list') }}">
                        <h3>Tìm Công Việc Phù Hợp</h3>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="single-working">
                    <i class="flaticon-company"></i>
                    <a href="{{ route('enterprises.index') }}">
                        <h3>Nghiên Cứu Các Công Ty</h3>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="single-working">
                    <i class="flaticon-salary"></i>
                    <a href="{{ route('job.list') }}">
                        <h3>So Sánh Mức Lương</h3>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="single-working">
                    <i class="flaticon-submit"></i>
                    <a href="{{ route('job.list') }}">
                        <h3>Ứng Tuyển Nhanh Chóng</h3>
                    </a>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- End Working Area -->

<!-- Start Partner Area -->
<div class="partner-area bg-color">
    <div class="container">
        <div class="section-title" data-cues="slideInUp">
            <span>Công Việc Phổ Biến</span>
            <h2>Công Ty Tuyển Dụng Hàng Đầu</h2>
        </div>

        <div class="partner-bg" data-cues="slideInUp">
            <div class="partner-slider owl-carousel owl-theme">
                @foreach ($status['listEnterprise'] as $enterprise)
                <div class="partner-item">
                    <img src="{{ $enterprise->logo ? Storage::url($enterprise->logo) : asset('theme/client/assets/images/partner/partner-5.png') }}" alt="Logo">
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- End Partner Area -->

<!-- Start Live Jobs Area -->
{{-- <section class="live-jobs-area bg-color ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="section-title" data-cues="slideInUp">
                    <span>Ngành nghề đa dạng</span>
                    <h2>Lĩnh vực hiện có</h2>

                </div>

                <div class="live-jobs-item">
                    <div class="row justify-content-center" data-cues="slideInUp">
                        @foreach ($status['listMajor'] as $major)
                        <div class="col-lg-2 col-sm-6">
                            <div class="single-live-job">
                                <i class="flaticon-calculations"></i>
                                <a href="{{ route('job.list') }}">
                                    {{ $major->name }}
                                </a>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="hiring-list">
                    <h3 data-cues="slideInUp">Tuyển Dụng Ngay</h3>

                    <ul data-cues="slideInUp">
                        @foreach($status['jobList'] as $listJob)
                        <li>
                            <a href="{{ route('job.detail', $listJob->id) }}" class="hiring-img">

                                <img src="{{ $listJob->enterprises->logo ? Storage::url($listJob->enterprises->logo) : asset('theme/client/assets/images/hot-jobs/hot-jobs-2.png') }}" alt="Logo">

                            </a>
                            <a href="{{ route('job.detail', $listJob->id) }}" class="link">{{ $listJob->title }}</a>
                            <span>{{ $listJob->requirement }}</span>
                        </li>
                        @endforeach


                    </ul>
                </div>
            </div>
        </div>
    </div>
</section> --}}

<!-- End Live Jobs Area -->

<!-- Start Hot Jobs Area -->
<section class="hot-jobs-area bg-color pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mt-5">
                <div class="section-title">
                    <h2>Công việc mới</h2>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6">
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="show-page">
                            <p>Hiển thị trên mỗi trang</p>
                            <select id="perPage">
                                <option value="1">05</option>
                                <option value="3">10</option>
                                <option value="4">15</option>
                                <option value="5">20</option>
                                <option value="6">25</option>
                            </select>
                        </div>
                    </div>
                </div>

                @foreach($status['jobList'] as $listJob)
                <div class="hot-jobs-list">
                    <div class="row align-items-center">
                        <div class="col-lg-2">
                            <a href="{{ route('job.detail', $listJob->id) }}" class="hot-jobs-img">
                            <img src="{{ $listJob->enterprises->logo ? Storage::url($listJob->enterprises->logo) : asset('theme/client/assets/images/hot-jobs/hot-jobs-2.png') }}" alt="Logo">
                            </a>
                        </div>

                        <div class="col-lg-6">
                            <div class="hot-jobs-content">
                                <h3><a href="{{ route('job.detail', $listJob->id) }}">{{ $listJob->title }}</a></h3>
                                <ul>
                                    <li><span>Kinh nghiệm: </span>{{ $listJob->requirement }}</li>
                                    <li><span>Địa chỉ: </span>{{ $listJob->address }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="hot-jobs-btn">
                                <a href="{{ route('job.detail', $listJob->id) }}" class="default-btn">Chi tiết</a>
                                <p><span>Hạn ứng tuyển: </span>{{ \Carbon\Carbon::parse($listJob->end_date)->format('d/m/Y') }}</p>

                            </div>
                        </div>
                    </div>
                    <span class="featured">Nổi bật</span>
                </div>
                @endforeach

                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <!-- <div id="pagination">
                            <div class="pagination-area">
                                <span class="page-numbers current" aria-current="page">1</span>
                                <a href="index.html" class="page-numbers">2</a>
                                <a href="index.html" class="page-numbers">3</a>

                                <a href="index.html" class="next page-numbers">
                                    <i class="flaticon-right-arrow"></i>
                                </a>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="hot-jobs-sidebar">
                    <div class="hot-job-sidebar">
                        <img src="{{ asset('theme/client/assets/images/hot-jobs/hot-jobs-sidebar-img.jpg') }}" alt="Image">

                        <div class="hot-job-sidebar-content">
                            <h3 data-cues="slideInUp">Lợi ích khi sử dụng Jobs</h3>

                            <ul data-cues="slideInUp">
                                <li>
                                    <span>1</span>
                                    <a href="job-listing.html">Hỗ trợ khách hàng tận tình</a>
                                </li>
                                <li>
                                    <span>2</span>
                                    <a href="job-listing.html">Truy cập vào coaching nghề nghiệp</a>
                                </li>
                                <li>
                                    <span>3</span>
                                    <a href="job-listing.html">Khóa học kỹ năng</a>
                                </li>
                                <li>
                                    <span>4</span>
                                    <a href="job-listing.html">Dịch vụ thân thiện, chất lượng</a>
                                </li>
                                <li>
                                    <span>5</span>
                                    <a href="job-listing.html">Truy cập vào nghiên cứu độc quyền</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="hot-job-sidebar">
                        <div class="hot-job-sidebar-content quick-link">
                            <h3 data-cues="slideInUp">Liên kết nhanh</h3>

                            <ul data-cues="slideInUp">
                                <li>
                                    <i class="bx bx-chevrons-right"></i>
                                    <a href="{{ route('enterprises.index') }}">Danh sách nhà tuyển dụng</a>
                                </li>
                                <li>
                                    <i class="bx bx-chevrons-right"></i>
                                    <a href="{{ route('job.list') }}">Công việc mới (24 giờ)</a>
                                </li>
                                <li>
                                    <i class="bx bx-chevrons-right"></i>
                                    <a href="{{ route('job.list') }}">Hạn ứng tuyển ngày mai</a>
                                </li>
                                <li>
                                    <i class="bx bx-chevrons-right"></i>
                                    <a href="{{ route('job.list') }}">Công việc khẩn cấp</a>
                                </li>
                                <li>
                                    <i class="bx bx-chevrons-right"></i>
                                    <a href="{{ route('job.list') }}">Công việc bán thời gian</a>
                                </li>
                                <li>
                                    <i class="bx bx-chevrons-right"></i>
                                    <a href="{{ route('job.list') }}">Tìm việc ngay</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- End Hot Jobs Area -->

<!-- Start Global Talent Area -->
<section class="global-talent-area bg-color pb-100">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-6">
                <div class="global-talent-content" data-cues="slideInUp">
                    <span>Tài Năng Toàn Cầu</span>
                    <h2>Phát Triển Sự Nghiệp, Công Việc Mơ Ước Đang Chờ Đón Bạn</h2>

                    <ul>
                        <li>
                            <img src="{{ asset('theme/client/assets/images/talent-dot/talent-dot-1.png') }}"
                                alt="Hình ảnh">
                            Công Việc Toàn Thời Gian & Bán Thời Gian
                        </li>

                        <li>
                            <img src="{{ asset('theme/client/assets/images/talent-dot/talent-dot-2.png') }}"
                                alt="Hình ảnh">
                            Nhân Viên & Freelancer
                        </li>

                        <li>
                            <img src="{{ asset('theme/client/assets/images/talent-dot/talent-dot-3.png') }}"
                                alt="Hình ảnh">
                            Làm Việc Linh Hoạt Tại Văn Phòng
                        </li>
                    </ul>

                    <a href="{{ route('job.list') }}" class="default-btn">
                        Tìm việc làm ngay
                    </a>
                </div>
            </div>

            <div class="col-lg-5 col-md-6">
                <div class="jubi-site-status">
                    <h3 data-cues="slideInUp">Trạng Thái Website Jubi</h3>

                    <div class="site-status">
                        <div class="row" data-cues="slideInUp">
                            <div class="col-lg-6 col-sm-6">
                                <div class="single-counter">
                                    <i class="flaticon-job-seeker"></i>

                                    <h2>
                                        <span class="odometer" data-count="{{ $status['totalJobs'] ?? '' }}">00</span>
                                    </h2>

                                    <p>Công Việc Được Đăng</p>
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-6">
                                <div class="single-counter">
                                    <i class="flaticon-organization"></i>

                                    <h2>
                                        <span class="odometer" data-count="{{ $status['totalEnterprise'] ?? '' }}">00</span>
                                    </h2>

                                    <p>Công Ty</p>
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-6">
                                <div class="single-counter">
                                    <i class="flaticon-profile"></i>

                                    <h2>
                                        <span class="odometer" data-count="{{ $status['totalUser'] ?? '' }}">00</span>
                                    </h2>

                                    <p>Sơ Yếu Lý Lịch</p>
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-6">
                                <div class="single-counter">
                                    <i class="flaticon-community"></i>

                                    <h2>
                                        <span class="odometer" data-count="{{ $status['totalUser'] ?? '' }}">00</span>
                                    </h2>

                                    <p>Thành Viên</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- End Global Talent Area -->

<!-- Start Testimonials Area -->
<section class="testimonials-area bg-color pb-100">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="testimonials-img" data-cues="slideInUp">
                    <img src="{{ asset('theme/client/assets/images/testimonials/testimonials-img.png') }}"
                        alt="Hình ảnh">

                    <h3>Nhận xét</h3>

                    <div class="testimonials-1">
                        <img src="{{ asset('theme/client/assets/images/testimonials/testimonials-1.jpg') }}"
                            alt="Hình ảnh">
                    </div>

                    <div class="testimonials-2">
                        <img src="{{ asset('theme/client/assets/images/testimonials/testimonials-2.jpg') }}"
                            alt="Hình ảnh">
                    </div>

                    <div class="testimonials-3">
                        <img src="{{ asset('theme/client/assets/images/testimonials/testimonials-3.jpg') }}"
                            alt="Hình ảnh">
                    </div>

                    <div class="testimonials-4">
                        <img src="{{ asset('theme/client/assets/images/testimonials/testimonials-4.jpg') }}"
                            alt="Hình ảnh">
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="testimonials">
                    <div class="testimonials-slider owl-carousel owl-theme" data-cues="slideInUp">
                        <div class="testimonials-item">
                            <i class="flaticon-quote"></i>
                            <p>“Dịch vụ của họ thực sự rất tuyệt vời. Tôi đã nhận được sự hỗ trợ kịp thời và hiệu quả. Đội ngũ luôn sẵn sàng giúp đỡ và giải quyết mọi thắc mắc của tôi.”</p>

                            <h3>Allan Norris</h3>
                            <span>Kỹ sư phần mềm</span>
                        </div>

                        <div class="testimonials-item">
                            <i class="flaticon-quote"></i>
                            <p>“Tôi rất ấn tượng với chất lượng sản phẩm và dịch vụ mà công ty mang lại. Đội ngũ làm việc rất chuyên nghiệp và tận tâm. Chắc chắn tôi sẽ tiếp tục hợp tác.”</p>

                            <h3>Tammie King</h3>
                            <span>Người sáng lập</span>
                        </div>

                        <div class="testimonials-item">
                            <i class="flaticon-quote"></i>
                            <p>“Chất lượng sản phẩm vượt ngoài mong đợi của tôi. Công ty đã giúp tôi tìm ra giải pháp phù hợp cho doanh nghiệp của mình, mang lại hiệu quả cao trong công việc.”</p>

                            <h3>Juhon Anderson</h3>
                            <span>Quản lý</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- End Testimonials Area -->

<!-- Start FAQ Area -->
<section class="faq-area bg-color ptb-100">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="faq-accordion">
                    <div class="faq-title" data-cues="slideInUp">
                        <h2>Câu hỏi thường gặp</h2>
                    </div>

                    <ul class="accordion" data-cues="slideInUp">
                        <li class="accordion-item">
                            <a class="accordion-title active" href="javascript:void(0)">
                                <i class="bx bx-plus"></i>
                                Làm thế nào để đăng một công việc?
                            </a>

                            <div class="accordion-content show">
                                <p>Cách thức đăng công việc trên trang web của chúng tôi rất đơn giản. Bạn chỉ cần đăng nhập vào tài khoản của mình, sau đó vào phần "Đăng công việc" và điền đầy đủ thông tin về vị trí, yêu cầu công việc và quyền lợi của ứng viên. Sau khi hoàn thành, chỉ cần nhấn "Đăng" để bài viết của bạn xuất hiện trên hệ thống.</p>
                            </div>
                        </li>

                        <li class="accordion-item">
                            <a class="accordion-title" href="javascript:void(0)">
                                <i class="bx bx-plus"></i>
                                Làm thế nào để chỉnh sửa hoặc xóa một bài đăng công việc?
                            </a>

                            <div class="accordion-content">
                                <p>Để chỉnh sửa hoặc xóa một bài đăng công việc, bạn cần vào mục "Quản lý công việc" trong tài khoản của mình. Tại đây, bạn có thể chọn bài đăng muốn chỉnh sửa hoặc xóa. Sau khi chỉnh sửa xong, nhớ lưu lại thay đổi. Nếu muốn xóa bài đăng, chỉ cần nhấn vào nút "Xóa".</p>
                            </div>
                        </li>

                        <li class="accordion-item">
                            <a class="accordion-title" href="javascript:void(0)">
                                <i class="bx bx-plus"></i>
                                Bài đăng công việc của tôi sẽ được hiển thị trong bao lâu?
                            </a>

                            <div class="accordion-content">
                                <p>Bài đăng công việc của bạn sẽ được hiển thị trong vòng 30 ngày kể từ khi đăng. Sau thời gian này, bài đăng sẽ tự động hết hạn và không còn xuất hiện trên hệ thống nữa. Tuy nhiên, bạn có thể gia hạn thời gian hiển thị nếu cần thiết.</p>
                            </div>
                        </li>

                        <li class="accordion-item">
                            <a class="accordion-title" href="javascript:void(0)">
                                <i class="bx bx-plus"></i>
                                Làm thế nào để hủy đăng ký nhận thông báo từ danh sách email của bạn?
                            </a>

                            <div class="accordion-content">
                                <p>Để hủy đăng ký nhận thông báo từ danh sách email của chúng tôi, bạn chỉ cần nhấn vào liên kết "Hủy đăng ký" có trong mỗi email mà bạn nhận được. Sau khi nhấn vào liên kết này, bạn sẽ không còn nhận được bất kỳ thông báo nào từ chúng tôi nữa.</p>
                            </div>
                        </li>

                        <li class="accordion-item">
                            <a class="accordion-title" href="javascript:void(0)">
                                <i class="bx bx-plus"></i>
                                Làm thế nào để thay đổi mật khẩu của tôi?
                            </a>

                            <div class="accordion-content">
                                <p>Để thay đổi mật khẩu của bạn, hãy truy cập vào phần "Cài đặt tài khoản" trong trang cá nhân. Tại đây, bạn sẽ thấy tùy chọn để thay đổi mật khẩu. Chỉ cần điền mật khẩu cũ và mật khẩu mới, sau đó nhấn "Lưu" để hoàn tất việc thay đổi mật khẩu.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="faq-img" data-cues="slideInUp">
                    <img src="{{ asset('theme/client/assets/images/faq-img.png') }}" alt="Image">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- End FAQ Area -->

<!-- Start Subscribe Area -->
<section class="subscribe-area">
    <div class="container">
        <div class="subscribe-bg">
            <div class="row align-items-center" data-cues="slideInUp">
                <div class="col-lg-6">
                    <div class="subscribe-content">
                        <h2>Tìm Cơ Hội Việc Làm Tuyệt Vời Tiếp Theo Của Bạn!</h2>
                    </div>
                </div>

                <div class="col-lg-6">
                    <form class="newsletter-form" data-toggle="validator">
                        <input type="email" class="form-control" placeholder="Nhập địa chỉ email" name="EMAIL"
                            required autocomplete="off">

                        <button class="default-btn" type="submit">
                            <span>Đăng Ký</span>
                        </button>

                        <div id="validator-newsletter" class="form-result"></div>
                        <p>Tham Gia Bản Tin Cùng 10.000 Người Dùng Đã Tham Gia!</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- End Subscribe Area -->
@endsection