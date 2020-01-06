@extends('admin.layout.layout')

@section('scripts')
    <script src="/assets/js/ckeditor/ckeditor.js"></script>
@endsection

@section('admin-content')
    <div class="container">
        @include('admin.layout.alert')
        <form enctype="multipart/form-data" method="post">
            @csrf
            <div class="col-md-4 col-xs-12 release-image">
                <img src="/images/school/teachers/{{ $teacher->image ?? 'default.png' }}" id="preview" class="teacher-img">
                <input type="file" name="image" id="uploader" accept="image/jpeg, image/png">
                @if($errors->has('image'))
                    <p class="help-block">{{ $errors->first('image') }}</p>
                @endif
            </div>
            <div class="col-md-8 col-xs-12">
                <div class="form-group">
                    <label>Язык</label><br>
                    <select class="form-control form-control__dark" name="lang" required>
                        <option @if($teacher->lang === 'en') selected @endif value="en">English</option>
                        <option @if($teacher->lang === 'ru') selected @endif value="ru">Русский</option>
                        <option @if($teacher->lang === 'ua') selected @endif value="ua">Українська</option>
                    </select>
                    @if($errors->has('lang'))
                        <p class="help-block">{{ $errors->first('lang') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label>Имя преподавателя</label><br>
                    <input type="text" class="form-control form-control__dark" name="name" value="{{ $teacher->name }}" required>
                    @if($errors->has('name'))
                        <p class="help-block">{{ $errors->first('name') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label>Информация</label><br>
                    <textarea name="teacher_binfo" id="teacher_binfo" cols="30" rows="7" class="form-control form-control__dark" required>{{ $teacher->teacher_binfo }}</textarea>
                    @if($errors->has('teacher_binfo'))
                        <p class="help-block">{{ $errors->first('teacher_binfo') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label>Информация спрятаная</label><br>
                    <textarea name="teacher_hinfo" id="teacher_hinfo" cols="30" rows="7" class="form-control form-control__dark">{{ $teacher->teacher_hinfo }}</textarea>
                    @if($errors->has('teacher_hinfo'))
                        <p class="help-block">{{ $errors->first('teacher_hinfo') }}</p>
                    @endif
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="visible" {{ !$teacher->visible ? : 'checked' }}> Опубликовано
                    </label>
                </div>
            </div>
            <div class="clearfix"></div>
            <button type='submit' class='btn btn-primary' name='edit_teacher'>
                <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                Сохранить
            </button>
        </form>
    </div>
    <script type="text/javascript">
        CKEDITOR.replace('teacher_binfo');
    </script>
    <script type="text/javascript">
        CKEDITOR.replace('teacher_hinfo');
    </script>
@endsection
