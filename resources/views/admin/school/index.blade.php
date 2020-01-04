@extends('admin.layout.layout')

@section('scripts')
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
@endsection

@section('admin-content')

    @include('admin.layout.alert')
    <div class="container-fluid">
        <ul class="nav nav-tabs nav-tabs__dark" role="tablist">
            <li class="active"><a href="#courses" data-toggle="tab">Стоимость обучения</a></li>
            <li><a href="#teachers" data-toggle="tab">Преподаватели</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="courses">
                <form name='sort_form' method='POST' action="{{ route('school_admin') }}/resort">
                    @csrf
                    <div class="top-container flex">
                        <div class="releases-actions" style="margin-top: 10px;">
                            <button type='submit' class='btn btn-primary' name='resort' onclick='return confirm("Отсортировать?")'>
                                <span class='glyphicon glyphicon-refresh' aria-hidden='true'></span>
                                Отсортировать
                            </button>
                            <a href='{{ route('school_admin') }}/add' class='btn btn-success'>
                                <span class='glyphicon glyphicon-plus' aria-hidden='true'></span>
                                Добавить услугу
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="items-table table table-hover table__dark">
                            <tbody>
                            @foreach($courses_list as $courses)
                                <tr>
                                    <th></th>
                                    <th>Название</th>
                                    <th>Язык</th>
                                    <th>Действия</th>
                                    <th>Сортировка</th>
                                </tr>
                                @foreach($courses as $course)
                                    <tr>
                                        <td><img src="/images/school/courses/{{ $course->image }}" alt="{{ $course->service_alt }}"></td>
                                        <td><h5>{{ $course->name }}</h5></td>
                                        <td><h5>{{ $course->lang }}</h5></td>
                                        <td>
                                            <a class='btn btn-success' href='{{ route('school_admin') }}/edit/{{ $course->id }}'>
                                                <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                                                <span class="hidden-xs hidden-sm">Редактировать</span>
                                            </a>
                                            <a class='btn btn-danger' href='{{ route('school_admin') }}/delete/{{ $course->id }}' onclick='return confirm("Удалить?")'>
                                                <span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                                                <span class="hidden-xs hidden-sm">Удалить</span>
                                            </a>
                                        </td>
                                        <td class="flex">
                                            <a class='btn btn-default btn-default__dark' href='{{ route('school_admin') }}/sort/{{ $course->id }}/up'>
                                                <span class='glyphicon glyphicon-arrow-up'></span>
                                            </a>
                                            <input type='number' class='form-control form-control__dark sort-input' name='sort[{{ $course->id }}]' value='{{ $course->sort_id }}'>
                                            <a class='btn btn-default btn-default__dark' href='{{ route('school_admin') }}/sort/{{ $course->id }}/down'>
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

            <div class="tab-pane" id="teachers">
                @foreach($teachers_list as $teachers)

                @endforeach
            </div>
        </div>
    </div>

@endsection
