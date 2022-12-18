@if ($paginator->hasPages())
    <div class="d-flex justify-content-center">
        <div class="pgn-container">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="prev-btn btn-disabled" aria-hidden="true" aria-label="@lang('pagination.previous')">&nbsp;</span>
            @else
                <a class="prev-btn" href="{{ $paginator->previousPageUrl() }}" aria-label="@lang('pagination.previous')">&nbsp;</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $key => $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="dots">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @continue(count($elements) == 5 && $key === 4 && $loop->iteration === 1)
                        <a class="pgn @if($page == $paginator->currentPage())pgn-selected @endif" href="{{ $url }}">{{ $page }}</a>
                        @break(count($elements) == 5 && $key === 0 && $loop->iteration === 1)
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a class="next-btn" href="{{ $paginator->nextPageUrl() }}" aria-label="@lang('pagination.next')">&nbsp;</a>
            @else
                <span class="next-btn btn-disabled" aria-hidden="true" aria-label="@lang('pagination.next')">&nbsp;</span>
            @endif
        </div>
    </div>
@endif
