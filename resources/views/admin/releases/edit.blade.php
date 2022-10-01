@extends('admin.layout.layout')

@section('assets')
    <link href="/assets/js/gijgo/css/gijgo.min.css" rel="stylesheet">
@endsection

@section('scripts')
    <script src="/assets/js/ckeditor/ckeditor.js"></script>
    <script src="/assets/js/gijgo/js/gijgo.min.js"></script>
@endsection

@section('admin-content')
    <div class="container">
        @include('admin.layout.alert')
        <form enctype="multipart/form-data" method="post">
            @csrf
            <div class="col-xs-12">
                <div id="sticker">
                    <button type='submit' class='btn btn-primary' name='edit_release'>
                        <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                        Сохранить
                    </button>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-5 col-xs-12 release-image">
                <img src="/images/releases/{{ $release->image ?? 'default.png' }}" id="preview">
                <input type="file" name="image" id="uploader" accept="image/jpeg, image/png">
                @if($errors->has('image'))
                    <p class="help-block">{{ $errors->first('image') }}</p>
                @endif
            </div>
            <div class="col-md-7 col-xs-12">
                <div class="form-group">
                    <label>Название</label><br>
                    <input type="text" class="form-control form-control__dark" name="title" value="{{ $release->title }}" required>
                    @if($errors->has('title'))
                        <p class="help-block">{{ $errors->first('title') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label>Номер</label><br>
                    <input type="text" class="form-control form-control__dark" name="release_number" value="{{ $release->release_number }}">
                    @if($errors->has('release_number'))
                        <p class="help-block">{{ $errors->first('release_number') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label>Дата</label><br>
                    <input type="text" class="form-control form-control__dark" name="release_date" id="release_date"
                           value="{{ !$release->release_date ? '' : $release->release_date->format('d F Y') }}" autocomplete="off">
                    @if($errors->has('release_date'))
                        <p class="help-block">{{ $errors->first('release_date') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label>Beatport</label><br>
                    <input type="text" class="form-control form-control__dark" name="beatport" value="{{ $release->beatport }}">
                    @if($errors->has('beatport'))
                        <p class="help-block">{{ $errors->first('beatport') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label>Youtube</label><br>
                    <input type="text" class="form-control form-control__dark" name="youtube" value="{{ $release->youtube }}">
                    @if($errors->has('youtube'))
                        <p class="help-block">{{ $errors->first('youtube') }}</p>
                    @endif
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="visible" {{ !$release->visible ? : 'checked' }}> Опубликовано
                    </label>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="description form-group">
                    <label class="en">Описание (англ.)</label>
                    <textarea name="description_en" id="description_en">{!! $release->description_en !!}</textarea>
                </div>
                <div class="description form-group">
                    <label class="en">Описание (рус.)</label>
                    <a class="translate_description" data-to-lang="ru">
                        <span class="glyphicon glyphicon-text-height"></span> Перевести на русский
                    </a>
                    <textarea name="description_ru" id="description_ru">{!! $release->description_ru !!}</textarea>
                </div>
                <div class="description form-group">
                    <label class="en">Описание (укр.)</label>
                    <a class="translate_description" data-to-lang="uk">
                        <span class="glyphicon glyphicon-text-height"></span> Перевести на украинский
                    </a>
                    <textarea name="description_ua" id="description_uk">{!! $release->description_ua !!}</textarea>
                </div>
                <div class="description form-group">
                    <label class="en">Треклист</label>
                    <textarea name="tracklist" id="tracklist">{!! $release->tracklist !!}</textarea>
                </div>
            </div>
            <div class="col-md-6 col-xs-12 related-all-releases">
                <h5>Related tracks:</h5>
                <button class="btn btn-danger deselect-btn">Deselect All</button>
                @foreach($release_list as $item)
                    <div class="related">
                        <a class="page-link" href="{{ route('release', $item->id) }}" target="_blank">Visit page</a>
                        <label>
                            <input type="checkbox" name="related[]" value="{{ $item->id }}" @if($release->related->contains($item)) checked @endif/>{{ $item->title }}
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
        $('#release_date').datepicker({
            uiLibrary: 'bootstrap',
            format: 'dd mmmm yyyy'
        });
    </script>
    <script type="text/javascript">
        CKEDITOR.replace('description_en');
    </script>
    <script type="text/javascript">
        CKEDITOR.replace('description_ru');
    </script>
    <script type="text/javascript">
        CKEDITOR.replace('description_uk');
    </script>
    <script type="text/javascript">
        CKEDITOR.replace('tracklist');
    </script>
@endsection
