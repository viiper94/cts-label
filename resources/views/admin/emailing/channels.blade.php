@extends('admin.layout.layout')

@section('admin-content')

    <div class="container-fluid emailing">
        <div class="justify-content-between align-items-center d-flex my-3">
            <div class="releases-actions">
                <a href="{{ route('emailing.channels.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus me-2"></i>Новый канал рассылки
                </a>
            </div>
        </div>
        <div class="table-responsive mb-3" data-fl-scrolls>
            <table class="table table-dark table-hover">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Тема письма</th>
                    <th>Отправитель</th>
                    <th>Описание</th>
                    <th>Язык</th>
                    <th>Подписчиков</th>
                    <th>Создано</th>
                    <th></th>
                </tr>
                </thead>
                <tbody class="text-nowrap">
                @foreach($channels as $channel)
                    <tr>
                        <td><b>{{ $channel->title }}</b></td>
                        <td>{{ $channel->subject }}</td>
                        <td>{{ $channel->from ?? env('EMAIL_FROM') }}</td>
                        <td>{{ $channel->description }}</td>
                        <td>{{ strtoupper($channel->lang) }}</td>
                        <td>{{ $channel->subscribers_count }}</td>
                        <td>{{ $channel->created_at->isoFormat('LLL') }}</td>
                        <td>
                            <a class="btn btn-sm btn-outline-warning" href="{{ route('emailing.channels.edit', $channel->id) }}">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            @if($channel->queue_count > 0)
                                <form action="{{ route('emailing.channels.stop') }}" method="post" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $channel->id }}">
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Остановить рассылку?')">
                                        <i class="fa-solid fa-stop"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('emailing.channels.start') }}" method="post" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $channel->id }}">
                                    <button class='btn btn-sm btn-success' onclick='return confirm("Запустить рассылку?")'>
                                        <i class="fa-solid fa-play"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
