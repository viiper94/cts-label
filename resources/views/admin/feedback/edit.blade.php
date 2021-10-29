@extends('admin.layout.layout')

@section('admin-content')
    @if($errors->any())
        @dd($errors->first())
    @endif
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
                    @if($feedback->release)
                        <a href='{{ route('release', $feedback->release->id) }}' class='btn btn-success' name='edit_feedback'>
                            <span class='glyphicon glyphicon-share' aria-hidden='true'></span>
                            Релиз на сайте
                        </a>
                    @endif
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-5 col-xs-12 release-image">
                <label>Обложка</label><br>
                @if(!$feedback->release)
                    <img src="/images/feedback/{{ $feedback->image ?? 'default.png' }}" id="preview">
                    <input type="file"  name="image" value="{{ $feedback->image }}" accept="image/*">
                @else
                    <img src="/images/releases/{{ $feedback->release->image ?? 'default.png' }}" id="preview">
                @endif
            </div>
            <div class="col-md-7 col-xs-12">
                <div class="form-group">
                    <label>Название</label><br>
                    <input type="text" class="form-control form-control__dark" name="feedback_title" value="{{ $feedback->feedback_title }}" required>
                    @if($errors->has('feedback_title'))
                        <p class="help-block">{{ $errors->first('feedback_title') }}</p>
                    @endif
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="visible" {{ !$feedback->visible ? : 'checked' }}> Опубликовано
                    </label>
                </div>
                <div class="related-all-feedback">
                    <h4>Also available:</h4>
                    <button class="btn btn-primary related_last_five">Выбрать последние 5</button>
                    <button class="btn btn-danger deselect-btn">Снять выбор</button>
                    @foreach($feedback_list as $item)
                        <div class="related">
                            @if(!$feedback->release || $item->release_id != $feedback->release->id)
                                <label style="margin-left: 0;">
                                    <input type="checkbox" name="related[]" value="{{ $item->id }}"
                                           @if($feedback->related->contains($item)) checked @endif>{{ $item->feedback_title }}
                                </label>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-xs-12" id="reviews">
                @foreach($feedback->tracks as $key => $track)
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
                            <audio src="/audio/feedback/{{ $feedback->slug }}/{{ $feedback->LQDir() }}/{{ $track[$feedback->LQDir()] }}" controls style="width: 100%;"></audio>
                        @endif
                        <div class="clearfix"></div>
                    </div>
                @endforeach
            </div>
            <div class="col-xs-12">
                <a class="add-review-btn btn btn-info" data-index="{{ $f_index ?? 0 }}" data-target="reviews"><span class="glyphicon glyphicon-plus"></span> Добавить</a>
                @if($feedback->archive_name && file_exists(public_path('audio/feedback/').$feedback->slug.'/'.$feedback->archive_name))
                    <a href="/audio/feedback/{{ $feedback->slug }}/{{ $feedback->archive_name }}" class="btn btn-success">
                        <span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span>
                        Скачать архив
                    </a>
                @endif
            </div>
            <div class="clearfix"></div>
        </form>

        @if($feedback->results->count() > 0)
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                @foreach($feedback->results as $key => $result)
                    <div class="panel panel__dark panel-default panel-default__dark">
                        <a class="delete-feedback-result-btn btn" href="/cts-admin/feedback/removeResult/{{ $result->id }}"
                            onclick="return confirm('Вы уверены, что хотите удалить?')">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                        <div class="panel-heading panel-heading__dark" role="tab" id="heading_{{ $key }}">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $key }}" aria-expanded="false" aria-controls="collapse_{{ $key }}">
                                    Фидбэк от {{ $result->name }} ({{ $result->created_at }})
                                </a>
                            </h4>
                        </div>
                        <div id="collapse_{{ $key }}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_{{ $key }}">
                            <div class="panel-body panel-body__dark">
                                 E-mail: <b>{{ $result->email }}</b><br><br>
                                <b>Оценки</b>:<br>
                                @foreach($result->rates as $track => $score)
                                    <b>{{ $score }}</b>: "{{ $track }}"<br>
                                @endforeach
                                <br>
                                @if($result->best_track)
                                    Best track: <b>{{ $result->best_track }}</b><br>
                                @endif
                                Коммент: <b>{!! nl2br(e($result->comment)) !!}</b>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
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
