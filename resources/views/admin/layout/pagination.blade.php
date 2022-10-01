@if ($paginator->hasPages())
    <div class="text-center">
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm pagination__dark">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li>
                        <a><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></a>
                    </li>
                @else
                    <li>
                        <a class="prev-btn" href="{{ $paginator->previousPageUrl() }}" aria-label="@lang('pagination.previous')">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $key => $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li><span>{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @continue(count($elements) == 5 && $key === 4 && $loop->iteration === 1)
                            <li><a class="pgn @if($page == $paginator->currentPage())pgn-selected @endif" href="{{ $url }}">{{ $page }}</a></li>
                            @break(count($elements) == 5 && $key === 0 && $loop->iteration === 1)
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li>
                        <a class="next-btn" href="{{ $paginator->nextPageUrl() }}" aria-label="@lang('pagination.next')">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        </a>
                    </li>
                @else
                    <li>
                        <a><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif
