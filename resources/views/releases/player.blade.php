<div class="preview-player d-flex justify-content-between" style="display: none" data-track="{{ $track->id }}">
    <div class="track-info justify-content-center">
        <img src="/images/releases/{{ $release->image_270 }}" alt="{{ $release->title }}" class="me-2">
        <div class="track-artists text-primary">
            {{ $track->artists }}
        </div>
        <div class="track-title">
            {{ $track->name }}
        </div>
        <div class="track-mix text-muted">
            {{ $track->mix_name ?? '' }}
        </div>
    </div>
    <div class="player-main-area d-flex justify-content-center align-items-center order-1 order-md-0">
        <div class="track-controls">
            <button type="button" class="play-pause">
                <i class="fa-solid fa-play"></i>
            </button>
        </div>
        <div class="bar mx-md-2">
            <img class="wave" src="{{ $wave }}">
            <div class="bar-before" style="right: {{ $right }}%"></div>
            <div id="waveform" class="waveform" style="width: {{ $width }}%; margin-left: {{ $ml }}%"></div>
            <div class="player-progress" style="left: {{ $ml }}%"></div>
            <div class="bar-after" style="left: {{ $left }}%"></div>
        </div>
        <div class="track-metadata mx-2 d-none d-md-block">
            <div class="duration">
                @if($track->length)
                    <span class="current">{{ $track->beatport_sample_start }}</span>
                    /
                    <span class="length">{{ $track->length }}</span>
                @endif
            </div>
            <div class="bpm text-muted text-center">
                {{ $track->bpm ?? '' }} BPM
            </div>
        </div>
    </div>
    <div class="track-extra ps-3 order-0 order-md-1">
        <div class="volume d-flex align-items-center">
            <button class="mute" type="button">
                <i class="fa-solid fa-volume-high mx-2"></i>
            </button>
            <div class="volume-bar d-none d-md-block">
                <div class="volume-bar-value" style="width: 70%;"></div>
            </div>
        </div>
        <button type="button" class="close p-2">
            <i class="fa-solid fa-times"></i>
        </button>
    </div>
</div>
