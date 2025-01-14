@foreach ($universities as $item)
    <div
        class="col-12 mix
        {{ \Str::lower(\Str::substr($item->name, 0, 1)) }}
         @if (isset(Auth::user()->enterprise)) {{ Auth::user()->enterprise->universities()->wherePivot('status', 1)->get()->contains($item) ? 'da-hop-tac' : '' }}
        {{ Auth::user()->enterprise->universities()->wherePivot('status', 0)->get()->contains($item) ? 'cho-phan-hoi' : '' }}
        {{ !(
            Auth::user()->enterprise->universities()->wherePivot('status', 1)->get()->contains($item) ||
            Auth::user()->enterprise->universities()->wherePivot('status', 0)->get()->contains($item)
        )
            ? 'chua-hop-tac'
            : '' }} @endif
        ">
        <div class="hot-jobs-list">
            <div class="row align-items-center">
                <div class="col-lg-2">
                    <a href="{{ route('universities.show', ['slug' => str_replace(' ', '-', $item->name)]) }}"
                        class="hot-jobs-img">
                        @if (!empty($item->logo) && filter_var($item->logo, FILTER_VALIDATE_URL))
                            <img src="{{ $item->logo }}" width="50px" alt="logo">
                        @elseif (!empty($item->logo) && Storage::exists($item->logo))
                            <img src="{{ Storage::url($item->logo) }}" width="60px" alt="logo">
                        @else
                            <img src="https://placehold.co/50" width="50px" alt="Default logo">
                        @endif

                    </a>
                </div>
                <div class="col-lg-7">
                    <div class="hot-jobs-content">
                        <h3><a
                                href="{{ route('universities.show', ['slug' => str_replace(' ', '-', $item->name)]) }}">{{ $item->name }}</a>
                        </h3>
                        <span
                            class="sub-title">{{ \Str::limit($item->introduce, 95) ?? \Str::limit($item->description, 100) }}</span>
                        <ul>
                            <li><span>Địa chỉ:</span> {{ $item->address }}</li>
                            <li><span>Email: </span> {{ $item->email }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3" style="margin-top: 13%">
                    <span class="open-job mb-3">Hợp tác: {{ $item->numberCooperate }}</span>
                    <a href="{{ route('universities.show', ['slug' => str_replace(' ', '-', $item->name)]) }}"
                        class="btn btn-primary float-end">Chi tiết</a>
                </div>
            </div>
            @if (isset(Auth::user()->enterprise))
                @if (Auth::user()->enterprise->universities()->wherePivot('status', 1)->get()->contains($item))
                    <span class="featured">Đã hợp tác</span>
                @elseif(Auth::user()->enterprise->universities()->wherePivot('status', 0)->get()->contains($item))
                    <span class="featured">Chờ phản hồi</span>
                @else
                    <span class="featured bg-secondary">Chưa hợp tác</span>
                @endif
            @endif
        </div>
    </div>
@endforeach
