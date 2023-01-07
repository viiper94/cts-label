@extends('admin.layout.layout')

@section('title')
    {{ $release->title ?? 'Новый релиз' }} | CTS Records Admin Panel
@endsection

@section('admin-content')
    <div class="container-fluid">
        <button type="submit" class="btn btn-primary shadow sticky-top my-3" form="edit_release">
            <i class="fa-solid fa-floppy-disk me-2"></i>Сохранить
        </button>
        @if($release->id)
            <form action="{{ route('releases.destroy', $release->id) }}" method="post" class="d-inline my-3">
                @method('DELETE')
                @csrf
                <button class="btn btn-outline-danger" onclick="return confirm('Удалить релиз?')">
                    <i class="fa-solid fa-trash me-2"></i>Удалить
                </button>
            </form>
        @endif
        <form enctype="multipart/form-data" method="post" id="edit_release"
              action="{{ $release->id ? route('releases.update', $release->id) : route('releases.store') }}">
            @csrf
            @if($release->id)
                @method('PUT')
            @endif
            <div class="row">
                <div class="col-md-auto col-xs-12 mb-3">
                    <img src="/images/releases/{{ $release->image ?? 'default.png' }}" id="preview" class="release-cover img-fluid">
                    <input type="file" name="image" class="form-control form-dark" id="uploader" accept="image/jpeg, image/png">
                    @error('image')
                        <p class="help-block text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md col-xs-12 mb-3">
                    <div class="form-check mb-3">
                        <input type="hidden" name="visible" value="0">
                        <input type="checkbox" name="visible" id="visible" class="form-check-input" @checked($release->visible)>
                        <label for="visible" class="form-check-label">Опубликовано</label>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Название</label><br>
                        <input type="text" class="form-control form-dark" name="title" value="{{ old('title') ?? $release->title }}" required>
                        @error('title')
                            <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Жанр</label><br>
                        <input type="text" class="form-control form-dark" name="genre" value="{{ old('genre') ?? $release->genre }}">
                        @error('genre')
                            <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Номер</label><br>
                        <input type="text" class="form-control form-dark" name="release_number" value="{{ old('release_number') ?? $release->release_number }}">
                        @error('release_number')
                            <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Дата</label><br>
                        <input type="hidden" name="release_date" id="release_date"
                               value="{{ old('release_date') ?? $release->release_date?->format('d F Y') }}">
                        @error('release_date')
                            <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Beatport</label><br>
                        <input type="text" class="form-control form-dark" name="beatport" value="{{ old('beatport') ?? $release->beatport }}">
                        @error('beatport')
                            <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Youtube</label><br>
                        <input type="text" class="form-control form-dark" name="youtube" value="{{ old('youtube') ?? $release->youtube }}">
                        @error('youtube')
                            <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-xs-12 col-md-7">
                    <div class="description form-group mb-3">
                        <label class="en">Описание (англ.)</label>
                        <textarea name="description_en" id="description_en">{!! old('description_en') ?? $release->description_en !!}</textarea>
                    </div>
                    <div class="description form-group mb-3">
                        <div class="d-flex justify-content-between">
                            <label class="en">Описание (рус.)</label>
                            <a class="btn btn-sm btn-outline translate_description" data-to-lang="ru">
                                <i class="fa-solid fa-language me-2"></i>Перевести на русский
                            </a>
                        </div>
                        <textarea name="description_ru" id="description_ru">{!! old('description_ru') ?? $release->description_ru !!}</textarea>
                    </div>
                    <div class="description form-group mb-3">
                        <div class="d-flex justify-content-between">
                            <label class="en">Описание (укр.)</label>
                            <a class="btn btn-sm btn-outline translate_description" data-to-lang="uk">
                                <i class="fa-solid fa-language me-2"></i>Перевести на украинский
                            </a>
                        </div>
                        <textarea name="description_ua" id="description_uk">{!! old('description_ua') ?? $release->description_ua !!}</textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-md-5">
                    <div class="description form-group mb-3">
                        <label class="en">Треклист</label>
                        <textarea name="tracklist" id="tracklist">{!! old('tracklist') ?? $release->tracklist !!}</textarea>
                    </div>
                </div>
            </div>
            <div class="card text-bg-dark mb-5">
                    <button class="card-header p-3 accordion-button collapsed justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRelated" aria-expanded="false" aria-controls="collapseRelated">
                        <span class="badge text-bg-primary me-2">{{ count($release->related) }}</span>Related tracks:
                    </button>
                <div id="collapseRelated" class="collapse">
                    <div class="card-body row g-0 flex-column-reverse flex-md-row">
                        <div class="col-md-6 col-xs-12 related-all-releases">
                            <button class="btn btn-sm btn-outline-danger deselect-btn"><i class="fa-solid fa-square-xmark me-2"></i>Снять выбор</button>
                            @foreach($release_list as $item)
                                <div class="related d-flex mb-1 form-check-inline">
                                    <a class="me-4" href="{{ route('release', $item->id) }}" target="_blank">Релиз на сайте</a>
                                    <input type="checkbox" name="related[]" class="form-check-input me-2" value="{{ $item->id }}" id="related-{{ $item->id }}"
                                        @checked(
                                             (old() && is_array(old('related')) && in_array($item->id, old('related'))) ||
                                             (!old() && $release->related->contains($item)))/>
                                    <label for="related-{{ $item->id }}" class="form-check-label">{{ $item->title }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-6 col-xs-12 related-release-search mb-3">
                            <div class="row">
                                <input type="text" class="search-form form-control form-dark col" id='search-related' placeholder="Поиск по релизам" data-release-id="{{ $release->id }}">
                                <div class="radios col-auto">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="search-by" value="title" id="search-by-title" checked>
                                        <label class="form-check-label" for="search-by-title">По заголовку</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="search-by" value="tracklist" id="search-by-tracklist">
                                        <label class="form-check-label" for="search-by-tracklist">По треклисту</label>
                                    </div>
                                </div>
                            </div>
                            <div class="checked-releases mt-3"></div>
                            <div class="item-list mt-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        const picker = new Litepicker({
            element: document.getElementById('release_date'),
            inlineMode: true,
            lang: 'ru-RU',
            dropdowns: {
                "minYear": 2000,
                "maxYear": null,
                "months": true,
                "years": true
            }
        });
        ClassicEditor
            .create(document.querySelector('#description_en'))
            .then(newEditor => {
                enEditor = newEditor;
            });
        ClassicEditor.create(document.querySelector('#description_ru'))
            .then(newEditor => {
                ruEditor = newEditor;
            });
        ClassicEditor.create(document.querySelector('#description_uk'))
            .then(newEditor => {
                uaEditor = newEditor;
            });
        ClassicEditor.create(document.querySelector('#tracklist'));
    </script>
@endsection

@section('assets')
    <script src="/js/ckeditor.js"></script>
    <link rel="stylesheet" href="/css/ckeditor.css">
@endsection
