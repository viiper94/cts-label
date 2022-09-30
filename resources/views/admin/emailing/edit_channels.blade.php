@extends('admin.layout.layout')

@section('admin-content')

    <div class="container">
        <form method="post">
            @csrf
            <div class="form-group">
                <label for="title">Название канала рассылки</label><br>
                <input type="text" class="form-control form-control__dark" id="title" name="title" value="{{ $channel->title }}" required>
                @if($errors->has('title'))
                    <p class="help-block">{{ $errors->first('title') }}</p>
                @endif
            </div>
            <div class="form-group">
                <label for="subject">Тема письма</label><br>
                <input type="text" class="form-control form-control__dark" id="subject" name="subject" value="{{ $channel->subject }}" required>
                @if($errors->has('subject'))
                    <p class="help-block">{{ $errors->first('subject') }}</p>
                @endif
            </div>
            <div class="form-group">
                <label for="from">E-Mail отправителя</label><br>
                <input type="email" class="form-control form-control__dark" id="from" name="from" value="{{ $channel->from }}" placeholder="info@cts-label.com">
                @if($errors->has('from'))
                    <p class="help-block">{{ $errors->first('from') }}</p>
                @endif
            </div>
            <div class="form-group">
                <label for="description">Описание</label><br>
                <textarea name="description" id="description" rows="3" class="form-control form-control__dark">{{ $channel->description }}</textarea>
                @if($errors->has('description'))
                    <p class="help-block">{{ $errors->first('description') }}</p>
                @endif
            </div>
            <button type='submit' class='btn btn-primary' name='edit_release'>
                <span class='glyphicon glyphicon-check' aria-hidden='true'></span>
                Сохранить
            </button>
            <a class='btn btn-danger' href='{{ route('emailing_admin') }}/deleteChannel/{{ $channel->id }}' onclick='return confirm("Удалить канал рассылки?")'>
                <span class='glyphicon glyphicon-trash' aria-hidden='true'></span> Удалить канал
            </a>
        </form>
    </div>

@endsection
