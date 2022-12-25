@extends('admin.layout.layout')

@section('title')
    Артисты | CTS Records Admin Panel
@endsection

@section('admin-content')

    <div class="container-fluid admin-items admin-artists">

        <form method="POST" action="{{ route('artists.resort') }}" id="sort_form">
            @csrf
        </form>
        <div class="justify-content-between align-items-center flex-column-reverse flex-lg-row my-3 d-flex">
            <div class="releases-actions m-xl-0 m-1">
                <a href="{{ route('artists.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus me-2"></i>Новый артист
                </a>
{{--                <button type="submit" class="btn btn-outline" form="sort_form" onclick="return confirm('Отсортировать?')">--}}
{{--                    <i class="fa-solid fa-sort me-2"></i>Отсортировать--}}
{{--                </button>--}}
            </div>
            {{ $artists->appends(Request::input())->links('admin.layout.pagination') }}
        </div>
        <div class="row">
            @foreach($artists as $artist)
                <div class="col-xxl-2 col-lg-3 col-md-6 col-sm-4 col-xs-12">
                    <div class="card text-bg-dark mb-3">
                        <div class="card-header">
                            <h5 class="card-title text-nowrap mb-0 text-truncate">{{ $artist->name }}</h5>
                        </div>
                        <div class="row flex-grow-1 g-0">
                            <div class="card-img col">
                                <img src="/images/artists/{{ $artist->image ?? 'default.png' }}" class="img-fluid" alt="{{ $artist->name }}">
                            </div>
{{--                            <div class="card-sort col-auto">--}}
{{--                                <a href="{{ route('artists.sort', ['artist' => $artist->id, 'dir' => 'up']) }}" class="fs-2">--}}
{{--                                    <i class="fa-solid fa-chevron-up"></i>--}}
{{--                                </a>--}}
{{--                                <input type="number" class="text-bg-dark" name="sort[{{ $artist->id }}]" value="{{ $artist->sort_id }}" form="sort_form">--}}
{{--                                <a href="{{ route('artists.sort', ['artist' => $artist->id, 'dir' => 'down']) }}" class="fs-2">--}}
{{--                                    <i class="fa-solid fa-chevron-down"></i>--}}
{{--                                </a>--}}
{{--                            </div>--}}
                        </div>
                        <div class="card-footer justify-content-end">
                            <a class="btn btn-sm btn-primary text-nowrap" href="{{ route('artists.edit', $artist->id) }}">
                                <i class="fa-solid fa-pen me-2"></i>Редактировать
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="justify-content-center d-flex my-3">
            {{ $artists->appends(Request::input())->links('admin.layout.pagination') }}
        </div>
    </div>

@endsection

@section('search')
    @include('admin.layout.search')
@endsection
