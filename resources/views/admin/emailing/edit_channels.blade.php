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
                        <p class="help-block">{{ $message }}</p>
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
                        <p class="help-block">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="subject" class="form-label">@lang('emailing.channels.channel_subject')</label><br>
                <input type="text" class="form-control form-dark" id="subject" name="subject"
                       value="{{ old('subject') ?? $channel->subject }}" required>
                @error('subject')
                    <p class="help-block">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="from" class="form-label">@lang('emailing.channels.channel_sender')</label><br>
                <input type="email" class="form-control form-dark" id="from" name="from"
                       value="{{ old('from') ?? $channel->from }}" placeholder="info@cts-studio.com" required>
                @error('email')
                    <p class="help-block">{{ $message }}</p>
                @enderror
            </div>
            <x-checkbox class="mb-3" name="unsubscribe" :checked="!$channel->id || $channel->unsubscribe">
                @lang('emailing.channels.add_unsubscribe')
            </x-checkbox>
            <div class="form-group mb-3">
                <label for="description" class="form-label">@lang('emailing.channels.channel_description')</label><br>
                <textarea name="description" id="description" rows="3" class="form-control form-dark">{{ old('description') ?? $channel->description }}</textarea>
                @error('description')
                    <p class="help-block">{{ $message }}</p>
                @enderror
            </div>
            @if(!$channel->id)
                <x-checkbox class="mb-3" name="add_all">@lang('emailing.channels.add_all_contacts')</x-checkbox>
            @endif
        </form>
    </div>

@endsection
