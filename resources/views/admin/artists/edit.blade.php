@extends('admin.layout.layout')

@section('title')
    {{ $artist->name ?? 'Новый артист' }} | CTS Records Admin Panel
@endsection

@section('admin-content')

    <div class="container-fluid">
        <button type="submit" class="btn btn-primary shadow sticky-top my-3" form="edit_form">
            <i class="fa-solid fa-floppy-disk me-2"></i>Сохранить
        </button>
        @if($artist->id)
            <form action="{{ route('artists.destroy', $artist->id) }}" method="post" class="d-inline my-3">
                @method('DELETE')
                @csrf
                <button class="btn btn-outline-danger" onclick="return confirm('Удалить артиста?')">
                    <i class="fa-solid fa-trash me-2"></i>Удалить
                </button>
            </form>
        @endif
        <form enctype="multipart/form-data" method="post" id="edit_form"
              action="{{ $artist->id ? route('artists.update', $artist->id) : route('artists.store') }}">
            @if($artist->id)
                @method('PUT')
            @endif
            @csrf
            <div class="row">
                <div class="col-md-5 col-xs-12 mb-3">
                    <img src="/images/artists/{{ $artist->image ?? 'default.png' }}" id="preview" class="w-100">
                    <input type="file" name="image" id="uploader" class="form-control form-dark" accept="image/jpeg, image/png">
                    @if($errors->has('image'))
                        <p class="help-block text-danger">{{ $errors->first('image') }}</p>
                    @endif
                </div>
                <div class="col-md-7 col-xs-12 mb-3">
                    <div class="form-check mb-3">
                        <input type="hidden" name="visible" value="0">
                        <input type="checkbox" name="visible" id="visible" class="form-check-input" @checked($artist->visible)>
                        <label for="visible" class="form-check-label">Опубликовано</label>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" for="name">Имя</label><br>
                        <input type="text" class="form-control form-control-lg form-dark" name="name" id="name"
                               value="{{ old('name') ?? $artist->name }}" required>
                        @error('name')
                            <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" for="link">Ссылка в социальную сеть</label><br>
                        <input type="url" class="form-control form-control-lg form-dark" name="link" id="link"
                               value="{{ old('link') ?? $artist->link }}" required>
                        @error('link')
                            <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
