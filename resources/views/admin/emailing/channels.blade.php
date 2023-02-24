@extends('admin.layout.layout')

@section('title')
    Каналы рассылки | CTS Records Admin Panel
@endsection

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
                    @if($channel->id === 1) @continue @endif
                    <tr>
                        <td><b>{{ $channel->title }}</b></td>
                        <td>{{ $channel->subject }}</td>
                        <td>{{ $channel->from ?? env('EMAIL_FROM') }}</td>
                        <td>{{ $channel->description }}</td>
                        <td>{{ strtoupper($channel->lang) }}</td>
                        <td>
                            <a href="{{ route('emailing.contacts.index', ['channel' => $channel->id]) }}" class="text-decoration-none">
                                {{ $channel->subscribers_count }}
                            </a>
                        </td>
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
                                <button class="debug-email-btn btn btn-sm btn-outline" data-bs-toggle="modal" data-bs-target="#testContactsModal"
                                        data-channel="{{ $channel->id }}">
                                    <i class="fa-solid fa-bug"></i>
                                </button>
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


    <div class="modal fade" id="testContactsModal" tabindex="-1" aria-labelledby="testContactsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form action="{{ route('emailing.channels.start.test') }}" method="post">
                    @csrf
                    <input type="hidden" name="channel" value="">
                    <div class="modal-header">
                        <h5 class="mb-0">Выберите адреса для тестовой рассылки</h5>
                        <button type="button" class="btn btn-outline ms-3" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                    <div class="modal-body">
                        @foreach($channels->firstWhere('id', 1)->subscribers as $key => $item)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="test_emails[{{ $item->name }}]" value="{{ $item->email }}" id="test_email_{{ $key }}">
                                <label for="test_email_{{ $key }}" class="form-check-label">{{ $item->email }}</label>
                            </div>
                        @endforeach
                        <div class="btn-group mt-3">
                            <button type="button" id="select-all-emails" class="btn btn-sm btn-outline">
                                <i class="bi bi-check-square me-2"></i>Выбрать все
                            </button>
                            <button type="button" id="deselect-all-emails" class="btn btn-sm btn-outline">
                                <i class="bi bi-square me-2"></i>Убрать все
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fa-solid fa-check me-2"></i>Отправить
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
