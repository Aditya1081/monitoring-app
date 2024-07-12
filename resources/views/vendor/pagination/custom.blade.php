<!-- resources/views/vendor/pagination/custom.blade.php -->
@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>&laquo;</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @php
                    $current = $paginator->currentPage();
                    $last = $paginator->lastPage();
                @endphp
                @foreach ($element as $page => $url)
                    {{-- Always show first, last, and pages around the current page --}}
                    @if ($page == 1 || $page == $last || ($page >= $current - 1 && $page <= $current + 1))
                        @if ($page == $paginator->currentPage())
                            <li class="active"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @elseif ($page == 2 && $current > 3)
                        <li class="disabled"><span>...</span></li>
                    @elseif ($page == $last - 1 && $current < $last - 2)
                        <li class="disabled"><span>...</span></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="disabled"><span>&raquo;</span></li>
        @endif
    </ul>
@endif

<style>
    .pagination-container {
        border: 1px solid rgb(24, 23, 23);
        padding: 10px;
        border-radius: 4px;
        display: inline-block;
    }

    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        justify-content: center;
    }

    .pagination li {
        margin: 0 5px;
    }

    .pagination li a,
    .pagination li span {
        padding: 5px 10px;
        text-decoration: none;
        color: #333;
        transition: background-color 0.3s, color 0.3s;
        border: none;
    }

    .pagination li a:hover {
        background-color: #f5f5f5;
        color: #007bff;
    }

    .pagination li.active span {
        background-color: #007bff;
        color: white;
    }

    .pagination li.disabled span {
        color: #999;
        cursor: not-allowed;
    }
</style>
