@extends('admin.layout.layout')

@section('admin-content')
    <div class="container-fluid">
        <button type="submit" class="btn btn-primary shadow sticky-top my-3" form="edit_release">
            <i class="fa-solid fa-floppy-disk me-2"></i>Сохранить
        </button>
        @if($feedback->id)
            <form action="{{ route('feedback.destroy', $feedback->id) }}" method="post" class="d-inline my-3">
                @method('DELETE')
                @csrf
                <button class="btn btn-outline-danger" onclick="return confirm('Удалить фидбек?')">
                    <i class="fa-solid fa-trash me-2"></i>Удалить
                </button>
            </form>
        @endif
        @if($feedback->release)
            <a href='{{ route('release', $feedback->release->id) }}' class="btn btn-outline">
                <i class="fa-solid fa-arrow-up-right-from-square me-2"></i>Релиз на сайте
            </a>
        @endif
        <form enctype="multipart/form-data" method="post" id="edit_release"
              action="{{ $feedback->id ? route('feedback.update', $feedback->id) : route('feedback.store', $feedback->release?->id) }}">
            @csrf
            @if($feedback->id)
                @method('PUT')
            @endif
            <div class="row mb-5">
                <div class="col-md-auto col-xs-12">
                    <label class="form-label">Обложка</label>
                    <div class="form-group">
                        @if(!$feedback->release)
                            <img src="/images/feedback/{{ $feedback->image ?? 'default.png' }}" id="preview" class="release-cover">
                            <input type="file" class="form-control form-dark" name="image" id="uploader" accept="image/*">
                        @else
                            <img src="/images/releases/{{ $feedback->release->image ?? 'default.png' }}" id="preview" class="release-cover">
                        @endif
                    </div>
                </div>
                <div class="col-md col-xs-12">
                    <div class="form-check mb-3">
                        <input type="hidden" name="visible" value="0">
                        <input type="checkbox" name="visible" id="visible" class="form-check-input" @checked($feedback->visible)>
                        <label for="visible" class="form-check-label">Опубликовано</label>
                    </div>
                    <div class="form-group mb-3">
                        <label for="title" class="form-label">Название</label>
                        <input type="text" class="form-control form-dark form-control-lg" name="feedback_title" id="title" value="{{ old('feedback_title') ?? $feedback->feedback_title }}" required>
                        @error('feedback_title')
                            <p class="help-block">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="card text-bg-dark related-all-feedback">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title">Also available:</h5>
                            <div class="btn-group">
                                <button class="btn btn-outline btn-sm related_last_five" type="button">
                                    <i class="fa-solid fa-list-check me-2"></i>Выбрать последние 5
                                </button>
                                <button class="btn btn-outline btn-sm deselect-btn" type="button">
                                    <i class="fa-solid fa-rectangle-xmark me-2"></i>Снять выбор
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach($feedback_list as $item)
                                @if(!$feedback->release || $item->release_id != $feedback->release->id)
                                    <div class="form-check mb-2">
                                        <input type="checkbox" name="related[]" id="also-{{ $item->release_id }}"
                                               value="{{ $item->id }}" class="form-check-input" @checked($feedback->related->contains($item))>
                                        <label for="also-{{ $item->release_id }}" class="form-check-label">{{ $item->feedback_title }}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12" id="reviews">
                @foreach($feedback->tracks as $key => $track)
                    <div class="review" id="feedback-{{ $key }}">
                        <a class="delete-review-btn btn"><span class="glyphicon glyphicon-remove"></span></a>
                        <div class="form-group">
                            <label>Название трека</label>
                            <input type="text" class="form-control form-dark" name="tracks[{{ $key }}][title]" value="{{ $track['title'] }}" required>
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
