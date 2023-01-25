<div class="card text-bg-dark mb-3 track-card" id="track-{{ $key }}">
    <div class="card-body">
        <div class="form-group">
            <label class="form-label">Название трека</label>
            <div class="input-group">
                <input type="text" class="form-control form-control-lg form-dark" name="tracks[{{ $key }}][name]"
                       value="{{ !$feedback->id
                                    ? (!$feedback->release ? '' : $track->getFullTitle())
                                    : $track->name }}" placeholder="Название трека" required>
                @if(!$feedback->release)
                    <button class="btn btn-lg btn-outline delete-feedback-track-btn" type="button"
                            @if($feedback->id) data-url="{{ route('feedback.track.destroy', $track->id) }}" @endif
                            onclick="return confirm('Удалить этот трек?')">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                @endif
            </div>
        </div>
        <div class="row my-3">
            <div class="form-group col-sm-6">
                <label>Файл в высоком качестве (.mp3, 320 kbps)</label><br>
                <input type="file" class="form-control form-dark" name="tracks[{{ $key }}][320]" accept=".mp3">
            </div>
            <div class="form-group col-sm-6">
                <label>Файл в низком качестве (.mp3, 96 kbps)</label><br>
                <input type="file" class="form-control form-dark" name="tracks[{{ $key }}][96]" accept=".mp3">
            </div>
        </div>
        @if(key_exists(96, $track) && $track[96] !== '' || key_exists(320, $track) && $track[320] !== '')
            <audio src="/audio/feedback/{{ $feedback->slug }}/{{ $feedback->LQDir() }}/{{ $track[$feedback->LQDir()] }}" controls style="width: 100%;"></audio>
            @if(!is_file(public_path('/audio/feedback/'.$feedback->slug.'/'.$feedback->LQDir().'/'.$track[$feedback->LQDir()])))
                <small class="text-danger">Аудио файл не найден</small>
            @endif
        @endif
    </div>
    <div class="card-footer">
        <button class="btn btn-sm btn-outline-danger delete-track-btn" type="button">
            <i class="fa-solid fa-trash me-2"></i>Удалить
        </button>
    </div>
</div>
