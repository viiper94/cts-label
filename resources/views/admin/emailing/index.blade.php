@extends('admin.layout.layout')

@section('admin-content')

    <div class="container-fluid">
        @include('admin.layout.alert')
        <ul class="nav nav-tabs nav-tabs__dark" role="tablist">
            <li class="active">
                <a href="#channels" data-toggle="tab">
                    Каналы рассылки
                    @if($channels->count() > 0)
                        <span class="label label-warning">{{ $channels->count() }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="#contacts" data-toggle="tab">
                    Контакты
                    @if($contacts->count() > 0)
                        <span class="label label-warning">{{ $contacts->count() }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="#queue" data-toggle="tab">
                    Очередь рассылки
                    @if($queue->count() > 0)
                        <span @class([
                            "label",
                            "label-danger" => $queue_sent->count() !== $queue->count(),
                            "label-success" => $queue_sent->count() === $queue->count()
                            ])>
                            {{ $queue_sent->count() }}/{{ $queue->count() }}
                        </span>
                    @endif
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="channels">
                @include('admin.emailing.tab_channels')
            </div>
            <div class="tab-pane" id="contacts">
                @include('admin.emailing.tab_contacts')
            </div>
            <div class="tab-pane" id="queue">
                @include('admin.emailing.tab_queue')
            </div>
        </div>
    </div>

@endsection
