@foreach ($enterprises as $item)
    <div class="col-12 mix {{ \Str::lower(\Str::substr($item->name, 0, 1)) }}">
        <div class="hot-jobs-list">
            <div class="row align-items-center">
                <div class="col-lg-2">
                    <a href="{{ route('enterprises.show', $item->slug) }}" class="hot-jobs-img">
                        <img src="{{ Str::contains($item->logo, 'http') ? $item->logo : Storage::url($item->logo) }}"
                            alt="Image">
                    </a>
                </div>
                <div class="col-lg-6">
                    <div class="hot-jobs-content">
                        <h3><a href="{{ route('enterprises.show', $item->slug) }}">{{ $item->name }}</a>
                        </h3>
                        <ul>
                            <li><span>Ngành:</span> {{ $item->industry }}</li>
                            <li><span>Địa chỉ:</span> {{ $item->address }}</li>
                            <li><span>Email: </span> {{ $item->email }}</li>
                            <li><span>Số nhân viên: </span> {{ $item->size }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4" style="margin-top: 13%">
                    <div class="hot-jobs-btn">
                        <a href="{{ route('enterprises.show', $item->slug) }}" class="default-btn">Xem chi tiết</a>
                        <p><span>Ngày tạo: {{ date('d/m/Y', strtotime($item->created_at)) }}</span></p>
                    </div>
                </div>
            </div>
            <span class="featured">Hợp tác</span>
        </div>
    </div>
@endforeach
