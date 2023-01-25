@extends('layout.layout')

@section('title', 'Feedback to '. $feedback->feedback_title)

@section('scripts')
    <script src="/js/wavesurfer.min.js"></script>
@endsection

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

    <div class="container pt-5 pb-3 feedback">
        <div class="row">
            <div class="col-12 col-sm-auto cover text-center">
                @if($feedback->release)
                    <a href="{{ route('release', $feedback->release->id) }}" target="_blank" class="d-block">
                        <img src="/images/releases/{{ $feedback->release->image }}" alt="{{ $feedback->release->title }}">
                    </a>
                @else
                    <img src="/images/feedback/{{ $feedback->image }}" alt="{{ $feedback->feedback_title }}">
                @endif
            </div>
            <div class="col-12 col-sm">
                <div class="row">
                    <div class="col-12 col-md">
                        <h5 class="mb-3 mt-3 mt-sm-0 text-center text-sm-start">{{ $feedback->feedback_title }}</h5>
                    </div>
                    <div class="col-12 col-md-auto">
                        <div class="lang-switch mb-3 mt-3 mt-sm-0 justify-content-center justify-content-md-end">
                            <div class="btn-group">
                                <a @class(['btn switch-btn', 'active' => isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'en'])
                                   data-lang="en" href="{{ route('feedback', $feedback->slug) }}">
                                    @lang('shared.en')
                                </a>
                                <a @class(['btn switch-btn', 'active' => isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'ua' || !isset($_COOKIE['lang'])])
                                   data-lang="ua" href="{{ route('feedback', $feedback->slug) }}">
                                    @lang('shared.ua')
                                </a>
                                <a @class(['btn switch-btn', 'active' => isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'ru'])
                                   data-lang="ru" href="{{ route('feedback', $feedback->slug) }}">
                                    @lang('shared.ru')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="py-3 header_text">
                    @if($feedback->release)
                        {!! $feedback->release['description_'.$feedback->release->detectActiveDescriptionLang()] !!}
                    @else
                        {!! $feedback['description_'.app()->getLocale()] !!}
                    @endif
                </div>
                <hr>
                <p class="header_text py-3">@lang('feedback.header_text')</p>
            </div>
        </div>

        <form id="feedback-form" class="py-3" method="post">
            @csrf
            <div class="row">
                <h5 class="text-center fw-bold text-light mb-3">@lang('feedback.feedback_form')</h5>
                <div class="d-flex m-auto flex-column form-group user-info">
                    <input type="text" class="form-control form-dark mb-2" id="name" name="name" required placeholder="@lang('feedback.your_name')">
                    <input type="email" class="form-control form-dark" id="email" name="email" required placeholder="@lang('feedback.your_email')">
                </div>
            </div>
            <hr class="w-75 m-auto my-3">

            <!-- ----------- Tracks ------------- -->
            @foreach($feedback->ftracks as $key => $track)

                <div class="track py-3" data-id="{{ $key }}">
                    <div class="info row align-items-center">
                        <div class="title col-12 col-md flex-grow-1">{{ $track->name }}</div>
                        <div class="col-12 col-md-auto d-flex align-items-center flex-nowrap justify-content-between">
                            <div class="time text-nowrap">
                                <span class="current-time">00:00</span>
                                <span class="time-break">/</span>
                                <span class="duration">00:00</span>
                            </div>
                            <div class="volume-bar ms-3">
                                <div class="volume-bar-value"></div>
                            </div>
                        </div>
                    </div>
                    <div class="bar d-flex align-items-center">
                        <button type="button" class="play-pause me-3"><i class="fa-solid fa-play"></i></button>
                        <div id="waveform_{{ $key }}" class="waveform flex-grow-1"></div>
                    </div>
                    <div class="rate_stars py-3">
                        <input type="number" class="star-rating" name="rates[{{ $track->name }}]" value=0 required>
                    </div>
                </div>
            @endforeach

            @if(count($feedback->ftracks) > 1)
                <!-- ----------- Best track ------------- -->
                <div class="best_track text-light mb-5">
                    <h6 class="fw-bold">@lang('feedback.best_track'):</h6>
                    @foreach($feedback->ftracks as $key => $track)
                        <div class="form-check">
                            <input type="radio" name="best_track" id="best_{{ $key }}" value="{{ $track->name }}" class="form-check-input" required>
                            <label for="best_{{ $key }}" class="form-check-label">{{ $track->name }}</label>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- ----------- Comment ------------- -->
            <div class="comment text-light mb-5">
                <h6 class="fw-bold">@lang('feedback.comment'):</h6>
                <textarea name="comment" class="form-control form-dark" rows="3" required></textarea>
            </div>
            <div class="d-flex justify-content-center">
                <button class="btn btn-primary" type="submit"><i class="fa-solid fa-check me-2"></i>@lang('feedback.send')</button>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function(){

            window.players = [];

            @foreach($feedback->ftracks as $key => $track)

            window.players.push(new FeedbackPlayer({
                url: '/audio/feedback/{{ $feedback->slug }}/96/{!! $track->file_96 !!}',
                trackIndex: {{ $key }},
                feedbackId: {{ $feedback->id }},
                trackId: {{ $track->id }},
                @if(isset($track->peaks) && !empty(json_decode($track->peaks)))
                peaks: {{ \App\Feedback::getPeaks($track) }},
                @else
                savePeaksRoute: '{{ route('feedback.peaks') }}'
                @endif
            }));

            @endforeach

        });
    </script>
    <script src="/js/feedback_player.js"></script>

@endsection
