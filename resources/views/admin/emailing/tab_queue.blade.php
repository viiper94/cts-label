{{ $queue->appends(Request::input())->links('admin.layout.pagination') }}
<div class="table-responsive">
    @if($queue_count)
        <div class="progress progress__dark" style="margin-bottom: 0">
            <div @class([
                    'progress-bar progress-bar-striped',
                    'progress-bar-warning active' => $queue_sent !== $queue_count,
                    'progress-bar-success' => $queue_sent === $queue_count
                ]) role="progressbar" aria-valuenow="{{ floor(($queue_sent / $queue_count) * 100) }}"
                 aria-valuemin="0" aria-valuemax="100" style="width: {{ floor(($queue_sent / $queue_count) * 100) }}%">
                <span><b>{{ floor(($queue_sent / $queue_count) * 100) }}%</b></span>
            </div>
        </div>
    @endif
    <table class="items-table table table-hover table__dark">
        <tbody>
        <tr>
            <th>
                @if($queue_sent > 0)
                    <form method="post" action="{{ route('queue.clear') }}">
                        @csrf
                        @method('DELETE')
                        <button class='btn btn-warning' type="submit" onclick="return confirm('Очистить завершенные?')">
                            <span class='glyphicon glyphicon-erase' aria-hidden='true'></span>
                        </button>
                    </form>
                @endif
            </th>
            <th>Канал</th>
            <th>От</th>
            <th>Получатель</th>
            <th>Имя получателя</th>
            <th>Добавлен в очередь</th>
            <th>Отправлено</th>
            <th>Ошибка</th>
        </tr>
        @foreach($queue as $item)
            <tr @class([
                    'text-danger' => $item->error_code,
                    'text-success' => !$item->error_code && $item->sent,
                ])>
                <td>
                    <span @class([
                        'glyphicon',
                        'glyphicon-remove text-danger' => $item->error_code,
                        'glyphicon-ok text-success' => !$item->error_code && $item->sent,
                        'glyphicon-time text-info' => !$item->sent
                        ]) aria-hidden='true'></span>
                </td>
                <td>{{ $item->channel?->title }}</td>
                <td>{{ $item->from }}</td>
                <td><b>{{ $item->to }}</b></td>
                <td><b>{{ $item->name }}</b></td>
                <td>{{ $item->created_at->isoFormat('LLL') }}</td>
                <td>{{ $item->sent ? $item->updated_at->isoFormat('LLL') : '–' }}</td>
                <td title="{{ $item->error_message ?? false }}">{{ $item->error_code ??  '–' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $queue->appends(Request::input())->links('admin.layout.pagination') }}
