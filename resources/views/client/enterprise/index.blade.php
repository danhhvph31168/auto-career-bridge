@extends('client.layouts.master')

@section('content')
    <style>
        .province.form-control {
            display: block !important;
        }

        div.nice-select.province.form-control {
            display: none !important;
        }

        .nice-select .list {
            height: auto;
        }
    </style>

    <div class="page-title-area">
        <div class="container">
            <div class="page-title-content">
                <h2>{{ config('apps.clients.enterprises.index.title') }}</h2>
                <ul>
                    <li>
                        <a href="{{ route('home') }}">
                            {{ config('apps.clients.enterprises.home') }}
                        </a>
                    </li>
                    <li class="active">{{ config('apps.clients.enterprises.title') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="employers-listing-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    {{-- <ul class="shorting-menu">
                        <li class="filter" data-filter="all">
                            All
                        </li>

                        <li class="filter" data-filter="d">
                            University
                        </li>

                        <li class="filter" data-filter="c">
                            College
                        </li>

                        <li class="filter" data-filter="h">
                            Academy
                        </li>
                    </ul> --}}

                    <div class="row">
                        <div class="show-page me-auto">
                            <p>Số lượng bản ghi:</p>
                            <select id="perPage">
                                <option value="1">05</option>
                                <option value="3">10</option>
                                <option value="4">15</option>
                                <option value="5">20</option>
                                
                            </select>
                        </div>
                    </div>

                    <div id="list_enterprise">
                        @if ($enterprises->isNotEmpty())
                            @include('client.enterprise.components.enterprise_list', [
                                'enterprises' => $enterprises,
                            ])
                        @else
                            <h3 class="text-center">Không có kết quả</h3>
                        @endif
                    </div>
                    <div id="pagination">
                        @include('client.enterprise.components.pagination', [
                            'enterprises' => $enterprises,
                        ])
                    </div>

                </div>

                <div class="col-lg-4">
                    <div class="employers-listing-sidebar">
                        <h3>Tìm kiếm</h3>

                        <form class="search-form">
                            <div class="form-group">
                                <div class="search-box">
                                    <input id="input_search" class="form-control" placeholder="Tìm kiếm" type="text">
                                    <div class="search-button" style="cursor: pointer">
                                        <i class="bx bx-search"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <select class="province form-control" id="province">
                                </select>
                            </div>
                            <button class="default-btn w-100 clear_search">Xóa tìm kiếm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        let totalPage = +`{{ $enterprises->lastPage() }}`
        let currentPage = +`{{ $enterprises->currentPage() }}`
        let perPage = +`{{ $enterprises->perPage() }}`
        let province = ''
        let keyword = ''

        const callAPI = async (url) => {
            try {
                const response = await fetch(url);
                if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                }

                const data = await response.json();

                renderData(data)
            } catch (error) {
                console.error(error.message);
            }
        }

        callAPI('https://provinces.open-api.vn/api/?depth=1');

        const renderData = (array) => {
            let row = ` <option disable value=''>Địa chỉ</option>`;
            array.forEach(element => {
                row += `<option value="${element.name}">${element.name}</option>`
            });
            document.querySelector("#province").innerHTML = row
        }

        $(document).ready(function() {
            $(document).on('change', '#province', function() {
                const province_raw = $(this).val();
                currentPage = 1;

                if (province_raw.includes('Thành phố')) {
                    province = province_raw.replace('Thành phố ', '')
                } else {
                    province = province_raw.replace('Tỉnh ', '')
                }

                getUniversitisApi();
            });

            const renderPaginate = (totalPage, currentPage) => {
                let html = ''

                if (currentPage > 1) {
                    html += `<button class="page-numbers pages prev" data-page="${currentPage - 1}">
                                <i class="flaticon-left-arrow"></i>
                            </button>`;
                } else {
                    html += `<span class="page-numbers" >
                                <i class="flaticon-left-arrow"></i>
                            </span>`;
                }

                for (let page = 1; page <= totalPage; page++) {
                    if (page == currentPage) {
                        html += `<span class="page-numbers current" aria-current="page">${page}</span>`;
                    } else {
                        html += `<button class="page-numbers pages" data-page="${page}">${page}</button>`;
                    }
                }

                if (currentPage < totalPage) {
                    html += `<button class="page-numbers pages next" data-page="${currentPage + 1}">
                                <i class="flaticon-right-arrow"></i>
                            </button>`;
                } else {
                    html += `<span class="page-numbers" >
                                <i class="flaticon-right-arrow"></i>
                            </span>`;
                }

                $('.paginate').html(html)
            }

            renderPaginate(totalPage, currentPage)

            $(document).on('click', '.pages', function() {
                currentPage = $(this).data('page');

                getUniversitisApi();
            })

            const getUniversitisApi = () => {
                $.ajax({
                    url: `{{ route('enterprises.index') }}?page=${currentPage}&perPage=${perPage}&province=${province}&keyword=${keyword}`,
                    dataType: "json",
                    method: 'GET',
                    success: function(res) {
                        if (res.data.length == 0) {
                            $('#list_enterprise').html(
                                '<h3 class="text-center">Không có kết quả</h3>');

                            $('.paginate').html('')

                            return;
                        }

                        renderPaginate(res.last_page, res.current_page)

                        let html = ''
                        $.each(res.data, function(index, item) {
                            const date = new Date(item.created_at);
                            const formattedDate = (date.getDate() < 10 ? '0' : '') + date
                                .getDate() + '/' +
                                (date.getMonth() + 1 < 10 ? '0' : '') + (date.getMonth() +
                                    1) + '/' +
                                date.getFullYear();

                            let logo = `{{ Storage::url('${item.logo}') }}`
                            if (item.logo.includes('http')) logo = item.logo

                            html += /*html*/ `
                            <div class="col-12 mix ">
                                <div class="hot-jobs-list">
                                    <div class="row align-items-center">
                                        <div class="col-lg-2">
                                            <a href="{{ route('enterprises.show', '') }}/${item.slug}" class="hot-jobs-img">
                                                <img src="${logo}"
                                                    alt="Image">
                                            </a>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="hot-jobs-content">
                                                <h3><a href="{{ route('enterprises.show', '') }}/${item.slug}">${item.name}</a>
                                                </h3>
                                                <ul>
                                                    <li><span>Ngành:</span> ${item.industry} </li>
                                                    <li><span>Địa chỉ:</span> ${item.address} </li>
                                                    <li><span>Email: </span> ${item.email} </li>
                                                    <li><span>Số nhân viên: </span> ${item.size}</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-lg-4" style="margin-top: 13%">
                                            <div class="hot-jobs-btn">
                                                <a href="{{ route('enterprises.show', '') }}/${item.slug}" class="default-btn">Xem chi tiết</a>
                                                <p><span>Ngày tạo: ${formattedDate}</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="featured">Hợp tác</span>
                                </div>
                            </div>
                            `
                        });

                        $('#list_enterprise').html(html);

                    }
                });
            }

            $(document).on('click', '.nice-select ul li', function() {
                if (perPage == $(this).data('value')) return
                perPage = $(this).data('value')
                currentPage = 1;

                getUniversitisApi()
            });

            $(document).on('submit', '.search-form', function(event) {
                event.preventDefault()
            });

            $(document).on('click', '.search-button', function() {
                keyword = $('#input_search').val()
                currentPage = 1;

                getUniversitisApi()
            });

            $(document).on('keydown', '#input_search', function(event) {
                if (event.key !== 'Enter') return
                event.preventDefault();

                keyword = $('#input_search').val()
                currentPage = 1;

                getUniversitisApi()
            });

            $(document).on('click', '.clear_search', function() {
                keyword = ''
                province = ''
                currentPage = 1;
                $('#input_search').val('')
                $('#province').val('');

                getUniversitisApi()
            });

        });
    </script>
@endsection
