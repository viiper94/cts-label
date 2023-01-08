<div class="modal-content">
    <div class="modal-header">
        <h3 class="modal-title fs-5" id="trackModalLabel">{{ $track->id ? 'Редактирование' : 'Добавление' }} трека</h3>
        <button type="button" class="btn btn-outline" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="modal-body">
        <div class="form-group mb-3">
            <label for="artists" class="form-label">Артист(ы)* <small class="text-muted">перечислите через запятую</small></label>
            @if(!$track->id && session('artists'))
                <a class="add-promt text-muted">{{ session('artists') }}</a>
            @endif
            <input type="text" class="form-control form-dark" id="artists" name="artists" value="{{ $track->artists }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="name" class="form-label">Название*</label>
            @if(!$track->id && session('name'))
                <a class="add-promt text-muted">{{ session('name') }}</a>
            @endif
            <input type="text" class="form-control form-dark" id="name" name="name" value="{{ $track->name }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="mix_name" class="form-label">Микс</label>
            @if(!$track->id && session('mix_name'))
                <a class="add-promt text-muted">{{ session('mix_name') }}</a>
            @endif
            <input type="text" class="form-control form-dark" id="mix_name" name="mix_name" value="{{ $track->mix_name }}">
        </div>
        <div class="form-group mb-3">
            <label for="remixers" class="form-label">Ремиксер(ы) <small class="text-muted">перечислите через запятую</small></label>
            <input type="text" class="form-control form-dark" id="remixers" name="remixers" value="{{ implode(', ', (array)$track->remixers) }}">
        </div>
        <div class="form-group mb-3">
            <label for="composer" class="form-label">Композитор</label>
            @if(!$track->id && session('composer'))
                <a class="add-promt text-muted">{{ session('composer') }}</a>
            @endif
            <input type="text" class="form-control form-dark" id="composer" name="composer" value="{{ $track->composer }}">
        </div>
        <div class="form-group mb-3">
            <label for="isrc" class="form-label">ISRC код*</label>
            <div class="input-group">
                <input type="text" class="form-control form-dark" id="isrc" name="isrc" value="{{ $track->isrc }}" placeholder="UA-CT1-XX-XXXXX" required>
                @if(!$track->isrc)
                    <button class="btn btn-outline" type="button" id="isrc-generate" data-url="{{ route('tracks.isrc') }}">
                        Сгенерировать
                    </button>
                @endif
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="youtube" class="form-label">Ссылка в YouTube</label>
            <div class="input-group">
                <input type="url" class="form-control form-dark" id="youtube" name="youtube" value="{{ $track->youtube }}">
                @if($track->youtube)
                    <a class="btn btn-outline" href="{{ $track->youtube }}" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                @endif
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="bpm" class="form-label">BPM</label>
            <input type="number" class="form-control form-dark" id="bpm" name="bpm" value="{{ $track->bpm }}">
        </div>
        <div class="form-group mb-3">
            <label for="genre" class="form-label">Жанр</label>
            <input type="text" class="form-control form-dark" id="genre" name="genre" value="{{ $track->genre }}">
        </div>
        <div class="form-group mb-3">
            <label for="length" class="form-label">Продолжительность</label>
            <input type="text" class="form-control form-dark" id="length" name="length" value="{{ $track->length }}" placeholder="xx:xx">
        </div>
        <div class="form-group mb-3">
            <label for="beatport_id" class="form-label">Beatport ID</label>
            <input type="number" class="form-control form-dark" id="beatport_id" name="beatport_id" value="{{ $track->beatport_id }}">
        </div>
        <div class="form-group mb-3">
            <label for="beatport_slug" class="form-label">Beatport Slug</label>
            <input type="text" class="form-control form-dark" id="beatport_slug" name="beatport_slug" value="{{ $track->beatport_slug }}">
        </div>
        <div class="form-group mb-3">
            <label for="beatport_release_id" class="form-label">Beatport ID релиза</label>
            <input type="number" class="form-control form-dark" id="beatport_release_id" name="beatport_release_id" value="{{ $track->beatport_release_id }}">
        </div>
        <div class="form-group mb-3">
            <label for="beatport_wave" class="form-label">Ссылка на вейвформу Beatport</label>
            <div class="input-group">
                <input type="url" class="form-control form-dark" id="beatport_wave" name="beatport_wave" value="{{ $track->beatport_wave }}">
                @if($track->beatport_wave)
                    <a class="btn btn-outline" href="{{ $track->beatport_wave }}" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                @endif
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="beatport_sample" class="form-label">Ссылка на семпл Beatport</label>
            <div class="input-group">
                <input type="url" class="form-control form-dark" id="beatport_sample" name="beatport_sample" value="{{ $track->beatport_sample }}">
                @if($track->beatport_sample)
                    <a class="btn btn-outline" href="{{ $track->beatport_sample }}" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                @endif
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="beatport_sample_start" class="form-label">Старт семпла Beatport</label>
            <input type="text" class="form-control form-dark" id="beatport_sample_start" name="beatport_sample_start" value="{{ $track->beatport_sample_start }}" placeholder="xx:xx">
        </div>
        <div class="form-group">
            <label for="beatport_sample_end" class="form-label">Конец семпла Beatport</label>
            <input type="text" class="form-control form-dark" id="beatport_sample_end" name="beatport_sample_end" value="{{ $track->beatport_sample_end }}" placeholder="xx:xx">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary save-track" data-method="{{ $track->id ? 'PUT' : 'POST' }}"
                data-url="{{ $track->id ? route('tracks.update', $track->id) : route('tracks.store') }}">
            <i class="fa-solid fa-check me-2"></i>Сохранить
        </button>
    </div>
</div>
