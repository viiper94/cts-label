<div class="reviews">
    <div class="table-responsive" data-fl-scroll>
        <table class="table table-hover table-borderless table-dark">
            <thead>
            <tr>
                <th colspan="4">Ревью:</th>
                <th class="py-1 text-end">
                    <button class="btn btn-sm btn-outline-primary edit-review" data-url="{{ route('reviews.create') }}" data-track-id="{{ $track->id }}">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </th>
            </tr>
            </thead>
            <tbody class="text-nowrap sortable" data-url="{{ route('reviews.resort') }}">
            @forelse($track->reviews as $review)
                <tr data-review-id="{{ $review->id }}">
                    <td class="sort-handle text-muted"><i class="fa-solid fa-grip-vertical"></i></td>
                    <td class="review-author" title="{{ $review->author }} ({{ $review->location }})">
                        {{ $review->author }} <span class="text-muted">({{ $review->location }})</span>
                    </td>
                    <td class="review-text" title="{{ $review->review }}"><i>{{ $review->review }}</i></td>
                    <td class="review-score">
                        @for($i = 0; $i < $review->score; $i++)
                            <i class="bi bi-star-fill text-primary"></i>
                        @endfor
                    </td>
                    <td class="review-btns py-1 text-end">
                        <button class="btn btn-sm btn-outline edit-review" data-url="{{ route('reviews.edit', $review->id) }}" data-track-id="{{ $track->id }}">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">Еще нет ревью</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="also-supported mt-3">
    <div class="table-responsive" data-fl-scroll>
        <table class="table table-hover table-borderless table-dark">
            <thead>
            <tr>
                <th colspan="2">Also Supported:</th>
                <th class="py-1 text-end">
                    <button class="btn btn-sm btn-outline-primary edit-review" data-url="{{ route('reviews.create') }}" data-track-id="{{ $track->id }}">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </th>
            </tr>
            </thead>
            <tbody class="text-nowrap sortable" data-url="{{ route('reviews.resort') }}">
            @forelse($track->also_supported as $review)
                <tr data-review-id="{{ $review->id }}">
                    <td class="sort-handle text-muted"><i class="fa-solid fa-grip-vertical"></i></td>
                    <td class="also-review-author" title="{{ $review->author }} ({{ $review->location }})">
                        {{ $review->author }} <span class="text-muted">({{ $review->location }})</span>
                    </td>
                    <td class="review-btns py-1 text-end">
                        <button class="btn btn-sm btn-outline edit-review" data-url="{{ route('reviews.edit', $review->id) }}" data-track-id="{{ $track->id }}">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3">Еще нет ревью</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
