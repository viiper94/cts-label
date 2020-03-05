@extends('admin.layout.layout')

@section('admin-content')
    <div class="container">
        @include('admin.layout.alert')
        <form enctype="multipart/form-data" method="post">
            @csrf
            <div class="col-xs-12">
                <div id="sticker">
                    <button type='submit' class='btn btn-primary' name='edit_feedback'>
                        <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                        Сохранить
                    </button>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-5 col-xs-12 release-image">
                <img src="/images/releases/{{ $release->image ?? 'default.png' }}" id="preview">
            </div>
            <div class="col-md-7 col-xs-12">
                <div class="form-group">
                    <label>Название</label><br>
                    <input type="text" class="form-control form-control__dark" name="feedback_title" value="{{ $release->feedback->feedback_title }}" required>
                    @if($errors->has('feedback_title'))
                        <p class="help-block">{{ $errors->first('feedback_title') }}</p>
                    @endif
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="visible" {{ !$release->feedback->visible ? : 'checked' }}> Опубликовано
                    </label>
                </div>
                <div class="related-all-feedback">
                    <h4>Also available:</h4>
                    <button class="btn btn-danger deselect-btn">Deselect All</button>
                    @foreach($feedback_list as $item)
                        <div class="related">
                            <label style="margin-left: 0;">
                                <input type="checkbox" name="related[]" value="{{ $item->release_id }}" @if($release->feedback->related->contains($item)) checked @endif>{{ $item->feedback_title }}
                            </label>
                        </div>
                    @endforeach
                </div>
                @if($release->feedback->archive_name && file_exists(public_path('audio/feedback/').$release->feedback->release->id.'/'.$release->feedback->archive_name))
                    <h4>
                        <a href="/audio/feedback/{{ $release->feedback->release->id }}/{{ $release->feedback->archive_name }}">
                            Скачать архив
                        </a>
                    </h4>
                @endif
            </div>
            <div class="clearfix"></div>
            <div class="col-xs-12" id="reviews">
                @foreach($release->feedback->tracks as $key => $track)
                    @if($loop->last)
                        @php $f_index = $key @endphp
                    @endif
                    <div class="review" id="feedback-{{ $key }}">
                        <a class="delete-review-btn btn"><span class="glyphicon glyphicon-remove"></span></a>
                        <div class="form-group">
                            <label>Название трека</label><br>
                            <input type="text" class="form-control form-control__dark" name="tracks[{{ $key }}][title]" value="{{ $track['title'] }}" required>
                        </div>
                        <div class="form-group col-xs-6">
                            <label>Файл в высоком качестве</label><br>
                            <input type="file" style="font-size: 13px;" name="tracks[{{ $key }}][320]" data-id="{{ $key }}" accept=".mp3">
                        </div>
                        <div class="form-group col-xs-6">
                            <label>Файл в низком качестве</label><br>
                            <input type="file" style="font-size: 13px;" name="tracks[{{ $key }}][96]" data-id="{{ $key }}" accept=".mp3">
                        </div>
                        @if(key_exists(96, $track) && $track[96] !== '' || key_exists(320, $track) && $track[320] !== '')
                            <audio src="/audio/feedback/{{ $release->id }}/{{ $release->feedback->LQDir() }}/{{ $track[$release->feedback->LQDir()] }}" controls style="width: 100%;"></audio>
                        @endif
                        <div class="clearfix"></div>
                    </div>
                @endforeach
            </div>
            <div class="col-xs-12">
                <a class="add-review-btn btn btn-info" data-index="{{ $f_index ?? 0 }}" data-target="reviews"><span class="glyphicon glyphicon-plus"></span> Добавить</a>
            </div>
            <div class="clearfix"></div>
        </form>
    </div>

    <script type="text/html" id="reviews_template">
        <div class="review" id="feedback-%i%">
            <a class="delete-review-btn btn"><span class="glyphicon glyphicon-remove"></span></a>
            <div class="form-group">
                <label>Название трека</label><br>
                <input type="text" class="form-control form-control__dark" name="tracks[%i%][title]" required>
            </div>
            <div class="form-group col-xs-6">
                <label>Файл в высоком качестве</label><br>
                <input type="file" style="font-size: 13px;" name="tracks[%i%][320]" data-id="%i%" accept=".mp3">
            </div>
            <div class="form-group col-xs-6">
                <label>Файл в низком качестве</label><br>
                <input type="file" style="font-size: 13px;" name="tracks[%i%][96]" data-id="%i%" accept=".mp3">
            </div>
            <div class="clearfix"></div>
        </div>
    </script>

@endsection
