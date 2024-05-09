<div class="modal-header">
    <div class="form-group">
        <select class="form-select text-bg-dark" name="track_id">
            <option selected disabled>@lang('feedback.replies.select_track')</option>
            @foreach($release?->tracks ?? [$track] as $item)
                <option value="{{ $item->id }}" @if($track->id === $item->id) selected @endif>
                    {{ $item->getFullTitle() }}
                </option>
            @endforeach
        </select>
    </div>
    <button type="button" class="btn btn-outline ms-2" data-bs-dismiss="modal"><i class="fa-solid fa-times"></i></button>
</div>
<div class="modal-body">
    <div class="form-group mb-3">
        <label class="form-label">@lang('reviews.author'):</label>
        <input type="text" class="form-control form-dark" name="author" value="{{ $author }}" data-url="{{ route('reviews.search') }}">
    </div>
    <div class="form-group mb-3 location-form-group">
        <label class="form-label">@lang('reviews.location'):</label>
        <input type="text" class="form-control form-dark" name="location">
        @if(count($locations) > 0)
            <div class="author-locations mt-2">
                @foreach($locations as $review)
                    <small><a class="copy-author">{{ $review->author }}</a> - <a class="copy-author-location">{{ $review->location }}</a></small>
                @endforeach
            </div>
        @endif
    </div>
    <div class="form-group mb-3">
        <label class="form-label">@lang('reviews.review'):</label>
        <textarea class="form-control form-dark" name="review" required>{{ $comment }}</textarea>
    </div>
    <div class="scores">
        <input class="star-rating" type="text" name="score" value="{{ $score }}">
    </div>
    <div class="form-group my-3">
        <label class="form-label">@lang('reviews.source'):</label>
        <input type="text" class="form-control form-dark" name="source" value="Feedback">
    </div>
</div>
<div class="modal-footer">
    <input type="hidden" name="result_accept" value="{{ $result->id }}">
    <button type="button" class="btn btn-outline-success mark-accepted-btn" data-confirm="@lang('feedback.replies.are_you_sure')"
            data-action="1" data-url="{{ route('feedback.results.modify', $result->id) }}" data-key="{{ $key }}">
        <i class="fa-solid fa-circle-check me-2"></i>@lang('feedback.replies.mark_accepted')
    </button>
    <button type="button" class="btn btn-outline-danger decline-btn" data-confirm="@lang('feedback.replies.are_you_sure')"
            data-action="2" data-url="{{ route('feedback.results.modify', $result->id) }}" data-key="{{ $key }}">
        <i class="fa-regular fa-circle-xmark"></i>
    </button>
    <button type="button" class="btn btn-primary save-review" data-url="{{ route('reviews.store') }}" data-method="post"
            data-key="{{ $key }}">
        <i class="fa-solid fa-check me-2"></i>@lang('shared.admin.save')
    </button>
</div>
