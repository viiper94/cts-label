@extends('admin.layout.layout')

@section('admin-content')

    <div class="container-fluid">

        @include('admin.layout.alert')
        <form name='sort_form' method='POST' action="{{ route('reviews_admin') }}/resort">
            @csrf
            <div class="top-container flex">
                <div class="releases-actions">
                    <button type='submit' class='btn btn-primary' name='resort' onclick='return confirm("Отсортировать?")'>
                        <span class='glyphicon glyphicon-refresh' aria-hidden='true'></span>
                        Отсортировать
                    </button>
                    <a href='{{ route('reviews_admin') }}/add' class='btn btn-success'>
                        <span class='glyphicon glyphicon-plus' aria-hidden='true'></span>
                        Новое ревью
                    </a>
                </div>
                <div class="pagination-container pagination__dark">
                    {{ $reviews->appends(['q' => Request::input('q')])->links() }}
                </div>
            </div>
            <div class="clearfix"></div>
            <div class='items'>
                @foreach($reviews as $review)
                    <div class="col-xs-12 col-md-4">
                        <div class='item item__review flex'>
                            <h4>{{ $review->track }}</h4>
                            <div class='item-action col-xs-6 flex-column'>
                                <a class='btn btn-success' href='{{ route('reviews_admin') }}/edit/{{ $review->id }}'>
                                    <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                                    <span class="hidden-xs hidden-sm">Редактировать</span>
                                </a>
                                <a class='btn btn-danger' href='{{ route('reviews_admin') }}/delete/{{ $review->id }}' onclick='return confirm("Удалить?")'>
                                    <span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                                    <span class="hidden-xs hidden-sm">Удалить</span>
                                </a>
                            </div>
                            <div class='item-sort col-xs-6 flex'>
                                <div class="arrows flex-column">
                                    <a class='btn btn-default btn-default__dark' href='{{ route('reviews_admin') }}/sortup/{{ $review->id }}'>
                                        <span class='glyphicon glyphicon-arrow-up'></span>
                                    </a>
                                    <a class='btn btn-default btn-default__dark' href='{{ route('reviews_admin') }}/sortdown/{{ $review->id }}'>
                                        <span class='glyphicon glyphicon-arrow-down'></span>
                                    </a>
                                </div>
                                <input type='number' id='field' class='form-control form-control__dark' name='sort[{{ $review->id }}]' value='{{ $review->sort_id }}' size=5>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                @endforeach
                <div class="clearfix"></div>
            </div>
            <div class="top-container flex">
                <div class="releases-actions">
                    <button type='submit' class='btn btn-primary' name='resort' onclick='return confirm("Отсортировать?")'>
                        <span class='glyphicon glyphicon-refresh' aria-hidden='true'></span>
                        Отсортировать
                    </button>
                </div>
                <div class="pagination-container pagination__dark">
                    {{ $reviews->appends(['q' => Request::input('q')])->links() }}
                </div>
            </div>
        </form>
    </div>

@endsection

@section('search')
    @include('admin.layout.search')
@endsection
