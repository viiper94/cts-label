<div class="modal-content">
    <div class="modal-header">
        <h3 class="modal-title fs-5" id="trackModalLabel">{{ $track->id ? trans('tracks.edit_track') : trans('tracks.new_track') }}</h3>
        <button type="button" class="btn btn-outline" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="modal-body">
        <div class="form-group mb-3">
            <label for="artists" class="form-label">@lang('tracks.artists')* <small class="text-muted">@lang('tracks.list_commas')</small></label>
            @if(session('artists'))
                <a class="add-promt text-muted">{{ session('artists') }}</a>
            @endif
            <input type="text" class="form-control form-dark" id="artists" name="artists" value="{{ $track->artists }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="name" class="form-label">@lang('tracks.title')*</label>
            @if(session('name'))
                <a class="add-promt text-muted">{{ session('name') }}</a>
            @endif
            <input type="text" class="form-control form-dark" id="name" name="name" value="{{ $track->name }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="mix_name" class="form-label">@lang('tracks.mix_name')</label>
            @if(session('mix_name'))
                <a class="add-promt text-muted">{{ session('mix_name') }}</a>
            @endif
            <input type="text" class="form-control form-dark" id="mix_name" name="mix_name" value="{{ $track->mix_name }}">
        </div>
        <div class="form-group mb-3">
            <label for="remixers" class="form-label">@lang('tracks.remixers') <small class="text-muted">@lang('tracks.list_commas')</small></label>
            @if(session('remixers'))
                <a class="add-promt text-muted">{{ session('remixers') }}</a>
            @endif
            <input type="text" class="form-control form-dark" id="remixers" name="remixers" value="{{ implode(', ', (array)$track->remixers) }}">
        </div>
        <div class="form-group mb-3">
            <label for="composer" class="form-label">@lang('tracks.composer')</label>
            @if(session('composer'))
                <a class="add-promt text-muted">{{ session('composer') }}</a>
            @endif
            <input type="text" class="form-control form-dark" id="composer" name="composer" value="{{ $track->composer }}">
        </div>
        <div class="form-group mb-3">
            <label for="isrc" class="form-label">@lang('tracks.isrc_code')* <small class="text-muted">@lang('tracks.enter_digits')</small></label>
            <div class="input-group">
                <input type="text" class="form-control form-dark" id="isrc" name="isrc" value="{{ $track->isrc }}" placeholder="UA-CT1-XX-XXXXX"
                    data-url="{{ route('tracks.isrc.check') }}">
                @if(!$track->isrc)
                    <button class="btn btn-outline border-0" type="button" id="isrc-generate" data-url="{{ route('tracks.isrc.get') }}">
                        @lang('tracks.generate')
                    </button>
                @endif
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="genre" class="form-label">@lang('tracks.genre')</label>
            @if(session('genre'))
                <a class="add-promt text-muted">{{ session('genre') }}</a>
            @endif
            <input type="text" class="form-control form-dark" id="genre" name="genre" value="{{ $track->genre }}">
        </div>
        <div class="form-group mb-3">
            <label for="youtube" class="form-label">@lang('tracks.link_to_youtube')</label>
            <div class="input-group">
                <input type="url" class="form-control form-dark" id="youtube" name="youtube" value="{{ $track->youtube }}">
                @if($track->youtube)
                    <a class="btn btn-outline border-0" href="{{ $track->youtube }}" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                @endif
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="bpm" class="form-label">@lang('tracks.bpm')</label>
            @if(session('bpm'))
                <a class="add-promt text-muted">{{ session('bpm') }}</a>
            @endif
            <input type="number" class="form-control form-dark" id="bpm" name="bpm" value="{{ $track->bpm }}">
        </div>
        <div class="form-group mb-3">
            <label for="length" class="form-label">@lang('tracks.length')</label>
            @if(session('length'))
                <a class="add-promt text-muted">{{ session('length') }}</a>
            @endif
            <input type="text" class="form-control form-dark" id="length" name="length" value="{{ $track->length }}" placeholder="xx:xx">
        </div>
        <div class="form-group mb-3">
            <label for="beatport_id" class="form-label">@lang('tracks.beatport_id')</label>
            @if(session('beatport_id'))
                <a class="add-promt text-muted">{{ session('beatport_id') }}</a>
            @endif
            <input type="number" class="form-control form-dark" id="beatport_id" name="beatport_id" value="{{ $track->beatport_id }}">
        </div>
        <div class="form-group mb-3">
            <label for="beatport_slug" class="form-label">@lang('tracks.beatport_slug')</label>
            @if(session('beatport_slug'))
                <a class="add-promt text-muted">{{ session('beatport_slug') }}</a>
            @endif
            <input type="text" class="form-control form-dark" id="beatport_slug" name="beatport_slug" value="{{ $track->beatport_slug }}">
        </div>
        <div class="form-group mb-3">
            <label for="beatport_release_id" class="form-label">@lang('tracks.beatport_release_id')</label>
            @if(session('beatport_release_id'))
                <a class="add-promt text-muted">{{ session('beatport_release_id') }}</a>
            @endif
            <input type="number" class="form-control form-dark" id="beatport_release_id" name="beatport_release_id" value="{{ $track->beatport_release_id }}">
        </div>
        <div class="form-group mb-3">
            <label for="beatport_wave" class="form-label">@lang('tracks.beatport_wave')</label>
            <div class="input-group">
                <input type="url" class="form-control form-dark" id="beatport_wave" name="beatport_wave" value="{{ $track->beatport_wave }}">
                @if($track->beatport_wave)
                    <a class="btn btn-outline border-0" href="{{ $track->beatport_wave }}" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                @endif
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="beatport_sample" class="form-label">@lang('tracks.beatport_sample')</label>
            <div class="input-group">
                <input type="url" class="form-control form-dark" id="beatport_sample" name="beatport_sample" value="{{ $track->beatport_sample }}">
                @if($track->beatport_sample)
                    <a class="btn btn-outline border-0" href="{{ $track->beatport_sample }}" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                @endif
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="beatport_sample_start" class="form-label">@lang('tracks.beatport_sample_start')</label>
            <input type="text" class="form-control form-dark" id="beatport_sample_start" name="beatport_sample_start" value="{{ $track->beatport_sample_start }}" placeholder="xx:xx">
        </div>
        <div class="form-group">
            <label for="beatport_sample_end" class="form-label">@lang('tracks.beatport_sample_end')</label>
            <input type="text" class="form-control form-dark" id="beatport_sample_end" name="beatport_sample_end" value="{{ $track->beatport_sample_end }}" placeholder="xx:xx">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary save-track" data-method="{{ $track->id ? 'PUT' : 'POST' }}"
                data-url="{{ $track->id ? route('tracks.update', $track->id) : route('tracks.store') }}" @if($track->id) data-id="{{ $track->id }}"@endif>
            <i class="fa-solid fa-check me-2"></i>@lang('shared.admin.save')
        </button>
    </div>
</div>
