@extends('admin.layout.layout')

@section('admin-content')

    <div class="container-fluid">

        @include('admin.layout.alert')
        <form name='sort_form' method='POST' action="{{ route('artists.resort') }}" id="sortForm">
            @csrf
        </form>
        <div class="top-container flex">
            <div class="releases-actions">
                <button type='submit' class='btn btn-primary' name='resort' onclick='return confirm("Отсортировать?")' form="sortForm">
                    <span class='glyphicon glyphicon-refresh' aria-hidden='true'></span>
                    Отсортировать
                </button>
                <a href='{{ route('artists.create') }}' class='btn btn-success'>
                    <span class='glyphicon glyphicon-plus' aria-hidden='true'></span>
                    Новый артист
                </a>
            </div>
            <div class="pagination-container pagination__dark">
                {{ $artists->appends(['q' => Request::input('q')])->links('admin.layout.pagination') }}
            </div>
        </div>
        <div class="clearfix"></div>
        <div class='items'>
            @foreach($artists as $artist)
                <div class="col-xs-12 col-md-6">
                    <div class='item'>
                        <div class='item-cover col-xs-2'>
                            <a href='{{ route('artists.edit', $artist->id) }}'
                               style="background-image: url(/images/artists/{{ $artist->image ?? 'default.png' }})"></a>
                        </div>
                        <div class='item-info col-md-5 col-xs-7 flex-column'>
                            <h4>{{ $artist->name }}</h4>
                            @if($artist->link)
                                <a href='{{ $artist->link }}' target='_blank' class='btn btn-default btn-default__dark'>
                                    <span class='glyphicon glyphicon-share' aria-hidden='true'></span>
                                    Ссылка в соц. сеть
                                </a>
                            @endif
                        </div>
                        <form class="item-action col-md-3 col-xs-1 flex-column" method="post"
                              action="{{ route('artists.destroy', $artist->id) }}">
                            @csrf
                            @method('DELETE')
                            <a class='btn btn-success' href='{{ route('artists.edit', $artist->id) }}'>
                                <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                                <span class="hidden-xs hidden-sm">Редактировать</span>
                            </a>
                            <button class='btn btn-danger' type='submit' onclick='return confirm("Удалить?")'>
                                <span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                                <span class="hidden-xs hidden-sm">Удалить</span>
                            </button>
                        </form>
                        <div class='item-sort col-xs-2 flex-column'>
                            <a class='btn btn-default btn-default__dark' href='{{ route('artists.sort', ['artist' => $artist->id, 'dir' => 'up']) }}'>
                                <span class='glyphicon glyphicon-arrow-up'></span>
                                <span class="hidden-xs">Выше</span>
                            </a>
                            <input type='number' class='form-control form-control__dark' name='sort[{{ $artist->id }}]' value='{{ $artist->sort_id }}' size=5 form="sortForm">
                            <a class='btn btn-default btn-default__dark' href='{{ route('artists.sort', ['artist' => $artist->id, 'dir' => 'down']) }}'>
                                <span class='glyphicon glyphicon-arrow-down'></span>
                                <span class="hidden-xs">Ниже</span>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            @endforeach
            <div class="clearfix"></div>
        </div>
        <div class="top-container flex">
            <div class="releases-actions">
                <button type='submit' class='btn btn-primary' name='resort' onclick='return confirm("Отсортировать?")' form="sortForm">
                    <span class='glyphicon glyphicon-refresh' aria-hidden='true'></span>
                    Отсортировать
                </button>
            </div>
            <div class="pagination-container pagination__dark">
                {{ $artists->appends(['q' => Request::input('q')])->links() }}
            </div>
        </div>
    </div>

@endsection

@section('search')
    @include('admin.layout.search')
@endsection
