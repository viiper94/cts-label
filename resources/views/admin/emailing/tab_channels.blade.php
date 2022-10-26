<div class="table-responsive">
    <table class="items-table table table-hover table__dark">
        <tbody>
        <tr>
            <th>Название</th>
            <th>Тема письма</th>
            <th>Отправитель</th>
            <th>Описание</th>
            <th>Язык</th>
            <th>Подписчиков</th>
            <th>Создано</th>
            <th>
                <a class='btn btn-info btm-sm' href='{{ route('emailing.channels.create') }}'>
                    <span class='glyphicon glyphicon-plus' aria-hidden='true'></span>
                </a>
            </th>
        </tr>
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
                    <a class='btn btn-warning' href='{{ route('emailing.channels.edit', $channel->id) }}'>
                        <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                    </a>
                    @if($channel->queue_count > 0)
                        <form action="{{ route('emailing.channels.stop') }}" method="post" style="display: inline-block;">
                            @csrf
                            <input type="hidden" name="id" value="{{ $channel->id }}">
                            <button class='btn btn-danger' onclick='return confirm("Остановить рассылку?")'>
                                <span class='glyphicon glyphicon-stop' aria-hidden='true'></span>
                            </button>
                        </form>
                    @else
                        <form action="{{ route('emailing.channels.start') }}" method="post" style="display: inline-block;">
                            @csrf
                            <input type="hidden" name="id" value="{{ $channel->id }}">
                            <button class='btn btn-success' onclick='return confirm("Запустить рассылку?")'>
                                <span class='glyphicon glyphicon-play' aria-hidden='true'></span>
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
