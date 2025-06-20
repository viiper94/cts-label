<div class="card text-bg-dark mb-3 track-card" id="track-{{ $key }}">
    <div class="card-header">
        <div class="form-group">
            <label class="form-label">@lang('feedback.track_title')</label>
            <div class="input-group">
                <button type="button" class="btn btn-outline feedback-track-number border-0" disabled>.</button>
                <input type="text" class="form-control form-control-lg form-dark" name="tracks[{{ $key }}][name]"
                       value="{{ !$feedback->id
                                    ? (!$feedback->release ? '' : $track->getFullTitle())
                                    : $track->name }}" placeholder="@lang('feedback.track_title')" required>
                @if(!$feedback->release)
                    <button class="btn btn-lg btn-outline delete-feedback-track-btn border-0" type="button"
                            @if($feedback->id) data-url="{{ route('feedback.track.destroy', $track->id) }}" @endif
                            onclick="return confirm('@lang('feedback.delete_this_track')')">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row my-3">
            <div class="form-group mb-3">
                <label class="form-label">@lang('feedback.high_quality_file')</label>
                <input type="file" class="form-control form-dark" name="tracks[{{ $key }}][320]" accept=".mp3"
                       @if($feedback->id && $track->hasHQFile()) style="display: none" @endif id="track_{{ $key }}_320">
                @if($feedback->id && $track->hasHQFile())
                    <div class="track-player align-items-center" id="track_{{ $key }}_320_player" style="display: flex">
                        <div class="player">
                            <audio src="{{ $track->filePath() }}"></audio>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline ms-3 replace-track" data-target="track_{{ $key }}_320">
                            <i class="fa-solid fa-arrows-rotate"></i>
                        </button>
                    </div>
                @endif
            </div>
        </div>
        <div class="row my-3">
            <div class="form-group mb-3">
                <label>@lang('feedback.low_quality_file')</label>
                <input type="file" class="form-control form-dark" name="tracks[{{ $key }}][96]" accept=".mp3"
                       @if($feedback->id && $track->hasLQFile()) style="display: none" @endif id="track_{{ $key }}_96">
                @if($feedback->id && $track->hasLQFile())
                    <div class="track-player align-items-center gap-2" id="track_{{ $key }}_96_player" style="display: flex">
                        <div class="player">
                            <audio src="{{ $track->filePath(true) }}"></audio>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline ms-3 replace-track" data-target="track_{{ $key }}_96">
                            <i class="fa-solid fa-arrows-rotate"></i>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
