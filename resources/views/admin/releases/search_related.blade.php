<div class="related d-flex mb-1 form-check-inline">
    <a class="me-4" href="{{ route('release', $item->id) }}" target="_blank">Релиз на сайте</a>
    <input type="checkbox" name="related[]" class="form-check-input me-2" value="{{ $item->id }}"
           id="search-related-{{ $item->id }}" @checked($checked)>
    <label for="search-related-{{ $item->id }}" class="form-check-label">{{ $item->title }}</label>
</div>
