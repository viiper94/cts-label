<div class="isrc-existed">
    <small class="d-block text-danger mb-0">@lang('tracks.isrc_existed')</small>
    <small class="d-block text-warning mb-2">{{ $track->getFullTitle() }}</small>
    <button class="btn btn-sm btn-outline-secondary add-isrc-to-release" data-track-id="{{ $track->id }}" data-url="{{ route('releases.add_track') }}">
        <i class="fa-solid fa-plus me-2"></i>@lang('tracks.add_to_tracklist')
    </button>
    <p class="text-success added-text" style="display: none">
        <i class="fa-solid fa-check me-2"></i>@lang('tracks.added')!
    </p>
</div>
