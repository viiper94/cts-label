@extends('layout.layout')

@section('content')

    <div class="container feedback text-light py-5 text-center">
        <h3 class="fw-bold">@lang('feedback.thank_you')</h3>
        <h5 class="fw-bold">@lang('feedback.find_links')</h5>
        <ul class="pt-3">
            @foreach($feedback->ftracks as $track)
                <li>
                    <a href="/audio/feedback/{{ $feedback->slug }}/320/{{ $track->file_320 }}" target="_blank">
                        <i class="fa-solid fa-download me-2 text-muted"></i>{{ $track->name }}
                    </a>
                </li>
            @endforeach
        </ul>
        <a class="btn btn-outline-primary" href="/audio/feedback/{{ $feedback->slug }}/{{ $feedback->archive_name }}" target="_blank">
            <i class="fa-solid fa-file-zipper me-2"></i>@lang('feedback.download_archive')
        </a>
        <hr class="my-5">
        @if(count($feedback->related) > 0)
            <div class="also_available">
                <h6 class="fw-bold">@lang('feedback.also_available'):</h6>
                <ul class="">
                    @foreach($feedback->related as $track)
                        <li><a href="{{ route('feedback', $track->slug) }}" target="_blank">{{ $track->feedback_title }}</a></li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

@endsection
