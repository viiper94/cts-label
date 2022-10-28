@extends('admin.layout.layout')

@section('admin-content')

    <div class="container-fluid admin-releases">

        @include('admin.layout.alert')
        <form id='sort_form' method='POST' action="{{ route('releases.resort') }}">
            @csrf
        </form>
        <div class="justify-content-between align-items-center d-flex my-3">
            <div class="releases-actions">
                <a href="{{ route('releases.create') }}" class="btn btn-success">
                    <i class="fa-solid fa-plus me-2"></i>Новый релиз
                </a>
                <button type="submit" class="btn btn-secondary" form="sort_form" onclick='return confirm("Отсортировать?")'>
                    <i class="fa-solid fa-sort me-2"></i>Отсортировать
                </button>
            </div>
            {{ $releases->appends(Request::input())->links('admin.layout.pagination') }}
        </div>
        <div class="row">
            @foreach($releases as $release)
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="card text-bg-dark mb-3">
                        <div class="row g-0">
                            <div class="col-12 d-flex g-0">
                                <div class="card-img col-auto">
                                    <img src="/images/releases/{{ $release->image ?? 'default.png' }}" class="img-fluid" alt="{{ $release->title }}">
                                </div>
                                <div class="card-info d-flex flex-column col">
                                    <div class="card-header">
                                        <h5 class="card-title text-nowrap">{{ $release->title }}</h5>
                                    </div>
                                    <div class="d-flex flex-grow-1">
                                        <div class="card-body">
                                            <p class="card-text">{{ $release->release_number }}</p>
                                            <p class="card-text">{{ $release->release_date?->isoFormat('LL') }}</p>
                                        </div>
                                        <div class="card-sort d-flex flex-column">
                                            <a href="{{ route('releases.sort', ['release' => $release->id, 'dir' => 'up']) }}" class="fs-2">
                                                <i class="fa-solid fa-chevron-up"></i>
                                            </a>
                                            <input type="number" class="text-bg-dark" name="sort[{{ $release->id }}]" value="{{ $release->sort_id }}" form="sort_form">
                                            <a href="{{ route('releases.sort', ['release' => $release->id, 'dir' => 'down']) }}" class="fs-2">
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 g-0">
                                <div class="card-footer justify-content-end">
                                    <a class="btn btn-sm btn-success" href="{{ route('releases.edit', $release->id) }}">
                                        <i class="fa-solid fa-pen me-2"></i>Редактировать
                                    </a>
                                    @if($release->feedback)
                                        <a class="btn btn-sm btn-info" href="{{ route('feedback_admin') }}/edit/{{ $release->feedback->slug }}">
                                            <i class="fa-solid fa-plus me-2"></i>Edit Feedback
                                        </a>
                                    @else
                                        <a class="btn btn-sm btn-info" href="{{ route('feedback_admin') }}/add/{{ $release->id }}">
                                            <i class="fa-solid fa-plus me-2"></i>New Feedback
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


{{--                <div class="col-xs-12 col-md-6">--}}
{{--                    <div class='item'>--}}
{{--                        <div class='item-cover col-xs-2'>--}}
{{--                            <a href='{{ route('releases.edit', $release->id) }}'--}}
{{--                               style="background-image: url(/images/releases/{{ $release->image ?? 'default.png' }})"></a>--}}
{{--                        </div>--}}
{{--                        <div class='item-info col-md-5 col-xs-7 flex-column'>--}}
{{--                            <h5>{{ $release->title }}</h5>--}}
{{--                            <h4>{{ $release->release_number }}</h4>--}}
{{--                            <a href='{{ route('release', $release->id) }}' target='_blank' class='btn btn-default btn-default__dark'>--}}
{{--                                <span class='glyphicon glyphicon-share' aria-hidden='true'></span>--}}
{{--                                Релиз на сайте--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                        <form class='item-action col-md-3 col-xs-1 flex-column' action="{{ route('releases.destroy', $release->id) }}" method="post">--}}
{{--                            @csrf--}}
{{--                            @method('DELETE')--}}
{{--                            <a class='btn btn-success' href='{{ route('releases.edit', $release->id) }}'>--}}
{{--                                <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>--}}
{{--                                <span class="hidden-xs hidden-sm">Редактировать</span>--}}
{{--                            </a>--}}
{{--                            <button class='btn btn-danger' type='submit' onclick='return confirm("Удалить?")'>--}}
{{--                                <span class='glyphicon glyphicon-trash' aria-hidden='true'></span>--}}
{{--                                <span class="hidden-xs hidden-sm">Удалить</span>--}}
{{--                            </button>--}}
{{--                            @if(!is_null($release->feedback))--}}
{{--                                <a class='btn btn-info' href='{{ route('feedback_admin') }}/edit/{{ $release->feedback->slug }}'>--}}
{{--                                    <span class='glyphicon glyphicon-plus' aria-hidden='true'></span>--}}
{{--                                    <span class="hidden-xs hidden-sm">Edit Feedback</span>--}}
{{--                                </a>--}}
{{--                            @else--}}
{{--                                <a class='btn btn-info' href='{{ route('feedback_admin') }}/add/{{ $release->id }}'>--}}
{{--                                    <span class='glyphicon glyphicon-plus' aria-hidden='true'></span>--}}
{{--                                    <span class="hidden-xs hidden-sm">New Feedback</span>--}}
{{--                                </a>--}}
{{--                            @endif--}}
{{--                        </form>--}}
{{--                        <div class='item-sort col-xs-2 flex-column'>--}}
{{--                            <a class='btn btn-default btn-default__dark' href='{{ route('releases.sort', ['release' => $release->id, 'dir' => 'up']) }}'>--}}
{{--                                <span class='glyphicon glyphicon-arrow-up'></span>--}}
{{--                                <span class="hidden-xs">Выше</span>--}}
{{--                            </a>--}}
{{--                            <input type='number' class='form-control form-control__dark' name='sort[{{ $release->id }}]' value='{{ $release->sort_id }}' form='sort_form'>--}}
{{--                            <a class='btn btn-default btn-default__dark' href='{{ route('releases.sort', ['release' => $release->id, 'dir' => 'down']) }}'>--}}
{{--                                <span class='glyphicon glyphicon-arrow-down'></span>--}}
{{--                                <span class="hidden-xs">Ниже</span>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                        <div class="clearfix"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            @endforeach
        </div>
        <div class="top-container flex">
            <div class="releases-actions">
                <button type='submit' class='btn btn-primary' form='sort_form' onclick='return confirm("Отсортировать?")'>
                    <span class='glyphicon glyphicon-refresh' aria-hidden='true'></span>
                    Отсортировать
                </button>
            </div>
            <div class="pagination-container pagination__dark">
                {{ $releases->appends(Request::input())->links('admin.layout.pagination') }}
            </div>
        </div>
    </div>

@endsection

@section('search')
    @include('admin.layout.search')
@endsection
