@extends('admin.layout.layout')

{{--@section('scripts')--}}
{{--    <script src="/assets/js/ckeditor/ckeditor.js"></script>--}}
{{--@endsection--}}

@section('admin-content')
    <div class="container">
        @include('admin.layout.alert')
        <form enctype="multipart/form-data" method="post">
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
{{--            <div class="col-xs-12">--}}
{{--                <div class="description form-group">--}}
{{--                    <label class="en">Описание (англ.)</label>--}}
{{--                    <textarea name="description_en" id="description_en">{!! $artist->description_en !!}</textarea>--}}
{{--                </div>--}}
{{--                <div class="description form-group">--}}
{{--                    <label class="en">Описание (рус.)</label>--}}
{{--                    <a class="translate_description" data-to-lang="ru">--}}
{{--                        <span class="glyphicon glyphicon-text-height"></span> Перевести на русский--}}
{{--                    </a>--}}
{{--                    <textarea name="description_ru" id="description_ru">{!! $artist->description_ru !!}</textarea>--}}
{{--                </div>--}}
{{--                <div class="description form-group">--}}
{{--                    <label class="en">Описание (укр.)</label>--}}
{{--                    <a class="translate_description" data-to-lang="uk">--}}
{{--                        <span class="glyphicon glyphicon-text-height"></span> Перевести на украинский--}}
{{--                    </a>--}}
{{--                    <textarea name="description_ua" id="description_uk">{!! $artist->description_ua !!}</textarea>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="clearfix"></div>
            <button type='submit' class='btn btn-primary' name='edit_artist'>
                <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                Сохранить
            </button>
        </form>
    </div>
{{--    <script type="text/javascript">--}}
{{--        CKEDITOR.replace('description_en');--}}
{{--    </script>--}}
{{--    <script type="text/javascript">--}}
{{--        CKEDITOR.replace('description_ru');--}}
{{--    </script>--}}
{{--    <script type="text/javascript">--}}
{{--        CKEDITOR.replace('description_uk');--}}
{{--    </script>--}}
@endsection
