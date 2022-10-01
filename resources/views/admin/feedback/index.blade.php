@extends('admin.layout.layout')

@section('admin-content')

    <div class="container-fluid">

        @include('admin.layout.alert')
        <div class="top-container flex">
            <div class="releases-actions">
                <a href='{{ route('feedback_admin') }}/add' class='btn btn-success'>
                    <span class='glyphicon glyphicon-plus' aria-hidden='true'></span>
                    Кастомная страница фидбэка
                </a>
            </div>
            <div class="pagination-container pagination__dark">
                {{ $feedback_list->appends(['q' => Request::input('q')])->links('admin.layout.pagination') }}
            </div>
        </div>
        <div class="clearfix"></div>
        <div class='items'>
            @foreach($feedback_list as $feedback)
                <div class="col-xs-12 col-md-6">
                    <div class='item'>
                        <div class='item-cover col-xs-2'>
                            <a href="{{ route('feedback_admin') }}/edit/{{ $feedback->slug }}"
                                @if($feedback->release)
                                    style="background-image: url(/images/releases/{{ $feedback->release->image ?? 'default.png' }})"
                                @else
                                    style="background-image: url(/images/feedback/{{ $feedback->image ?? 'default.png' }})"
                                @endif>

                            </a>
                        </div>
                        <div class='item-info col-md-6 col-xs-8 flex-column' style="align-items: start">
                            <h4>
                                {{ $feedback->feedback_title }}
                                @if($feedback->results->count() > 0)
                                    <span class="label label-success">{{ $feedback->results->count() }}</span>
                                @endif
                                @if($feedback->release)
                                    <a href="{{ route('release', $feedback->release_id) }}" style="color: inherit" target='_blank'>
                                        <span class='glyphicon glyphicon-paperclip' aria-hidden='true'></span>
                                    </a>
                                @endif
                            </h4>
                            <span>
                                <a href='{{ route('feedback', $feedback->slug) }}' target='_blank' class='btn btn-default btn-default__dark'>
                                    <span class='glyphicon glyphicon-share' aria-hidden='true'></span>
                                    Смотреть страницу фидбэка
                                </a>
                            </span>
                        </div>
                        <div class='item-sort col-md-4 col-xs-2 flex-column'>
                            <a class='btn btn-success' href='{{ route('feedback_admin') }}/edit/{{ $feedback->slug }}'>
                                <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                                <span class="hidden-xs hidden-sm">Редактировать</span>
                            </a>
                            <a class='btn btn-danger' href='{{ route('feedback_admin') }}/delete/{{ $feedback->slug }}' onclick='return confirm("Удалить?")'>
                                <span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                                <span class="hidden-xs hidden-sm">Удалить</span>
                            </a>
                            <a class='btn btn-info copy-link' data-clipboard-text="{{ route('feedback', $feedback->slug) }}">
                                <span class='glyphicon glyphicon-link' aria-hidden='true'></span>
                                <span class="hidden-xs hidden-sm">Скопировать ссылку</span>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            @endforeach
            <div class="clearfix"></div>
        </div>
        <div class="top-container flex">
            <div class="pagination-container pagination__dark">
                {{ $feedback_list->appends(['q' => Request::input('q')])->links() }}
            </div>
        </div>
    </div>

@endsection

@section('search')
    @include('admin.layout.search')
@endsection
