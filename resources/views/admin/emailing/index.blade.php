@extends('admin.layout.layout')

@section('search')
    @include('admin.layout.search')
@endsection

@section('admin-content')

    <div class="container-fluid emailing">
        @include('admin.layout.alert')
        <ul class="nav nav-tabs nav-tabs__dark" role="tablist">
            <li @class(['active' => $view === 'channels'])>
                <a href="{{ route('channels.index') }}">
                    Каналы рассылки
                    @if($channels->count() > 0)
                        <span class="label label-warning">{{ $channels->count() }}</span>
                    @endif
                </a>
            </li>
            <li @class(['active' => $view === 'contacts'])>
                <a href="{{ route('contacts.index') }}">
                    Контакты
                    @if($contacts_count > 0)
                        <span class="label label-warning">{{ $contacts_count }}</span>
                    @endif
                </a>
            </li>
            <li @class(['active' => $view === 'queue'])>
                <a href="{{ route('queue.index') }}" >
                    Очередь рассылки
                    @if($queue_count > 0)
                        <span @class([
                            "label",
                            "label-danger" => $queue_sent !== $queue_count,
                            "label-success" => $queue_sent === $queue_count
                            ])>
                            {{ $queue_sent }}/{{ $queue_count }}
                        </span>
                    @endif
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active">
                @include('admin.emailing.tab_'.$view)
            </div>
        </div>
    </div>

@endsection
