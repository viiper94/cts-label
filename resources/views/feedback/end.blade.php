@extends('layout.layout')

@section('content')

    <div class="container feedback text-light py-5 text-center">
        <h3 class="fw-bold">@lang('feedback.thank_you')</h3>
        <h5 class="fw-bold">@lang('feedback.find_links')</h5>
        <ul class="py-3">
            @foreach($feedback->tracks as $track)
                <li>
                    <a href="/audio/feedback/{{ $feedback->slug }}/320/{{ $track[320] }}" target="_blank">
                        <i class="fa-solid fa-download me-2 text-muted"></i>{{ $track['title'] }}
                    </a>
                </li>
            @endforeach
        </ul>
        <a class="btn btn-outline" href="/audio/feedback/{{ $feedback->slug }}/{{ $feedback->archive_name }}" target="_blank">
            <i class="fa-solid fa-file-zipper me-2"></i>@lang('feedback.download_archive')
        </a>
    </div>

@endsection
