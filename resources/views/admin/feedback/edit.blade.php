@extends('admin.layout.layout')

@section('title')
    {{ $feedback->feedback_title ?? 'Новый фидбек' }} | CTS Records Admin Panel
@endsection

@section('admin-content')
    <div class="container-fluid edit-feedback">
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
            <a href='{{ route('feedback', $feedback->slug) }}' class="btn btn-outline" target="_blank">
                <i class="fa-solid fa-comment me-2"></i>Смотреть фидбек
            </a>
            <button type="button" class="btn btn-outline" data-bs-target="#feedbackModal" data-bs-toggle="modal">
                <i class="fa-solid fa-envelopes-bulk me-2"></i>Рассылка
            </button>
        @endif
        @if($feedback->release)
            <a href='{{ route('release', $feedback->release->id) }}' class="btn btn-outline" target="_blank">
                <i class="fa-solid fa-arrow-up-right-from-square me-2"></i>Релиз на сайте
            </a>
        @endif
        <form enctype="multipart/form-data" method="post" id="edit_release" class="mb-3"
              action="{{ $feedback->id ? route('feedback.update', $feedback->id) : route('feedback.store', $feedback->release?->id) }}">
            @csrf
            @if($feedback->id)
                @method('PUT')
            @endif
            <div class="row mb-5">
                <div class="col-xl-auto col-xs-12">
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
                <div class="col-xl col-xs-12">
                    <div class="form-group mb-3">
                        <label for="title" class="form-label">Название</label>
                        <input type="text" class="form-control form-dark form-control-lg" name="feedback_title" id="title" value="{{ old('feedback_title') ?? $feedback->feedback_title }}" required>
                        @error('feedback_title')
                            <p class="help-block">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-check mb-3">
                        <input type="hidden" name="visible" value="0">
                        <input type="checkbox" name="visible" id="visible" class="form-check-input" @checked($feedback->visible)>
                        <label for="visible" class="form-check-label">Опубликовано</label>
                    </div>
                    <div class="card text-bg-dark related-all-feedback">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title">Also available:</h5>
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
                        <div class="card-footer">
                            <div class="btn-group">
                                <button class="btn btn-outline btn-sm related_last_five" type="button">
                                    <i class="fa-solid fa-list-check me-2"></i>Выбрать последние 5
                                </button>
                                <button class="btn btn-outline btn-sm deselect-btn" type="button">
                                    <i class="fa-solid fa-rectangle-xmark me-2"></i>Снять выбор
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(!$feedback->release)
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="description form-group mb-3">
                            <label for="description_en">Описание (англ.)</label>
                            <textarea name="description_en" id="description_en">{!! old('description_en') ?? $feedback->description_en !!}</textarea>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="description form-group mb-3">
                            <label for="description_ua">Описание (укр.)</label>
                            <textarea name="description_ua" id="description_ua">{!! old('description_ua') ?? $feedback->description_ua !!}</textarea>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="description form-group mb-3">
                            <label for="description_ru">Описание (рус.)</label>
                            <textarea name="description_ru" id="description_ru">{!! old('description_ru') ?? $feedback->description_ru !!}</textarea>
                        </div>
                    </div>
                </div>
            @endif
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Треки</h3>
                @if($feedback->hasArchive())
                    <a href="/audio/feedback/{{ $feedback->slug }}/{{ $feedback->archive_name }}" class="btn btn-outline btn-sm">
                        <i class="fa-solid fa-file-zipper me-2"></i>Скачать архив
                    </a>
                @endif
            </div>
            <div class="row g-0">
                <div class="tracks col-12">
                    @foreach($feedback->tracks as $key => $track)
                        @include('admin.feedback.track_item', compact('key', 'track'))
                    @endforeach
                </div>
                <div class="col-12">
                    <a class="add-track-btn btn btn-outline" data-index="{{ count($feedback->tracks) }}">
                        <i class="fa-solid fa-plus me-2"></i>Добавить трек
                    </a>
                </div>

            </div>
        </form>

        @if($feedback->results->count() > 0)
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Фидбеки</h3>
            </div>
            <div class="accordion mb-3" id="accordion">
                @foreach($feedback->results as $key => $result)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading_{{ $key }}">
                            <button class="accordion-button text-bg-dark" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse_{{ $key }}" aria-expanded="true" aria-controls="collapse_{{ $key }}">
                                <b>{{ $result->name }}</b>&nbsp;<i>({{ $result->created_at }})</i>
                            </button>
                        </h2>
                        <div id="collapse_{{ $key }}" class="accordion-collapse collapse" aria-labelledby="heading_{{ $key }}" data-bs-parent="#accordion">
                            <div class="accordion-body text-bg-dark">
                                <p><i class="fa-solid fa-envelope me-2"></i>E-mail: <b>{{ $result->email }}</b></p>
                                <p class="mb-0"><i class="fa-solid fa-star me-2"></i><b>Оценки</b>:</p>
                                <ul style="list-style: none" class="mb-3">
                                    @foreach($result->rates as $track => $score)
                                        <li><b>{{ $score }}</b>: "{{ $track }}"</li>
                                    @endforeach
                                </ul>
                                @if($result->best_track)
                                    <p><i class="fa-solid fa-heart me-2"></i>Best track: <b>{{ $result->best_track }}</b></p>
                                @endif
                                <p class="mb-0"><i class="fa-solid fa-comment me-2"></i>Коммент:</p>
                                <p><b>{!! nl2br(e($result->comment)) !!}</b></p>
                                <form action="{{ route('feedback.deleteResult', $result->id) }}" method="post" class="mt-3">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-feedback-result-btn btn btn-outline-danger btn-sm"
                                       onclick="return confirm('Вы уверены, что хотите удалить?')">
                                        <i class="fa-solid fa-trash me-2"></i>Удалить
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('feedback.emailing') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $feedback->id }}">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Рассылка фидбека</h1>
                        <button type="button" class="btn btn-outline" data-bs-dismiss="modal"><i class="fa-solid fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        @if($feedback->emeiling_sent)
                            <p class="text-warning">Рассылка по данному фидбеку уже была</p>
                        @endif
                        <h6>Выберите каналы, по которым запускать рассылку</h6>
                        @foreach($emailing_channels as $item)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="channels[]" value="{{ $item->id }}" id="{{ $item->id }}">
                                <label class="form-check-label" for="{{ $item->id }}">
                                    <b>{{ $item->title }}</b> <small>({{ $item->subscribers_count }})</small>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-play me-2"></i>Запустить рассылку</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(!$feedback->release)
        <script>
            ClassicEditor
                .create(document.querySelector('#description_en'))
                .then(newEditor => {
                    enEditor = newEditor;
                });
            ClassicEditor.create(document.querySelector('#description_ru'))
                .then(newEditor => {
                    ruEditor = newEditor;
                });
            ClassicEditor.create(document.querySelector('#description_ua'))
                .then(newEditor => {
                    uaEditor = newEditor;
                });
            ClassicEditor.create(document.querySelector('#tracklist'));
        </script>
    @endif

@endsection

@section('assets')
    <script src="/js/ckeditor.js"></script>
    <link rel="stylesheet" href="/css/ckeditor.css">
@endsection
