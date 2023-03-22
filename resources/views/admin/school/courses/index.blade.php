@extends('admin.layout.layout')

@section('title')
    Курсы CTSchool | CTS Records Admin Panel
@endsection

@section('admin-content')

    <div class="container-fluid">
        <div class="releases-actions sticky-top my-3">
            <button data-url="{{ route('school.courses.create') }}" class="btn btn-primary add-service">
                <i class="fa-solid fa-plus me-2"></i>Новый курс
            </button>
        </div>
        @foreach($courses_lang as $courses)
            <div class="card text-bg-dark service-lang mb-5">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">({{ $courses[0]->lang }}) {{ \Illuminate\Support\Facades\Lang::choice('school.courses', 8, locale: $courses[0]->lang) }}</h4>
                    <b class="msg text-primary"></b>
                </div>
                <div class="card-body sortable" data-action="{{ route('school.courses.resort') }}">
                    @foreach($courses as $course)
                        <img src="/images/school/courses/{{ $course->image ?? 'default.png' }}" alt="{{ $course->course_alt }}" class="service-img m-3"
                             data-id="{{ $course->id }}" data-url="{{ route('school.courses.edit', $course->id) }}">
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="modal fade" id="editServiceModal">
            <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Редактирование курса</h5>
                        <button type="button" class="btn btn-outline" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
