@extends('layout.layout')

@section('content')

    <div class="container auth py-5">
        <form method="post" class="py-5">
            @csrf
            <div class="card text-bg-dark m-auto">
                <div class="card-header"><h5 class="card-title mb-0">@lang('emailing.unsubscribe.unsubscribe_from')</h5></div>
                <div class="card-body">
                    <p class="mb-0">@lang('emailing.unsubscribe.email') <b>{{ $email }}</b></p>
                    <p>@lang('emailing.unsubscribe.receive_message') <b>{{ $from }}</b></p>

                    <p class="mb-0"><b>@lang('emailing.unsubscribe.you_can')</b></p>
                    <div class="form-check">
                        <input type="radio" name="type" value="current" id="current" class="form-check-input" checked>
                        <label for="current" class="form-check-label">@lang('emailing.unsubscribe.unsubscribe_current')</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="type" value="all" id="all" class="form-check-input">
                        <label for="all" class="form-check-label">@lang('emailing.unsubscribe.unsubscribe_all')</label>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-outline">
                        <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                        @lang('emailing.unsubscribe.unsubscribe')
                    </button>
                    @if($complete)
                        <span class="text-success">@lang('emailing.unsubscribe.you_unsubscribed')</span>
                    @endif
                </div>
            </div>
        </form>
    </div>

@endsection
