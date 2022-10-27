@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination pagination-dark pagination-sm mb-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link"><i class="fa-solid fa-angles-left"></i></a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="@lang('pagination.previous')">
                        <i class="fa-solid fa-angles-left"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $key => $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled"><a class="page-link">{{ $element }}</a></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @continue(count($elements) == 5 && $key === 4 && $loop->iteration === 1)
                        <li @class(['page-item', 'active disabled' => $page == $paginator->currentPage()])>
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                        @break(count($elements) == 5 && $key === 0 && $loop->iteration === 1)
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="@lang('pagination.next')">
                        <i class="fa-solid fa-angles-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link"><i class="fa-solid fa-angles-right"></i></a>
                </li>
            @endif
        </ul>
    </nav>
@endif
