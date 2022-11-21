@extends('admin.layout.layout')

@section('admin-content')

    <div class="container-fluid">
        <form enctype="multipart/form-data" method="post"
              action="{{ $review->id ? route('reviews.update', $review->id) : route('reviews.store') }}">
            @if($review->id)
                @method('PUT')
            @endif
            @csrf
            <button type="submit" class="btn btn-primary shadow sticky-top my-3">
                <i class="fa-solid fa-floppy-disk me-2"></i>Сохранить
            </button>
            <div class="row">
                <div class="col-md-7 col-xs-12">
                    <div class="form-group mb-3">
                        <label class="form-label" for="track">Трек</label>
                        <input type="text" class="form-control form-dark form-control-lg" name="track" id="track"
                               value="{{ $review->track }}" required>
                        @error('track')
                        <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-check mb-3">
                        <input type="hidden" name="visible" value="0">
                        <input type="checkbox" name="visible" id="visible"
                               class="form-check-input" @checked($review->visible)>
                        <label for="visible" class="form-check-label">Опубликовано</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7 col-xs-12">
                    <div id="reviews" class="mb-5">
                        <h3>Ревью:</h3>
                        @if($review->data['reviews'])
                            @foreach($review->data['reviews'] as $key => $item)
                                @include('admin.reviews.review_item', compact('key', 'item'))
                            @endforeach
                        @endif
                        <a class="add-review-btn btn btn-outline" data-index="{{ count($review->data['reviews']) }}" data-target="review">
                            <i class="fa-solid fa-plus me-2"></i>Добавить ревью
                        </a>
                    </div>
                    <div id="additional" class="mb-3">
                        <h3>Also supported:</h3>
                        @if($review->data['additional'])
                            @foreach($review->data['additional'] as $key => $item)
                                @include('admin.reviews.additional_item', compact('key', 'item'))
                            @endforeach
                        @endif
                        <a class="add-review-btn btn btn-outline" data-index="{{ count($review->data['additional']) }}" data-target="additional">
                            <i class="fa-solid fa-plus me-2"></i>Добавить
                        </a>
                    </div>
                </div>
                <div class="col-md-5 col-xs-12 search-reviewer">
                    <div class="sticky-top">
                        <h5 class="mb-3">Поиск автора ревью:</h5>
                        <div class="form-group">
                            <input type="text" class="search-form form-control form-dark" id="search-reviewer"
                                   placeholder="Поиск">
                        </div>
                        <div class="founded mt-3"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
