<div>
    @if (isset($jobs) && !empty($jobs) && $jobs->total() != 0)
        @foreach ($jobs as $job)
            <div class="hot-jobs-list">
                <div class="row align-items-center">
                    <div class="col-lg-2">
                        <a href="{{ route('job.detail', $job->id) }}" class="hot-jobs-img">
                            <img src="{{ $job->enterprises->logo ? Storage::url($job->enterprises->logo) : asset('theme/client/assets/images/partner/partner-5.png') }}"
                                alt="Image">
                        </a>
                    </div>

                    <div class="col-lg-6">
                        <div class="hot-jobs-content">
                            <h3><a
                                    href="{{ route('job.detail', $job->id) }}">{{ Str::limit($job->title, 30, '...') }}</a>
                            </h3>
                            <ul>
                                <li><span>Công ty: </span>{{ $job->enterprises->name }}</li>
                                <li><span>Kinh nghiệm: </span>{{ $job->experience_level }}</li>
                                <li><span>Địa chỉ: </span>{{ $job->address }}</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="hot-jobs-btn">
                            <a href="{{ route('job.detail', $job->id) }}" class="default-btn">Chi
                                tiết</a>
                            <p><span>Hạn ứng tuyển: </span>{{ \Carbon\Carbon::parse($job->end_date)->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                </div>
                @if (auth()->check() && auth()->user()->university)
                    @if ($job->universities()->where('university_id', auth()->user()->university_id)->exists())
                        <span class="featured">Đã hợp tác</span>
                    @else
                        <span class="featured bg-secondary">Chưa hợp tác</span>
                    @endif
                @endif
            </div>
        @endforeach
        @if ($jobs->hasPages())
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="pagination-area">
                        <button class="next page-numbers" wire:click="previousPage"
                            {{ $jobs->onFirstPage() ? 'hidden' : '' }}>
                            <i class="flaticon-left-arrow"></i>
                        </button>
                        @for ($i = 1; $i <= $jobs->lastPage(); $i++)
                            <button wire:click="setPage({{ $i }})"
                                class="page-numbers {{ $jobs->currentPage() == $i ? 'current' : '' }}">{{ $i }}</button>
                        @endfor
                        <button wire:click="nextPage" class="next page-numbers"
                            {{ $jobs->onLastPage() ? 'hidden' : '' }}>
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
