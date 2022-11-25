@extends('admin.layout.layout')

@section('admin-content')

    <div class="container-fluid admin-reviews">
        <form id='sort_form' method='POST' action="{{ route('reviews.resort') }}">
            @csrf
        </form>
        <div class="justify-content-between align-items-center d-flex my-3">
            <div class="releases-actions">
                <a href="{{ route('reviews.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus me-2"></i>Новое ревью
                </a>
                <button type="submit" class="btn btn-outline" form="sort_form" onclick="return confirm('Отсортировать?')">
                    <i class="fa-solid fa-sort me-2"></i>Отсортировать
                </button>
            </div>
            {{ $reviews->appends(Request::input())->links('admin.layout.pagination') }}
        </div>
        <table class="table table-hover table-dark">
            <thead>
            <tr>
                <th scope="col">Порядок</th>
                <th scope="col">Трек</th>
                <th scope="col">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reviews as $review)
                <tr>
                    <td class="sort text-right">
                        <div class="row g-0">
                            <div class="arrows col-auto">
                                <a href="{{ route('reviews.sort', ['review' => $review->id, 'dir' => 'up']) }}">
                                    <i class="fa-solid fa-chevron-up"></i>
                                </a>
                                <a href="{{ route('reviews.sort', ['review' => $review->id, 'dir' => 'down']) }}">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </a>
                            </div>
                            <input type="number" class="form-control form-dark col-auto" form="sort_form"
                                   name="sort[{{ $review->id }}]" value="{{ $review->sort_id }}">
                        </div>
                    </td>
                    <td class="fs-5">{{ $review->track }}</td>
                    <td>
                        <a class="btn btn-outline" href="{{ route('reviews.edit', $review->id) }}">
                            <i class="fa-solid fa-pen me-2"></i>Редактировать
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="justify-content-center d-flex my-3">
            {{ $reviews->appends(Request::input())->links('admin.layout.pagination') }}
        </div>
    </div>

@endsection

@section('search')
    @include('admin.layout.search')
@endsection
