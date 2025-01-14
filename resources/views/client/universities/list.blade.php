@extends('client.layouts.master')

@section('content')
    <div class="page-title-area">
        <div class="container">
            <div class="page-title-content">
                <h2>Danh Sách Trường Học</h2>
                <ul>
                    <li>
                        <a href="#">
                            Trang chủ
                        </a>
                    </li>
                    <li class="active">Danh Sách Trường Học</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="employers-listing-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <ul class="shorting-menu">
                        <li class="filter" data-filter="all">Tất cả</li>

                        <span class="text-primary">|</span>

                        <li class="filter" data-filter="d">Đại học</li>

                        <li class="filter" data-filter="c">Cao đẳng</li>

                        <li class="filter" data-filter="h">Học viện</li>

                        @if (isset(Auth::user()->enterprise))
                            <span class="text-primary">|</span>

                            <li class="filter" data-filter="da-hop-tac">Đã hợp tác</li>

                            <li class="filter" data-filter="cho-phan-hoi">Chờ phản hồi</li>

                            <li class="filter" data-filter="chua-hop-tac">Chưa hợp tác</li>
                        @endif

                    </ul>

                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <select name="marjor_university" id="major_university">
                                <option value="">Chuyên ngành</option>
                                @foreach ($majors as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="show-page">
                                <p>Số lượng bản ghi</p>
                                <select id="perPage">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="list-university">
                        @include('client.universities.partials.universities_list', [
                            'universities' => $universities,
                        ])
                    </div>
                    <div id="pagination">
                        @include('client.universities.partials.pagination', [
                            'universities' => $universities,
                        ])
                    </div>

                </div>

                <div class="col-lg-4">
                    <div class="employers-listing-sidebar">
                        <h3>Tìm kiếm trường học</h3>

                        <form class="search-form">
                            <div class="form-group">
                                <div class="search-box">
                                    <input id="search_name" class="form-control" name="search" placeholder="Tìm kiếm..."
                                        type="text">
                                    <div class="search-button">
                                        <i class="bx bx-search"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <select class="province form-control" name="" id="province">
                                </select>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js"
        integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('assets/client/js/ajaxUniversity.js') }}"></script>

    <style>
        .province.form-control {
            display: block !important;
        }

        div.nice-select.province.form-control {
            display: none !important;
        }
    </style>
@endsection
