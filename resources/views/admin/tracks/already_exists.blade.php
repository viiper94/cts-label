<div class="isrc-existed">
    <small class="d-block text-danger mb-0">Трек с таким ISRC уже существует</small>
    <small class="d-block text-warning mb-2">{{ $track->getFullTitle() }}</small>
    <button class="btn btn-sm btn-outline-secondary add-isrc-to-release" data-track-id="{{ $track->id }}" data-url="{{ route('releases.add_track') }}">
        <i class="fa-solid fa-plus me-2"></i>Добавить в треклист
    </button>
</div>
