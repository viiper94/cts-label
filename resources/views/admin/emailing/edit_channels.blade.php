@extends('admin.layout.layout')

@section('admin-content')

    <div class="container">
        <form action="{{ $channel->id ? route('channels.update', $channel->id) : route('channels.store') }}" method="post" id="edit-channel-form">
            @csrf
            @if($channel->id)
                @method('PUT')
            @endif
            <div class="row">
                <div class="form-group col-sm-9">
                    <label for="title">Название канала рассылки</label><br>
                    <input type="text" class="form-control form-control__dark" id="title" name="title" value="{{ old('title') ?? $channel->title }}" required>
                    @if($errors->has('title'))
                        <p class="help-block">{{ $errors->first('title') }}</p>
                    @endif
                </div>
                <div class="form-group col-sm-3">
                    <label for="lang">Язык</label><br>
                    <select class="form-control form-control__dark" id="lang" name="lang">
                        <option value="en" @selected($channel->lang === 'en')>EN</option>
                        <option value="ua" @selected($channel->lang === 'ua')>UA</option>
                        <option value="ru" @selected($channel->lang === 'ru')>RU</option>
                    </select>
                    @if($errors->has('lang'))
                        <p class="help-block">{{ $errors->first('lang') }}</p>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label for="subject">Тема письма</label><br>
                <input type="text" class="form-control form-control__dark" id="subject" name="subject" value="{{ old('subject') ?? $channel->subject }}" required>
                @if($errors->has('subject'))
                    <p class="help-block">{{ $errors->first('subject') }}</p>
                @endif
            </div>
            <div class="form-group">
                <label for="from">E-Mail отправителя</label><br>
                <input type="email" class="form-control form-control__dark" id="from" name="from" value="{{ old('from') ?? $channel->from }}" placeholder="info@cts-label.com" required>
                @if($errors->has('from'))
                    <p class="help-block">{{ $errors->first('from') }}</p>
                @endif
            </div>
            <div class="form-group">
                <label for="description">Описание</label><br>
                <textarea name="description" id="description" rows="3" class="form-control form-control__dark">{{ old('description') ?? $channel->description }}</textarea>
                @if($errors->has('description'))
                    <p class="help-block">{{ $errors->first('description') }}</p>
                @endif
            </div>
            @if(!$channel->id)
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="add_all">
                        Добавить ВСЕ контакты в канал
                    </label>
                </div>
            @endif
            <button type='submit' class='btn btn-primary' name='edit_release' form="edit-channel-form">
                <span class='glyphicon glyphicon-check' aria-hidden='true'></span>
                Сохранить
            </button>
        </form>
        @if($channel->id)
            <form action="{{ route('channels.destroy', $channel->id) }}" method="post" style="margin-top: 10px">
                @csrf
                @method('DELETE')
                <button class='btn btn-danger' type='submit' onclick='return confirm("Удалить канал рассылки?")'>
                    <span class='glyphicon glyphicon-trash' aria-hidden='true'></span> Удалить канал
                </button>
            </form>
        @endif
    </div>

@endsection
