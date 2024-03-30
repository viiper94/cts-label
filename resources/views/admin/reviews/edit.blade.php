<div class="modal-body">
    <div class="form-group mb-3">
        <label class="form-label">@lang('reviews.author'):</label>
        <input type="text" class="form-control form-dark" name="author" value="{{ $review->author }}" data-url="{{ route('reviews.search') }}">
    </div>
    <div class="form-group mb-3 location-form-group">
        <label class="form-label">@lang('reviews.location'):</label>
        <input type="text" class="form-control form-dark" name="location" value="{{ $review->location }}">
    </div>
    <div class="form-group mb-3">
        <label class="form-label">@lang('reviews.review'):</label>
        <textarea class="form-control form-dark" name="review" required>{{ $review->review }}</textarea>
    </div>
    <div class="scores">
        <input class="star-rating" type="text" name="score" value="{{ $review->score }}">
    </div>
    <div class="form-group my-3">
        <label class="form-label">@lang('reviews.source'):</label>
        <input type="text" class="form-control form-dark" name="source" value="{{ $review->source }}">
    </div>
</div>
<div class="modal-footer">
    <input type="hidden" name="track_id" value="">
    @if($review->id)
        <button type="button" class="btn btn-outline-danger save-review" data-url="{{ route('reviews.destroy', $review->id) }}"
            data-method="delete">
            <i class="fa-solid fa-trash me-2"></i>@lang('shared.admin.delete')
        </button>
    @endif
    <button type="button" class="btn btn-primary save-review" data-url="{{ $review->id ? route('reviews.update', $review->id) : route('reviews.store') }}"
            data-method="{{ $review->id ? 'put' : 'post' }}">
        <i class="fa-solid fa-check me-2"></i>@lang('shared.admin.save')
    </button>
</div>
