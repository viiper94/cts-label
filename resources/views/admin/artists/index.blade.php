@extends('admin.layout.layout')

@section('admin-content')

    <div class="container-fluid">

        @include('admin.layout.alert')
        <form name='sort_form' method='POST' action="{{ route('artists_admin') }}/resort">
            @csrf
            <div class="top-container flex">
                <div class="releases-actions">
                    <button type='submit' class='btn btn-primary' name='resort' onclick='return confirm("Отсортировать?")'>
                        <span class='glyphicon glyphicon-refresh' aria-hidden='true'></span>
                        Отсортировать
                    </button>
                    <a href='{{ route('artists_admin') }}/add' class='btn btn-success'>
                        <span class='glyphicon glyphicon-plus' aria-hidden='true'></span>
                        Новый артист
                    </a>
                </div>
                <div class="pagination-container pagination__dark">
                    {{ $artists->appends(['q' => Request::input('q')])->links() }}
                </div>
            </div>
            <div class="clearfix"></div>
            <div class='items'>
                @foreach($artists as $artist)
                    <div class="col-xs-12 col-md-6">
                        <div class='item'>
                            <div class='item-cover col-xs-2'>
                                <a href='{{ route('artists_admin') }}/edit/{{ $artist->id }}'
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
                            <div class='item-action col-md-3 col-xs-1 flex-column'>
                                <a class='btn btn-success' href='{{ route('artists_admin') }}/edit/{{ $artist->id }}'>
                                    <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                                    <span class="hidden-xs hidden-sm">Редактировать</span>
                                </a>
                                <a class='btn btn-danger' href='{{ route('artists_admin') }}/delete/{{ $artist->id }}' onclick='return confirm("Удалить?")'>
                                    <span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                                    <span class="hidden-xs hidden-sm">Удалить</span>
                                </a>
                            </div>
                            <div class='item-sort col-xs-2 flex-column'>
                                <a class='btn btn-default btn-default__dark' href='{{ route('artists_admin') }}/sort/{{ $artist->id }}/up'>
                                    <span class='glyphicon glyphicon-arrow-up'></span>
                                    <span class="hidden-xs">Выше</span>
                                </a>
                                <input type='number' class='form-control form-control__dark' name='sort[{{ $artist->id }}]' value='{{ $artist->sort_id }}' size=5>
                                <a class='btn btn-default btn-default__dark' href='{{ route('artists_admin') }}/sort/{{ $artist->id }}/down'>
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
                    <button type='submit' class='btn btn-primary' name='resort' onclick='return confirm("Отсортировать?")'>
                        <span class='glyphicon glyphicon-refresh' aria-hidden='true'></span>
                        Отсортировать
                    </button>
                </div>
                <div class="pagination-container pagination__dark">
                    {{ $artists->appends(['q' => Request::input('q')])->links() }}
                </div>
            </div>
        </form>
    </div>

@endsection

@section('search')
    @include('admin.layout.search')
@endsection
