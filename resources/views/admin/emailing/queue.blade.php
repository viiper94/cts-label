@extends('admin.layout.layout')

@section('title')
    @lang('emailing.queue.emailing_queue') | @lang('shared.admin.cts_admin_panel')
@endsection

@section('admin-content')

    <div class="container-fluid emailing">
        <div class="justify-content-between align-items-center d-flex my-3">
            <form action="{{ route('emailing.queue.clear') }}" method="post">
                @if($queue_sent > 0)
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger" type="submit" onclick="return confirm('@lang('emailing.queue.remove_finished')?')">
                        <i class="fa-solid fa-eraser me-2"></i>@lang('emailing.queue.remove_finished')
                    </button>
                @endif
                @if($view === 'all')
                    @if($problem_count > 0)
                        <a href="{{ route('emailing.queue.problem') }}" class="btn btn-outline text-warning"><i class="fa-solid fa-triangle-exclamation"></i></a>
                    @endif
                @else
                    <a href="{{ route('emailing.queue.index') }}" class="btn btn-outline"><i class="fa-solid fa-envelope"></i></a>
                @endif
            </form>
            {{ $queue->appends(Request::input())->links('admin.layout.pagination') }}
        </div>
        <div class="table-responsive" data-fl-scrolls>
            @if($queue_sent !== $queue_count)
                <p class="text-muted mb-0">@lang('emailing.queue.letters_remain'): {{ $queue_count - $queue_sent }}</p>
                <p class="text-muted mb-0">@lang('emailing.queue.time_remain'): {{ \App\EmailingQueue::getEta($queue_count - $queue_sent) }}</p>
            @endif
            @if($queue_count > 0)
                <div class="progress bg-dark mb-0">
                    <div @class([
                            'progress-bar',
                            'bg-success text-dark progress-bar-animated progress-bar-striped' => $queue_sent !== $queue_count,
                            'bg-success' => $queue_sent === $queue_count
                        ]) role="progressbar" aria-valuenow="{{ floor(($queue_sent / $queue_count) * 100) }}"
                         aria-valuemin="0" aria-valuemax="100" style="width: {{ floor(($queue_sent / $queue_count) * 100) }}%">
                        <span><b>{{ floor(($queue_sent / $queue_count) * 100) }}%</b></span>
                    </div>
                </div>
            @endif
            <table class="table table-hover table-dark text-nowrap table-sm">
                <thead>
                <tr>
                    <th></th>
                    <th>@lang('emailing.queue.channel')</th>
                    <th>@lang('emailing.queue.from')</th>
                    <th>@lang('emailing.queue.recipient_email')</th>
                    <th>@lang('emailing.queue.created_at')</th>
                    <th>@lang('emailing.queue.sent_at')</th>
                    <th>@lang('emailing.queue.error')</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($queue as $item)
                    <tr @class([
                            'text-danger' => $item->error_code !== null && $item->sent,
                            'text-warning' => $item->error_code !== null && !$item->sent,
                            'text-success' => !$item->error_code && $item->sent,
                        ])>
                        <td>
                            <i @class([
                                'fa-solid',
                                'fa-triangle-exclamation text-danger' => $item->error_code !== null && $item->sent,
                                'fa-triangle-exclamation text-warning' => $item->error_code !== null && !$item->sent,
                                'fa-check text-success' => !$item->error_code && $item->sent,
                                'fa-hourglass-half text-info' => !$item->sent
                                ]) aria-hidden='true'></i>
                        </td>
                        <td>{{ $item->channel?->title }}</td>
                        <td>{{ $item->from_name }} <small class="text-muted">{{ $item->from }}</small></td>
                        <td>{{ $item->name }} <small class="text-muted">{{ $item->to }}</small></td>
                        <td>{{ $item->created_at->isoFormat('LLL') }}</td>
                        <td>{{ $item->sent ? $item->updated_at->isoFormat('LLL') : '–' }}</td>
                        <td title="{{ $item->error_message ?? false }}">{{ $item->error_code ??  '–' }}</td>
                        <td>@if($item->smtp_host)<i class="bi bi-database-fill-gear" title="{{ $item->smtp_host }}"></i>@endif</td>
                        <td>
                            <form action="{{ route('emailing.queue.destroy', $item->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('@lang('emailing.queue.remove_from_queue')?')">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="justify-content-end align-items-center d-flex my-3">
            {{ $queue->appends(Request::input())->links('admin.layout.pagination') }}
        </div>
    </div>

@endsection
