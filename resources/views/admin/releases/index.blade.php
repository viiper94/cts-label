@extends('admin.layout.layout')

@section('title')
    Релизы | CTS Records Admin Panel
@endsection

@section('admin-content')

    <div class="container-fluid admin-items admin-releases">

        <form id="sort_form" method="POST" action="{{ route('releases.resort') }}">
            @csrf
        </form>
        <div class="justify-content-between align-items-center d-flex my-3">
            <div class="releases-actions">
                <a href="{{ route('releases.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus me-2"></i>Новый релиз
                </a>
                <button type="submit" class="btn btn-outline" form="sort_form" onclick="return confirm('Отсортировать?')">
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
                            <div class="card-header">
                                <h5 class="card-title text-nowrap mb-0 text-truncate">{{ $release->title }}</h5>
                            </div>
                            <div class="col-12 d-flex g-0">
                                <div class="card-img col-auto">
                                    <img src="/images/releases/{{ $release->image ?? 'default.png' }}" class="img-fluid" alt="{{ $release->title }}">
                                </div>
                                <div class="card-info d-flex flex-column col">
                                    <div class="d-flex flex-grow-1">
                                        <div class="card-body">
                                            <small class="text-muted">Номер каталога</small>
                                            <h4 class="card-text">{{ $release->release_number }}</h4>
                                            <small class="text-muted">Дата релиза</small>
                                            <h5 class="card-text">{{ $release->release_date?->isoFormat('LL') }}</h5>
                                        </div>
                                        <div class="card-sort">
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
                                    <a class="btn btn-sm btn-primary" href="{{ route('releases.edit', $release->id) }}">
                                        <i class="fa-solid fa-pen me-2"></i>Редактировать
                                    </a>
                                    @if($release->feedback)
                                        <a class="btn btn-sm btn-outline" href="{{ route('feedback_admin') }}/edit/{{ $release->feedback->slug }}">
                                            <i class="fa-solid fa-message me-2"></i>Фидбек
                                        </a>
                                    @else
                                        <a class="btn btn-sm btn-outline" href="{{ route('feedback_admin') }}/add/{{ $release->id }}">
                                            <i class="fa-solid fa-plus me-2"></i>Созать фидбек
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="justify-content-center d-flex my-3">
            {{ $releases->appends(Request::input())->links('admin.layout.pagination') }}
        </div>
    </div>

@endsection

@section('search')
    @include('admin.layout.search')
@endsection
