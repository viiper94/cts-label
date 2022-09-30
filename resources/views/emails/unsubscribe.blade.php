@extends('layout.layout')

@section('content')

    <div class="container unsubscribe">
        <form method="post">
            @csrf
            <div class="panel panel-default">
                <div class="panel-heading"><h4>@lang('emailing.unsubscribe.unsubscribe_from')</h4></div>
                <div class="panel-body panel-body__dark">
                    <h4>@lang('emailing.unsubscribe.email') <b>{{ $email }}</b></h4>
                    <h4>@lang('emailing.unsubscribe.receive_message') <b>{{ $from }}</b></h4>

                    <p style="margin-top: 40px"><b>@lang('emailing.unsubscribe.you_can')</b></p>
                    <div class="radio">
                        <label for="current">
                            <input type="radio" name="type" value="current" id="current" checked>
                            @lang('emailing.unsubscribe.unsubscribe_current')
                        </label>
                    </div>
                    <div class="radio">
                        <label for="all">
                            <input type="radio" name="type" value="all" id="all">
                            @lang('emailing.unsubscribe.unsubscribe_all')
                        </label>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type='submit' class='btn'>
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
