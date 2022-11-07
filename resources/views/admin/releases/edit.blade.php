@extends('admin.layout.layout')

@section('title')
    {{ $release->title }} | CTS Records Admin Panel
@endsection

@section('admin-content')
    <div class="container-fliud">
        <form enctype="multipart/form-data" method="post" action="{{ $release->id ? route('releases.update', $release->id) : route('releases.store') }}">
            @csrf
            @if($release->id)
                @method('PUT')
            @endif
            <div class="sticky-top my-3">
                <button type="submit" class="btn btn-primary shadow" name="edit_release">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Сохранить
                </button>
            </div>
            <div class="row">
                <div class="col-md-5 col-xs-12">
                    <img src="/images/releases/{{ $release->image ?? 'default.png' }}" id="preview" class="img-fluid">
                    <input type="file" name="image" id="uploader" accept="image/jpeg, image/png">
                    @error('image')
                        <p class="help-block">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="form-group mb-3">
                        <label class="form-label">Название</label><br>
                        <input type="text" class="form-control form-dark" name="title" value="{{ old('title') ?? $release->title }}" required>
                        @error('title')
                            <p class="help-block">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Номер</label><br>
                        <input type="text" class="form-control form-dark" name="release_number" value="{{ old('release_number') ?? $release->release_number }}">
                        @error('release_number')
                            <p class="help-block">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Дата</label><br>
                        <input type="text" class="form-control form-dark" name="release_date" id="release_date"
                               value="{{ old('release_date') ?? $release->release_date?->format('d F Y') }}" autocomplete="off">
                        @error('release_date')
                            <p class="help-block">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Beatport</label><br>
                        <input type="text" class="form-control form-dark" name="beatport" value="{{ old('beatport') ?? $release->beatport }}">
                        @error('beatport')
                            <p class="help-block">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Youtube</label><br>
                        <input type="text" class="form-control form-dark" name="youtube" value="{{ old('youtube') ?? $release->youtube }}">
                        @error('youtube')
                            <p class="help-block">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-check mb-3">
                        <input type="hidden" name="visible" value="0">
                        <input type="checkbox" name="visible" id="visible" class="form-check-input" @checked($release->visible)>
                        <label for="visible" class="form-check-label">Опубликовано</label>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="description form-group">
                    <label class="en">Описание (англ.)</label>
                    <textarea name="description_en" id="description_en">{!! old('description_en') ?? $release->description_en !!}</textarea>
                </div>
                <div class="description form-group">
                    <label class="en">Описание (рус.)</label>
                    <a class="translate_description" data-to-lang="ru">
                        <span class="glyphicon glyphicon-text-height"></span> Перевести на русский
                    </a>
                    <textarea name="description_ru" id="description_ru">{!! old('description_ru') ?? $release->description_ru !!}</textarea>
                </div>
                <div class="description form-group">
                    <label class="en">Описание (укр.)</label>
                    <a class="translate_description" data-to-lang="uk">
                        <span class="glyphicon glyphicon-text-height"></span> Перевести на украинский
                    </a>
                    <textarea name="description_ua" id="description_uk">{!! old('description_ua') ?? $release->description_ua !!}</textarea>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="description form-group">
                    <label class="en">Треклист</label>
                    <textarea name="tracklist" id="tracklist">{!! old('tracklist') ?? $release->tracklist !!}</textarea>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-6 col-xs-12 related-all-releases">
                <h5>Related tracks:</h5>
                <button class="btn btn-danger deselect-btn">Deselect All</button>
                @foreach($release_list as $item)
                    <div class="related">
                        <a class="page-link" href="{{ route('release', $item->id) }}" target="_blank">Visit page</a>
                        <label>
                            <input type="checkbox" name="related[]" value="{{ $item->id }}"
                                   @checked(
                                        (old() && is_array(old('related')) && in_array($item->id, old('related'))) ||
                                        (!old() && $release->related->contains($item)))/>
                            {{ $item->title }}
                        </label>
                    </div>
                @endforeach
            </div>
            <div class="col-md-6 col-xs-12 related-release-search ">
                <h5>Search related tracks:</h5>
                <input type="text" class="search-form form-control form-control__dark" id='search-related' placeholder="Search release" data-release-id="{{ $release->id }}">
                <label><input type="radio" name="search-by" value="title" checked>По заголовку</label>
                <label><input type="radio" name="search-by" value="tracklist">По треклисту</label>
                <div class="checked-releases"></div>
                <div class="item-list"></div>
            </div>
        </form>
    </div>
    <script>
        ClassicEditor.create(document.querySelector('#description_en'));
        ClassicEditor.create(document.querySelector('#description_ru'));
        ClassicEditor.create(document.querySelector('#description_uk'));
        ClassicEditor.create(document.querySelector('#tracklist'));
    </script>
@endsection

@section('assets')
    <script src="/js/ckeditor.js"></script>
    <link rel="stylesheet" href="/css/ckeditor.css">
@endsection
