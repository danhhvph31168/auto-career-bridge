<div>
    <section class="job-listing-area ptb-100">
        <div class="container ">
            <div class="row">
                <div class="col-lg-8">
                    <div>
                        <div class="search-job">
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="job-title" name="keyword"
                                            wire:model="keyword" placeholder="Vị trí tuyển dụng, tên công ty">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="address" wire:ignore>
                                        <select id="province" class="province list-option">
                                            <option value="">Tỉnh thành phố</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <button type="button" class="default-btn" wire:click="getDataSearch">
                                        <i class="bx bx-search"></i>
                                        Tìm kiếm
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="time-and-hour">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="rated" wire:ignore>
                                        <select name="major" wire:model="major" wire:change="getDataSearch"
                                            id="major-select">
                                            <option value="">Lĩnh vực</option>
                                            @if (isset($majors) && !empty($majors))
                                                @foreach ($majors as $major)
                                                    <option value="{{ $major->id }}">
                                                        {{ $major->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="show-page" wire:ignore>
                                        <p>Số lượng bản ghi</p>
                                        <select name="perpage" wire:model="perpage" id="perpage-select"
                                            wire:change="getDataSearch">
                                            @for ($i = 5; $i <= 50; $i += 10)
                                                <option value="{{ $i }}"
                                                    {{ request()->perpage == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div>
                        @if (isset($workshops) && !empty($workshops) && $workshops->total() != 0)
                            @foreach ($workshops as $workshop)
                                <div class="hot-jobs-list">
                                    <div class="row align-items-center">
                                        <div class="col-lg-2">
                                            <a href="job-details.html" class="hot-jobs-img">
                                                <img src="{{ $workshop->university->logo ? Storage::url($workshop->university->logo) : asset('theme/client/assets/images/partner/partner-5.png') }}"
                                                    alt="Image">
                                            </a>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="hot-jobs-content">
                                                <h3><a href="job-details.html">{{ $workshop->title }}</a></h3>
                                                <span class="sub-title">{{ $workshop->university->name }}</span>
                                                <ul>
                                                    <li><span>Địa chỉ: </span>{{ $workshop->address }}</li>
                                                    <li><span>Số lượng: </span>{{ $workshop->applicants }}</li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="hot-jobs-btn">
                                                <a href="{{ route('workshop.detail', $workshop->id) }}"
                                                    class="default-btn">Chi
                                                    tiết</a>
                                                <p><span>Hạn ứng tuyển: </span>{{ $workshop->end_date }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @if (auth()->check() && auth()->user()->enterprise)
                                        @if ($workshop->enterprises()->where('enterprise_id', auth()->user()->enterprise)->exists())
                                            <span class="featured">Đã hợp tác</span>
                                        @else
                                            <span class="featured bg-secondary">Chưa hợp tác</span>
                                        @endif
                                    @endif
                                </div>
                            @endforeach
                            @if ($workshops->hasPages())
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="pagination-area">
                                            <button class="next page-numbers" wire:click="previousPage"
                                                {{ $workshops->onFirstPage() ? 'hidden' : '' }}>
                                                <i class="flaticon-left-arrow"></i>
                                            </button>
                                            @for ($i = 1; $i <= $workshops->lastPage(); $i++)
                                                <button wire:click="setPage({{ $i }})"
                                                    class="page-numbers {{ $workshops->currentPage() == $i ? 'current' : '' }}">{{ $i }}</button>
                                            @endfor
                                            <button wire:click="nextPage" class="next page-numbers"
                                                {{ $workshops->onLastPage() ? 'hidden' : '' }}>
                                                <i class="flaticon-right-arrow"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <h3 class="text-center">Không có dữ liệu</h3>
                        @endif
                    </div>

                </div>
                <div class="col-lg-4">
                    <div class="job-listing-sidebar">
                        <div class="job-listing-widget">
                            <ul class="accordion-widget">
                                <li class="accordion-item">
                                    <a class="accordion-widget-title active" href="javascript:void(0)">
                                        <h3>Thời gian diễn ra</h3>
                                        <i class="bx bx-chevron-down"></i>
                                    </a>

                                    <form class="search-form">
                                        <div class="form-group">
                                            <div class="search-box mb-3">
                                                <div class="mb-2">
                                                    Ngày bắt đầu
                                                </div>
                                                <input id="search_name" class="form-control" name="search"
                                                    wire:model="start_date" placeholder="Tìm kiếm..." type="date"
                                                    wire:change="getDataSearch">
                                            </div>
                                            <div class="search-box">
                                                <div class="mb-2">
                                                    Ngày kết thúc
                                                </div>
                                                <input id="search_name" class="form-control" name="search"
                                                    wire:model="end_date" placeholder="Tìm kiếm..." type="date"
                                                    wire:change="getDataSearch">
                                            </div>
                                        </div>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </section>
    <style>
        .address .nice-select {
            width: 100% !important;
            border-radius: 0;
            /* border-color: #ccc; */
            box-shadow: 0px 5px 20px 3px rgba(230, 233, 249, .9);
            padding: 10px 20px;
            font-size: 16px;
            height: 50px !important;
        }

        .address .nice-select .current {
            position: relative;
            top: -6px;
        }

        .nice-select::after {
            width: 7px !important;
            height: 7px !important;
        }
    </style>
</div>
