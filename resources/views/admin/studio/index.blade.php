@extends('admin.layout.layout')

@section('admin-content')

    <div class="container-fluid">
        @include('admin.layout.alert')
        <form name='sort_form' method='POST' action="{{ route('studio_admin') }}/resort">
            @csrf
            <div class="top-container flex">
                <div class="releases-actions">
                    <button type='submit' class='btn btn-primary' name='resort' onclick='return confirm("Отсортировать?")'>
                        <span class='glyphicon glyphicon-refresh' aria-hidden='true'></span>
                        Отсортировать
                    </button>
                    <a href='{{ route('studio_admin') }}/add' class='btn btn-success'>
                        <span class='glyphicon glyphicon-plus' aria-hidden='true'></span>
                        Добавить услугу
                    </a>
                </div>
            </div>
            <div class="items">
                <h3 style="padding-left: 30px">@lang('studio.services')</h3>
                @foreach($services as $service)
                    <div class="col-xs-12 col-md-4">
                        <div class='item'>
                            <div class='item-cover col-xs-3'>
                                <a href='{{ route('studio_admin') }}/edit/{{ $service->id }}'
                                   style="background-image: url(/images/studio/services/{{ $service->image ?? 'default.png' }})"></a>
                            </div>
                            <div class="item-info col-md-4 col-xs-7 flex-column">
                                <h4>{{ $service->name }}</h4>
                                <h5>@lang('shared.'.$service->lang)</h5>
                            </div>
                            <div class='item-action col-md-3 col-xs-1 flex-column'>
                                <a class='btn btn-success' href='{{ route('studio_admin') }}/edit/{{ $service->id }}'>
                                    <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                                    <span class="hidden-xs hidden-sm">Редактировать</span>
                                </a>
                                <a class='btn btn-danger' href='{{ route('studio_admin') }}/delete/{{ $service->id }}' onclick='return confirm("Удалить?")'>
                                    <span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                                    <span class="hidden-xs hidden-sm">Удалить</span>
                                </a>
                            </div>
                            <div class='item-sort col-xs-2 flex-column'>
                                <a class='btn btn-default btn-default__dark' href='{{ route('studio_admin') }}/sortup/{{ $service->id }}'>
                                    <span class='glyphicon glyphicon-arrow-up'></span>
                                    <span class="hidden-xs">Выше</span>
                                </a>
                                <input type='number' class='form-control form-control__dark' name='sort[{{ $service->id }}]' value='{{ $service->sort_id }}' size=5>
                                <a class='btn btn-default btn-default__dark' href='{{ route('studio_admin') }}/sortdown/{{ $service->id }}'>
                                    <span class='glyphicon glyphicon-arrow-down'></span>
                                    <span class="hidden-xs">Ниже</span>
                                </a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </form>
    </div>

@endsection

@section('search')
    @include('admin.layout.search')
@endsection
