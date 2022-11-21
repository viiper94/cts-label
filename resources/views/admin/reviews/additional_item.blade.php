<div class="review-card card text-bg-dark mb-3" id="additional-{{ $key }}">
    <div class="card-body">
        <div class="form-group mb-3">
            <label class="form-label">Автор:</label>
            <input class="form-control form-dark" type="text" name="additional[{{ $key }}][author]" value="{{ $item['author'] }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Локация:</label>
            <input class="form-control form-dark" type="text" name="additional[{{ $key }}][location]" value="{{ $item['location'] }}">
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-sm btn-outline-danger delete-review-btn"><i class="fa-solid fa-trash me-2"></i>Удалить</button>
    </div>
</div>
