@extends('admin.layout.layout')

@section('title')
    Преподаватели CTSchool | CTS Records Admin Panel
@endsection

@section('admin-content')

    <div class="container-fluid">
        <div class="releases-actions sticky-top my-3">
            <button data-url="{{ route('school.teachers.create') }}" class="btn btn-primary add-service">
                <i class="fa-solid fa-plus me-2"></i>Новый преподаватель
            </button>
        </div>
        @foreach($teachers_lang as $teachers)
            <div class="card text-bg-dark service-lang mb-5">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">({{ $teachers[0]->lang }}) {{ \Illuminate\Support\Facades\Lang::choice('school.teachers', 8, locale: $teachers[0]->lang) }}</h4>
                    <b class="msg text-primary"></b>
                </div>
                <div class="card-body row" data-action="{{ route('school.teachers.resort') }}">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover">
                            <thead>
                            <tr>
                                <th>Картинка</th>
                                <th>Имя</th>
                                <th>Описание</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="sortable" data-action="{{ route('school.teachers.resort') }}">
                            @foreach($teachers as $teacher)
                                <tr class="teacher">
                                    <td>
                                        <img src="/images/school/teachers/{{ $teacher->image }}" data-id="{{ $teacher->id }}">
                                    </td>
                                    <td>{{ $teacher->name }}</td>
                                    <td class="text-nowrap text-truncate" style="max-width: 400px;">{{ strip_tags($teacher->teacher_binfo) }}</td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-primary" type="button" data-id="{{ $teacher->id }}"
                                                data-url="{{ route('school.teachers.edit', $teacher->id) }}">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        @endforeach

        <div class="modal fade" id="editServiceModal">
            <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Редактирование преподавателя</h5>
                        <button type="button" class="btn btn-outline" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
