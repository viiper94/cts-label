@extends('admin.layout.layout')

@section('title')
    @lang('school.ctschool_courses') | @lang('shared.admin.cts_admin_panel')
@endsection

@section('admin-content')

    <div class="container-fluid">
        <div class="releases-actions sticky-top my-3">
            <button data-url="{{ route('school.courses.create') }}" class="btn btn-primary add-service">
                <i class="fa-solid fa-plus me-2"></i>@lang('school.new_course')
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
                </div>
            </div>
        </div>

    </div>

@endsection
