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
        @endif
        <a href='{{ route('feedback', $feedback->slug) }}' class="btn btn-outline" target="_blank">
            <i class="fa-solid fa-comment me-2"></i>Смотреть фидбек
        </a>
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
