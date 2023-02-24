@extends('admin.layout.layout')

@section('title')
    {{ $channel->title ?? 'Новый канал рассылки' }} | CTS Records Admin Panel
@endsection

@section('admin-content')

    <div class="container-fluid">
        <button type="submit" class="btn btn-primary shadow sticky-top my-3" form="edit-channel-form">
            <i class="fa-solid fa-floppy-disk me-2"></i>Сохранить
        </button>
        @if($channel->id)
            <form action="{{ route('emailing.channels.destroy', $channel->id) }}" method="post" class="d-inline my-3">
                @method('DELETE')
                @csrf
                <button class="btn btn-outline-danger" onclick="return confirm('Удалить канал рассылки?')">
                    <i class="fa-solid fa-trash me-2"></i>Удалить
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
                    <label for="title" class="form-label">Название канала рассылки</label><br>
                    <input type="text" class="form-control form-dark" id="title" name="title"
                           value="{{ old('title') ?? $channel->title }}" required>
                    @error('title')
                        <p class="help-block">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group mb-3 col-sm-3">
                    <label for="lang" class="form-label">Язык</label><br>
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
                <label for="subject" class="form-label">Тема письма</label><br>
                <input type="text" class="form-control form-dark" id="subject" name="subject"
                       value="{{ old('subject') ?? $channel->subject }}" required>
                @error('subject')
                    <p class="help-block">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="from" class="form-label">E-Mail отправителя</label><br>
                <input type="email" class="form-control form-dark" id="from" name="from"
                       value="{{ old('from') ?? $channel->from }}" placeholder="info@cts-studio.com" required>
                @error('email')
                    <p class="help-block">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-check mb-3">
                <input type="hidden" name="unsubscribe" value="0">
                <input type="checkbox" name="unsubscribe" id="unsubscribe" class="form-check-input" value="1" @checked(!$channel->id || $channel->unsubscribe)>
                <label for="unsubscribe" class="form-check-label">Добавлять кнопку <b>Отписаться</b></label>
            </div>
            <div class="form-group mb-3">
                <label for="description" class="form-label">Описание</label><br>
                <textarea name="description" id="description" rows="3" class="form-control form-dark">{{ old('description') ?? $channel->description }}</textarea>
                @error('description')
                    <p class="help-block">{{ $message }}</p>
                @enderror
            </div>
            @if(!$channel->id)
                <div class="form-check mb-3">
                    <input type="checkbox" name="add_all" id="add_all" class="form-check-input">
                    <label for="add_all" class="form-check-label">Добавить ВСЕ контакты в канал</label>
                </div>
            @endif
        </form>
    </div>

@endsection
