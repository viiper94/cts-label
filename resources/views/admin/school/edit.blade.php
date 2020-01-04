@extends('admin.layout.layout')

@section('admin-content')
    <div class="container">
        @include('admin.layout.alert')
        <form enctype="multipart/form-data" method="post">
            @csrf
            <div class="col-md-4 col-xs-12 release-image">
                <img src="/images/school/courses/{{ $course->image ?? 'default.png' }}" id="preview">
                <input type="file" name="image" id="uploader" accept="image/jpeg, image/png">
                @if($errors->has('image'))
                    <p class="help-block">{{ $errors->first('image') }}</p>
                @endif
            </div>
            <div class="col-md-8 col-xs-12">
                <div class="form-group">
                    <label>Язык</label><br>
                    <select class="form-control form-control__dark" name="lang" required>
                        <option @if($course->lang === 'en') selected @endif value="en">English</option>
                        <option @if($course->lang === 'ru') selected @endif value="ru">Русский</option>
                        <option @if($course->lang === 'ua') selected @endif value="ua">Українська</option>
                    </select>
                    @if($errors->has('lang'))
                        <p class="help-block">{{ $errors->first('lang') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label>Название услуги</label><br>
                    <input type="text" class="form-control form-control__dark" name="name" value="{{ $course->name }}" required>
                    @if($errors->has('name'))
                        <p class="help-block">{{ $errors->first('name') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label>Ключевые слова</label><br>
                    <textarea name="course_alt" id="course_alt" cols="30" rows="7" class="form-control form-control__dark">{{ $course->course_alt }}</textarea>
                    @if($errors->has('course_alt'))
                        <p class="help-block">{{ $errors->first('course_alt') }}</p>
                    @endif
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="visible" {{ !$course->visible ? : 'checked' }}> Опубликовано
                    </label>
                </div>
            </div>
            <div class="clearfix"></div>
            <button type='submit' class='btn btn-primary' name='edit_course'>
                <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                Сохранить
            </button>
        </form>
    </div>
@endsection
