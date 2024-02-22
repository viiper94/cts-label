@extends('admin.layout.layout')

@section('title')
    @lang('emailing.channels.emailing_channels') | @lang('shared.admin.cts_admin_panel')
@endsection

@section('admin-content')

    <div class="container-fluid emailing">
        <div class="justify-content-between align-items-center d-flex my-3">
            <div class="releases-actions">
                <a href="{{ route('emailing.channels.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus me-2"></i>@lang('emailing.channels.new_emailing_channel')
                </a>
            </div>
        </div>
        <div class="table-responsive mb-3" data-fl-scrolls>
            <table class="table table-dark table-hover table-sm">
                <thead>
                <tr>
                    <th></th>
                    <th>@lang('emailing.channels.channel_title')</th>
                    <th>@lang('emailing.channels.channel_subject')</th>
                    <th>@lang('emailing.channels.channel_sender')</th>
                    <th>@lang('emailing.channels.channel_language')</th>
                    <th>@lang('emailing.channels.channel_subscribers')</th>
                    <th>@lang('emailing.channels.channel_created_at')</th>
                    <th class="text-end">@lang('emailing.channels.channel_actions')</th>
                </tr>
                </thead>
                <tbody class="text-nowrap">
                @foreach($channels as $channel)
                    @if($channel->id === 1) @continue @endif
                    <tr>
                        <td>
                            @if($channel->smtp_host) <small class="text-muted"><i class="bi bi-database-fill-gear p-1" title="{{ $channel->smtp_host }}"></i></small>@endif
                            @if($channel->template) <small class="text-muted"><i class="fa-solid fa-file-lines p-1" title="{{ $channel->template }}"></i></small>@endif
                        </td>
                        <td><b>{{ $channel->title }}</b></td>
                        <td title="{{ $channel->subject }}" style="max-width: 300px; text-overflow: ellipsis; overflow: hidden">{{ $channel->subject }}</td>
                        <td>
                            {{ $channel->from_name }}
                            <small class="text-muted">{{ $channel->from }}</small>
                        </td>
                        <td>{{ strtoupper($channel->lang) }}</td>
                        <td>
                            <a href="{{ route('emailing.contacts.index', ['channel' => $channel->id]) }}" class="text-decoration-none">
                                {{ $channel->subscribers_count }}
                            </a>
                        </td>
                        <td>{{ $channel->created_at->isoFormat('LLL') }}</td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-outline-warning" href="{{ route('emailing.channels.edit', $channel->id) }}" title="@lang('shared.admin.edit')">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a class="btn btn-sm btn-outline" href="{{ route('emailing.channels.export', $channel->id) }}" title="@lang('shared.admin.export_xlsx')">
                                <i class="fa-solid fa-download"></i>
                            </a>
                            @if($channel->queue_count > 0)
                                <form action="{{ route('emailing.channels.stop') }}" method="post" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $channel->id }}">
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('@lang('emailing.channels.stop_emailing')?')" title="@lang('emailing.channels.stop_emailing')">
                                        <i class="fa-solid fa-stop"></i>
                                    </button>
                                </form>
                            @else
                                @if($channels->firstWhere('id', 1))
                                    <button class="debug-email-btn btn btn-sm btn-outline" data-bs-toggle="modal" data-bs-target="#testContactsModal"
                                            data-channel="{{ $channel->id }}" title="@lang('emailing.channels.debug')">
                                        <i class="fa-solid fa-bug"></i>
                                    </button>
                                @endif
                                <form action="{{ route('emailing.channels.start') }}" method="post" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $channel->id }}">
                                    <button class='btn btn-sm btn-success' onclick='return confirm("@lang('emailing.channels.start_emailing')?")' title="@lang('emailing.channels.start_emailing')">
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
                        <h5 class="mb-0">@lang('emailing.channels.pick_addresses_for_test')</h5>
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
                                <i class="bi bi-check-square me-2"></i>@lang('emailing.channels.check_all')
                            </button>
                            <button type="button" id="deselect-all-emails" class="btn btn-sm btn-outline">
                                <i class="bi bi-square me-2"></i>@lang('emailing.channels.uncheck_all')
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fa-solid fa-check me-2"></i>@lang('emailing.channels.send_test')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
