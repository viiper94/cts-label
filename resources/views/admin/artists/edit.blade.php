@extends('admin.layout.layout')

@section('admin-content')
    <div class="container">
        @include('admin.layout.alert')
        <form enctype="multipart/form-data" action="{{ $artist->id ? route('artists.update', $artist->id) : route('artists.store') }}" method="post">
            @if($artist->id)
                @method('PUT')
            @endif
            @csrf
            <div class="col-md-5 col-xs-12 release-image">
                <img src="/images/artists/{{ $artist->image ?? 'default.png' }}" id="preview">
                <input type="file" name="image" id="uploader" accept="image/jpeg, image/png">
                @if($errors->has('image'))
                    <p class="help-block">{{ $errors->first('image') }}</p>
                @endif
            </div>
            <div class="col-md-7 col-xs-12">
                <div class="form-group">
                    <label>Имя артиста</label><br>
                    <input type="text" class="form-control form-control__dark" name="name" value="{{ $artist->name }}" required>
                    @if($errors->has('name'))
                        <p class="help-block">{{ $errors->first('name') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label>Ссылка на соц. сеть</label><br>
                    <input type="text" class="form-control form-control__dark" name="link" value="{{ $artist->link }}">
                    @if($errors->has('link'))
                        <p class="help-block">{{ $errors->first('link') }}</p>
                    @endif
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="visible" {{ !$artist->visible ? : 'checked' }}> Опубликовано
                    </label>
                </div>
            </div>
            <div class="clearfix"></div>
            <button type='submit' class='btn btn-primary' name='edit_artist'>
                <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                Сохранить
            </button>
        </form>
    </div>

@endsection
