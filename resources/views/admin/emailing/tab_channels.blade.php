<div class="table-responsive">
    <table class="items-table table table-hover table__dark">
        <tbody>
        <tr>
            <th>Название</th>
            <th>Тема письма</th>
            <th>Отправитель</th>
            <th>Описание</th>
            <th>Подписчиков</th>
            <th>Создано</th>
            <th>
                <a class='btn btn-info btm-sm' href='{{ route('emailing_admin') }}/editChannel'>
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
                <td>{{ count($channel->subscribers) }}</td>
                <td>{{ $channel->created_at->isoFormat('LLL') }}</td>
                <td>
                    <form action="{{ route('emailing_admin') }}/start" method="post">
                        @csrf
                        <a class='btn btn-warning' href='{{ route('emailing_admin') }}/editChannel/{{ $channel->id }}'>
                            <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                        </a>
                        <input type="hidden" name="id" value="{{ $channel->id }}">
                        <button class='btn btn-success' onclick='return confirm("Запустить рассылку?")'>
                            <span class='glyphicon glyphicon-play' aria-hidden='true'></span>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
