@extends('admin.layout.layout')

@section('admin-content')
    <div class="container-fluid">
        <form enctype="multipart/form-data" method="post"
              action="{{ $review->id ? route('reviews.update', $review->id) : route('reviews.store') }}">
            @if($review->id)
                @method('PUT')
            @endif
            @csrf
            <button type="submit" class="btn btn-primary shadow sticky-top my-3" form="edit_release">
                <i class="fa-solid fa-floppy-disk me-2"></i>Сохранить
            </button>
            <div class="row">
                <div class="col-md-7 col-xs-12">
                    <div class="form-group mb-3">
                        <label class="form-label" for="track">Трек</label>
                        <input type="text" class="form-control form-dark form-control-lg" name="track" id="track" value="{{ $review->track }}" required>
                        @error('track')
                        <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-check mb-3">
                        <input type="hidden" name="visible" value="0">
                        <input type="checkbox" name="visible" id="visible" class="form-check-input" @checked($review->visible)>
                        <label for="visible" class="form-check-label">Опубликовано</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7 col-xs-12">
                    <div id="reviews" class="mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="mb-0">Ревью:</h3>
                            <a class="add-review-btn btn btn-outline sticky-top" data-index="{{ $r_index ?? 0 }}" data-target="reviews">
                                <i class="fa-solid fa-plus me-2"></i>Добавить ревью
                            </a>
                        </div>
                        @if($review->data['reviews'])
                            @foreach($review->data['reviews'] as $key => $item)
                                @if($loop->last)
                                    @php $r_index = $key @endphp
                                @endif
                                <div class="card mb-3 text-bg-dark" id="review-{{ $key }}">
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Автор:</label>
                                            <input type="text" class="form-control form-dark" name="review[{{ $key }}][author]" value="{{ $item['author'] }}" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label">Локация:</label>
                                            <input type="text" class="form-control form-dark" name="review[{{ $key }}][location]" value="{{ $item['location'] }}">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label">Ревью:</label>
                                            <textarea class="form-control form-dark" name="review[{{ $key }}][review]" required>{{ $item['review'] }}</textarea>
                                        </div>
                                        <div class="scores">
                                            <label class="me-3">Оценка:</label>
                                            @for($i = 1; $i <= 5; $i-=-1)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="review[{{ $key }}][score]"
                                                           value="{{ $i }}" id="review-{{ $key }}-score-{{ $i }}" @checked($item['score'] == $i)>
                                                    <label class="form-check-label" for="review-{{ $key }}-score-{{ $i }}">{{ $i }}</label>
                                                </div>
                                            @endfor
                                        </div>

                                    </div>
                                    <div class="card-footer justify-content-end">
                                        <button class="btn btn-outline-danger delete-review-btn"><i class="fa-solid fa-trash me-2"></i>Удалить</button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div id="additional">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="mb-0">Also supported:</h3>
                            <a class="add-review-btn btn btn-outline" data-index="{{ $a_index ?? 0 }}" data-target="additional">
                                <i class="fa-solid fa-plus me-2"></i>Добавить
                            </a>
                        </div>
                        @if($review->data['additional'])
                            @foreach($review->data['additional'] as $key => $item)
                                @if($loop->last)
                                    @php $a_index = $key @endphp
                                @endif
                                <div class="review card text-bg-dark mb-3" id="additional-{{ $key }}>">
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Автор:</label>
                                            <input class="form-control form-dark" type="text" name="additional[{{ $key }}][author]" value="{{ $item['author'] }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Локация:</label>
                                            <input class="form-control form-dark" type="text" name="additional[{{ $key }}][location]" value="{{ $item['location'] }}">
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button class="btn btn-outline-danger delete-review-btn"><i class="fa-solid fa-trash me-2"></i>Удалить</button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-md-5 col-xs-12 search-reviewer">
                    <div class="form-group">
                        <input type="text" class="search-form form-control form-dark" id="search-reviewer" placeholder="Поиск автора ревью">
                    </div>
                    <div class="founded mt-3"></div>
                </div>
            </div>
        </form>
    </div>

    <script type="text/html" id="reviews_template">
        <div class="review" id="review-%i%">
            <a class="delete-review-btn btn"><span class="glyphicon glyphicon-remove"></span></a>
            <div class="form-group">
                <label>Автор:</label>
                <input class="form-control form-control__dark" type="text" name="review[%i%][author]" required>
            </div>
            <div class="form-group">
                <label>Локация:</label><br>
                <input class="form-control form-control__dark" type="text" name="review[%i%][location]">
            </div>
            <div class="form-group">
                <label>Ревью:</label><br>
                <textarea class="form-control form-control__dark" name="review[%i%][review]" required></textarea>
            </div>
            <div class="scores">
                <label>Оценка:</label>
                @for($i = 1; $i <= 5; $i-=-1)
                    <label>
                        <input type="radio" name="review[%i%][score]" value="{{ $i }}" @if($i == 5) checked @endif><span>{{ $i }}</span>
                    </label>
                @endfor
            </div>
        </div>
    </script>

    <script type="text/html" id="additional_template">
        <div class="review" id="additional-%i%">
            <a class="delete-review-btn btn"><span class="glyphicon glyphicon-remove"></span></a>
            <div class="form-group">
                <label>Автор:</label>
                <input class="form-control form-control__dark" type="text" name="additional[%i%][author]" required>
            </div>
            <div class="form-group">
                <label>Локация:</label>
                <input class="form-control form-control__dark" type=text" name="additional[%i%][location]">
            </div>
        </div>
    </script>
@endsection
