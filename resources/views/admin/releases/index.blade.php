@extends('admin.layout.layout')

@section('admin-content')

    <div class="container-fluid">

        @include('admin.layout.alert')
        <form name='sort_form' method='POST' action="{{ route('releases_admin') }}/resort">
            @csrf
            <div class="top-container flex">
                <div class="releases-actions">
                    <button type='submit' class='btn btn-primary' name='resort' onclick='return confirm("Отсортировать?")'>
                        <span class='glyphicon glyphicon-refresh' aria-hidden='true'></span>
                        Отсортировать
                    </button>
                    <a href='{{ route('releases_admin') }}/add' class='btn btn-success'>
                        <span class='glyphicon glyphicon-plus' aria-hidden='true'></span>
                        Новый релиз
                    </a>
                </div>
                <div class="pagination-container pagination__dark">
                    {{ $releases->appends(['q' => Request::input('q')])->links() }}
                </div>
            </div>
            <div class="clearfix"></div>
            <div class='items'>
                @foreach($releases as $release)
                    <div class="col-xs-12 col-md-6">
                        <div class='item'>
                            <div class='item-cover col-xs-2'>
                                <a href='{{ route('releases_admin') }}/edit/{{ $release->id }}'
                                   style="background-image: url(/images/releases/{{ $release->image ?? 'default.png' }})"></a>
                            </div>
                            <div class='item-info col-md-5 col-xs-7 flex-column'>
                                <h5>{{ $release->title }}</h5>
                                <h4>{{ $release->release_number }}</h4>
                                <a href='{{ route('release', $release->id) }}' target='_blank' class='btn btn-default btn-default__dark'>
                                    <span class='glyphicon glyphicon-share' aria-hidden='true'></span>
                                    Релиз на сайте
                                </a>
                            </div>
                            <div class='item-action col-md-3 col-xs-1 flex-column'>
                                <a class='btn btn-success' href='{{ route('releases_admin') }}/edit/{{ $release->id }}'>
                                    <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                                    <span class="hidden-xs hidden-sm">Редактировать</span>
                                </a>
                                <a class='btn btn-danger' href='{{ route('releases_admin') }}/delete/{{ $release->id }}' onclick='return confirm("Удалить?")'>
                                    <span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                                    <span class="hidden-xs hidden-sm">Удалить</span>
                                </a>
                                <a class='btn btn-info' href='{{ route('feedback_admin') }}/edit/{{ $release->id }}'>
                                    <span class='glyphicon glyphicon-plus' aria-hidden='true'></span>
                                    <span class="hidden-xs hidden-sm">Feedback</span>
                                </a>
                            </div>
                            <div class='item-sort col-xs-2 flex-column'>
                                <a class='btn btn-default btn-default__dark' href='{{ route('releases_admin') }}/sortup/{{ $release->id }}'>
                                    <span class='glyphicon glyphicon-arrow-up'></span>
                                    <span class="hidden-xs">Выше</span>
                                </a>
                                <input type='number' id='field' class='form-control form-control__dark' name='sort[{{ $release->id }}]' value='{{ $release->sort_id }}' size=5>
                                <a class='btn btn-default btn-default__dark' href='{{ route('releases_admin') }}/sortdown/{{ $release->id }}'>
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
                    {{ $releases->appends(['q' => Request::input('q')])->links() }}
                </div>
            </div>
        </form>
    </div>

@endsection

@section('search')
    @include('admin.layout.search')
@endsection
