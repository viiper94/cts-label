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
            <div class="table-responsive">
                    <table class="items-table table table-hover table__dark">
                        <tbody>
                        @foreach($service_list as $services)
                            <tr>
                                <th></th>
                                <th>Название</th>
                                <th>Язык</th>
                                <th>Действия</th>
                                <th>Сортировка</th>
                            </tr>
                                @foreach($services as $service)
                                <tr>
                                    <td><img src="/images/studio/services/{{ $service->image }}" alt="{{ $service->service_alt }}"></td>
                                    <td><h5>{{ $service->name }}</h5></td>
                                    <td><h5>{{ $service->lang }}</h5></td>
                                    <td>
                                        <a class='btn btn-success' href='{{ route('studio_admin') }}/edit/{{ $service->id }}'>
                                            <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                                            <span class="hidden-xs hidden-sm hidden-lg">Редактировать</span>
                                        </a>
                                        <a class='btn btn-danger' href='{{ route('studio_admin') }}/delete/{{ $service->id }}' onclick='return confirm("Удалить?")'>
                                            <span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                                            <span class="hidden-xs hidden-sm hidden-lg">Удалить</span>
                                        </a>
                                    </td>
                                    <td class="flex">
                                        <a class='btn btn-default btn-default__dark' href='{{ route('studio_admin') }}/sort/{{ $service->id }}/up'>
                                            <span class='glyphicon glyphicon-arrow-up'></span>
                                        </a>
                                        <input type='number' class='form-control form-control__dark sort-input' name='sort[{{ $service->id }}]' value='{{ $service->sort_id }}'>
                                        <a class='btn btn-default btn-default__dark' href='{{ route('studio_admin') }}/sort/{{ $service->id }}/down'>
                                            <span class='glyphicon glyphicon-arrow-down'></span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <th colspan="5"></th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>

@endsection

@section('search')
    @include('admin.layout.search')
@endsection
