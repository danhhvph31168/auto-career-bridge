<div class="pagination-area">
    @if ($universities->currentPage() > 1)
        <a href="{{ $universities->previousPageUrl() }}" class="previous page-numbers">
            <i class="flaticon-left-arrow"></i>
        </a>
    @endif

    @for ($i = 1; $i <= $universities->lastPage(); $i++)
        @if (
            $i <= 1 ||
                $i > $universities->lastPage() - 1 ||
                ($i >= $universities->currentPage() - 1 && $i <= $universities->currentPage() + 1))
            @if ($universities->currentPage() == $i)
                <span class="page-numbers current"
                    aria-current="page">{{ $universities->currentPage() }}</span>
            @else
                <a href="{{ $universities->url($i) }}" class="page-numbers">{{ $i }}</a>
            @endif
        @elseif ($i == 2 || $i == $universities->lastPage() - 1)
            <span class="page-numbers">...</span>
        @endif
    @endfor

    @if ($universities->hasMorePages())
        <a href="{{ $universities->nextPageUrl() }}" class="next page-numbers">
            <i class="flaticon-right-arrow"></i>
        </a>
    @endif
</div>
