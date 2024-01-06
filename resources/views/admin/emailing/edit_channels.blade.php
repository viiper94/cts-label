@extends('admin.layout.layout')

@section('title')
    {{ $channel->title ?? trans('emailing.channels.new_emailing_channel') }} | @lang('shared.admin.cts_admin_panel')
@endsection

@section('admin-content')

    <div class="container-fluid">
        <button type="submit" class="btn btn-primary shadow sticky-top my-3" form="edit-channel-form">
            <i class="fa-solid fa-floppy-disk me-2"></i>@lang('shared.admin.save')
        </button>
        @if($channel->id)
            <form action="{{ route('emailing.channels.destroy', $channel->id) }}" method="post" class="d-inline my-3">
                @method('DELETE')
                @csrf
                <button class="btn btn-outline-danger" onclick="return confirm('@lang('emailing.channels.delete_channel')?')">
                    <i class="fa-solid fa-trash me-2"></i>@lang('shared.admin.delete')
                </button>
            </form>
        @endif
        <a class="btn btn-outline" href="{{ route('emailing.channels.export', $channel->id) }}">
            <i class="fa-solid fa-file-export me-2"></i>@lang('shared.admin.export_xlsx')
        </a>
        <form action="{{ $channel->id ? route('emailing.channels.update', $channel->id) : route('emailing.channels.store') }}"
              method="post" id="edit-channel-form">
            @csrf
            @if($channel->id)
                @method('PUT')
            @endif
            <div class="row">
                <div class="form-group mb-3 col-sm-9">
                    <label for="title" class="form-label">@lang('emailing.channels.channel_title')</label><br>
                    <input type="text" class="form-control form-dark" id="title" name="title"
                           value="{{ old('title') ?? $channel->title }}" required>
                    @error('title')
                        <small class="text-warning">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mb-3 col-sm-3">
                    <label for="lang" class="form-label">@lang('emailing.channels.channel_language')</label><br>
                    <select class="form-control form-dark" id="lang" name="lang">
                        <option value="en" @selected($channel->lang === 'en')>EN</option>
                        <option value="ua" @selected($channel->lang === 'ua')>UA</option>
                        <option value="ru" @selected($channel->lang === 'ru')>RU</option>
                    </select>
                    @error('lang')
                        <small class="text-warning">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="subject" class="form-label">@lang('emailing.channels.channel_subject')</label><br>
                <input type="text" class="form-control form-dark" id="subject" name="subject"
                       value="{{ old('subject') ?? $channel->subject }}" required>
                @error('subject')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="row">
                <div class="col-sm-9">
                    <div class="form-group mb-3">
                        <label for="from" class="form-label">@lang('emailing.channels.channel_sender')</label><br>
                        <input type="email" class="form-control form-dark" id="from" name="from"
                               value="{{ old('from') ?? $channel->from }}" placeholder="info@cts-studio.com" required>
                        @error('from')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group mb-3">
                        <label for="from_name" class="form-label">@lang('emailing.channels.channel_sender_name')</label><br>
                        <input type="text" class="form-control form-dark" id="from_name" name="from_name"
                               value="{{ old('from_name') ?? $channel->from_name }}" placeholder="CTS Records" required>
                        @error('from_name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <x-checkbox class="mb-3" name="unsubscribe" :checked="!$channel->id || $channel->unsubscribe">
                @lang('emailing.channels.add_unsubscribe')
            </x-checkbox>
            <div class="form-group mb-3">
                <label for="description" class="form-label">@lang('emailing.channels.channel_description')</label><br>
                <textarea name="description" id="description" rows="3" class="form-control form-dark">{{ old('description') ?? $channel->description }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @if(!$channel->id)
                <x-checkbox class="mb-3" name="add_all">@lang('emailing.channels.add_all_contacts')</x-checkbox>
            @endif

            <div class="card text-bg-dark mb-5">
                <button class="card-header p-3 accordion-button collapsed justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFlow" aria-expanded="false" aria-controls="collapseFlow">
                    <i class="fa-solid fa-chevron-down me-2"></i>@lang('emailing.channels.advanced_settings')
                </button>
                <div class="collapse" id="collapseFlow">
                    <div class="card-body row">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="smtp_host" class="form-label">@lang('emailing.channels.channel_smtp_host')</label><br>
                                    <input type="text" class="form-control form-dark" id="smtp_host" name="smtp_host"
                                           value="{{ old('smtp_host') ?? $channel->smtp_host }}">
                                    @error('smtp_host')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="smtp_port" class="form-label">@lang('emailing.channels.channel_smtp_port')</label><br>
                                    <input type="text" class="form-control form-dark" id="smtp_port" name="smtp_port"
                                           value="{{ old('smtp_port') ?? $channel->smtp_port }}">
                                    @error('smtp_port')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="smtp_encryption" class="form-label">@lang('emailing.channels.channel_smtp_encryption')</label><br>
                                    <input type="text" class="form-control form-dark" id="smtp_encryption" name="smtp_encryption"
                                           value="{{ old('smtp_encryption') ?? $channel->smtp_encryption }}">
                                    @error('smtp_encryption')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="smtp_username" class="form-label">@lang('emailing.channels.channel_smtp_username')</label><br>
                                    <input type="text" class="form-control form-dark" id="smtp_username" name="smtp_username"
                                           value="{{ old('smtp_username') ?? $channel->smtp_username }}">
                                    @error('smtp_username')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="smtp_password" class="form-label">@lang('emailing.channels.channel_smtp_password')</label><br>
                                    <input type="text" class="form-control form-dark" id="smtp_password" name="smtp_password"
                                           value="{{ old('smtp_password') ?? $channel->smtp_password }}">
                                    @error('smtp_password')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group mb-3">
                                    <label for="smtp_send_rate" class="form-label">@lang('emailing.channels.channel_smtp_send_rate')</label><br>
                                    <input type="number" class="form-control form-dark" id="smtp_send_rate" name="smtp_send_rate"
                                           value="{{ old('smtp_send_rate') ?? $channel->smtp_send_rate }}">
                                    @error('smtp_send_rate')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="template" class="form-label">@lang('emailing.channels.channel_template')</label><br>
                            <input type="text" class="form-control form-dark" id="template" name="template" placeholder="custom"
                                   value="{{ old('template') ?? $channel->template }}">
                            @error('template')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>

@endsection
