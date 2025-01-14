<div data-simplebar style="max-height: 300px;" class="pe-2">
    @foreach ($notifications as $item)
        <div class="text-reset notification-item d-block dropdown-item position-relative">
            <div class="d-flex">
                @if (Auth::user()->university_id == null && Auth::user()->user_type == TYPE_ENTERPRISE && $item->sender->user_type == TYPE_UNIVERSITY)
                    <img src="{{ asset('assets/image/th.png') }}"
                        class="me-3 rounded-circle avatar-xs flex-shrink-0">
                @endif

                @if (Auth::user()->enterprise_id == null && Auth::user()->user_type == TYPE_UNIVERSITY && $item->sender->user_type == TYPE_ENTERPRISE)
                    <img src="{{ asset('assets/image/dn.jpg') }}"
                        class="me-3 rounded-circle avatar-xs flex-shrink-0">
                @endif

                @if ($item->sender->user_type == TYPE_ADMIN)
                    <img src="{{ asset('assets/image/avatar.png') }}"
                        class="me-3 rounded-circle avatar-xs flex-shrink-0">
                @endif

                <div class="flex-grow-1">
                    <a href="{{ route('admin.notifications.show', $item) }}" class="stretched-link">
                        <h6
                            class="mt-0 mb-1 fs-13 fw-semibold
                        {{ $item->is_read == UN_READ ? 'text-info' : 'text-gray' }}">
                            {{ $item->title }}
                        </h6>
                    </a>
                    <div class="fs-13 text-muted">
                        <p class="mb-1">{{ \Str::limit($item->message, 50) }}
                        </p>
                    </div>
                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                        <span><i class="mdi mdi-clock-outline"></i>
                            {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span>
                    </p>
                </div>

                <div class="px-2 fs-15">
                    <div class="form-check notification-check">
                        <input class="form-check-input" type="checkbox" value="{{ $item->id }}"
                            id="all-notification-check{{ $item->id }}">
                        <label class="form-check-label" for="all-notification-check{{ $item->id }}"></label>
                    </div>
                </div>

            </div>
        </div>
    @endforeach
</div>

<div class="my-3 text-center view-all pb-3">
    <a href="{{ route('admin.notifications.index') }}" class="btn btn-soft-primary waves-effect waves-light">Xem tất cả thông báo <i class="ri-arrow-right-line align-middle"></i></a>
</div>
