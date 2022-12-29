@extends('layout.layout')

@section('title', '404 | '.trans('errors.page_not_found'))

@section('content')

    <div class="container error-page py-5">
        <div class="d-flex align-items-center justify-content-center flex-column">
            <h1 class="display-1 text-primary fw-bold">404</h1>
            <h2 class="text-primary fw-bold mb-5">@lang('errors.page_not_found')</h2>
            <a href="{{ route('home') }}" class="btn btn-lg btn-outline-warning"><i class="fa-solid fa-house me-2"></i>@lang('errors.home_page')</a>
        </div>
    </div>

@endsection
