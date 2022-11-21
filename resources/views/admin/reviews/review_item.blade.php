<div class="card mb-3 text-bg-dark review-card" id="review-{{ $key }}">
    <div class="card-body">
        <div class="form-group mb-3">
            <label class="form-label">Автор:</label>
            <input type="text" class="form-control form-dark" name="review[{{ $key }}][author]" value="{{ $item['author'] }}" required>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Локация:</label>
            <input type="text" class="form-control form-dark" name="review[{{ $key }}][location]" value="{{ $item['location'] }}">
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Ревью:</label>
            <textarea class="form-control form-dark" name="review[{{ $key }}][review]" required>{{ $item['review'] }}</textarea>
        </div>
        <div class="scores">
            <input class="star-rating" type="text" name="review[{{ $key }}][score]" value="{{ $item['score'] }}">
        </div>
    </div>
    <div class="card-footer justify-content-end">
        <button class="btn btn-sm btn-outline-danger delete-review-btn" type="button"><i class="fa-solid fa-trash me-2"></i>Удалить</button>
    </div>
</div>
