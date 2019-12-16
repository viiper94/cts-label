@extends('admin.layout.layout')

@section('admin-content')
    <div class="container">
        @include('admin.layout.alert')
        <form enctype="multipart/form-data" method="post">
            @csrf
            <div class="col-xs-12">
                <div id="sticker">
                    <button type='submit' class='btn btn-primary'>
                        <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                        Сохранить
                    </button>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-7 col-xs-12">
                <div class="form-group">
                    <label>Трек</label><br>
                    <input type="text" class="form-control form-control__dark" name="track" value="{{ $review->track }}" required>
                    @if($errors->has('track'))
                        <p class="help-block">{{ $errors->first('track') }}</p>
                    @endif
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="visible" {{ !$review->visible ? : 'checked' }}> Опубликовано
                    </label>
                </div>
                <div id="reviews">
                    <h5>Review:</h5>
                    @if($review->data['reviews'])
                        @foreach($review->data['reviews'] as $key => $item)
                            @if($loop->last)
                                @php $r_index = $key @endphp
                            @endif
                            <div class="review" id="review-{{ $key }}">
                                <a class="delete-review-btn btn"><span class="glyphicon glyphicon-remove"></span></a>
                                <div class="form-group">
                                    <label>Автор:</label>
                                    <input type="text" class="form-control form-control__dark" name="review[{{ $key }}][author]" value="{{ $item['author'] }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Локация:</label>
                                    <input type="text" class="form-control form-control__dark" name="review[{{ $key }}][location]" value="{{ $item['location'] }}">
                                </div>
                                <div class="form-group">
                                    <label>Ревью:</label>
                                    <textarea class="form-control form-control__dark" name="review[{{ $key }}][review]" required>{{ $item['review'] }}</textarea>
                                </div>
                                <div class="scores">
                                    <label>Оценка:</label>
                                    @for($i = 1; $i <= 5; $i-=-1)
                                        <label>
                                            <input type="radio" name="review[{{ $key }}][score]" value="{{ $i }}" @if($item['score'] == $i) checked @endif><span>{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <a class="add-review-btn btn btn-info" data-index="{{ $r_index ?? 0 }}" data-target="reviews"><span class="glyphicon glyphicon-plus"></span> Добавить</a>
                <div id="additional">
                    <h5>Also supported:</h5>
                    @if($review->data['additional'])
                        @foreach($review->data['additional'] as $key => $item)
                            @if($loop->last)
                                @php $a_index = $key @endphp
                            @endif
                            <div class="review" id="additional-{{ $key }}>">
                                <a class="delete-review-btn btn"><span class="glyphicon glyphicon-remove"></span></a>
                                <div class="form-group">
                                    <label>Автор:</label>
                                    <input class="form-control form-control__dark" type="text" name="additional[{{ $key }}][author]" value="{{ $item['author'] }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Локация:</label>
                                    <input class="form-control form-control__dark" type="text" name="additional[{{ $key }}][location]" value="{{ $item['location'] }}">
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <a class="add-review-btn btn btn-info" data-index="{{ $a_index ?? 0 }}" data-target="additional"><span class="glyphicon glyphicon-plus"></span> Добавить</a>
                <button class="add-btn btn btn-primary" style="margin-right: 5px;" type="submit"><span class="glyphicon glyphicon-pencil"></span> Сохранить</button>
            </div>

            <div class="col-md-5 col-xs-12 search-reviewer">
                <label>Поиск автора ревью:</label>
                <input type="text" class="search-form form-control form-control__dark" id='search-reviewer'>
            </div>
            <div class="founded" style="margin-top: 10px;"></div>
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
