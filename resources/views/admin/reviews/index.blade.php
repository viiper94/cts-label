@extends('admin.layout.layout')

@section('admin-content')

    <div class="container-fluid">
        @include('admin.layout.alert')
        <form id='sort_form' method='POST' action="{{ route('reviews.resort') }}">
            @csrf
        </form>
        <div class="top-container flex">
            <div class="releases-actions">
                <button type='submit' class='btn btn-primary' form="sort_form" onclick='return confirm("Отсортировать?")'>
                    <span class='glyphicon glyphicon-refresh' aria-hidden='true'></span>
                    Отсортировать
                </button>
                <a href='{{ route('reviews.create') }}' class='btn btn-success'>
                    <span class='glyphicon glyphicon-plus' aria-hidden='true'></span>
                    Новое ревью
                </a>
            </div>
            <div class="pagination-container pagination__dark">
                {{ $reviews->appends(Request::input())->links('admin.layout.pagination') }}
            </div>
        </div>
        <div class="clearfix"></div>
        <div class='items'>
            @foreach($reviews as $review)
                <div class="col-xs-12 col-sm-6 col-lg-4">
                    <div class='item item__review flex'>
                        <h4>{{ $review->track }}</h4>
                        <form class='item-action col-xs-6 flex-column' method="post" action="{{ route('reviews.destroy', $review->id) }}">
                            @csrf
                            @method('DELETE')
                            <a class='btn btn-success' href='{{ route('reviews.edit', $review->id) }}'>
                                <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                                <span class="hidden-xs hidden-sm">Редактировать</span>
                            </a>
                            <button class='btn btn-danger' onclick='return confirm("Удалить?")' type="submit">
                                <span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                                <span class="hidden-xs hidden-sm">Удалить</span>
                            </button>
                        </form>
                        <div class='item-sort col-xs-6 flex'>
                            <div class="arrows flex-column">
                                <a class='btn btn-default btn-default__dark' href='{{ route('reviews.sort', ['review' => $review->id, 'dir' => 'up']) }}'>
                                    <span class='glyphicon glyphicon-arrow-up'></span>
                                </a>
                                <a class='btn btn-default btn-default__dark' href='{{ route('reviews.sort', ['review' => $review->id, 'dir' => 'down']) }}'>
                                    <span class='glyphicon glyphicon-arrow-down'></span>
                                </a>
                            </div>
                            <input type='number' class='form-control form-control__dark' form="sort_form"
                                   name='sort[{{ $review->id }}]' value='{{ $review->sort_id }}' size=5>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            @endforeach
            <div class="clearfix"></div>
        </div>
        <div class="top-container flex">
            <div class="releases-actions">
                <button type='submit' class='btn btn-primary' form="sort_form" onclick='return confirm("Отсортировать?")'>
                    <span class='glyphicon glyphicon-refresh' aria-hidden='true'></span>
                    Отсортировать
                </button>
            </div>
            <div class="pagination-container pagination__dark">
                {{ $reviews->appends(Request::input())->links() }}
            </div>
        </div>
    </div>

@endsection

@section('search')
    @include('admin.layout.search')
@endsection
