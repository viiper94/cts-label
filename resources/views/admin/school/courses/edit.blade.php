<div class="modal-header">
    <h5 class="modal-title">{{ $course->id ? trans('school.edit_course') : trans('school.new_course') }}</h5>
    <button type="button" class="btn btn-outline" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
</div>
<div class="modal-body">
    <form action="{{ $course->id ? route('school.courses.update', $course->id) : route('school.courses.store') }}" id="edit_form"
          enctype="multipart/form-data" method="post">
        @csrf
        @if($course->id)
            @method('PUT')
        @endif
        <div class="row">
            <div class="col-md-5">
                <img src="/images/school/courses/{{ $course->image ?? 'default.png' }}" id="preview" class="img-fluid" alt="{{ $course->course_alt }}">
                <input type="file" name="image" id="uploader" class="form-control form-dark" accept="image/jpeg, image/png">
            </div>
            <div class="col-md-7">
                <x-checkbox class="mb-3" name="visible" :checked="$course->visible">@lang('school.visible')</x-checkbox>
                <label class="form-label mb-0">@lang('school.lang')</label><br>
                <div class="form-check form-check-inline mb-3">
                    <input type="radio" name="lang" id="lang-en" class="form-check-input" value="en"
                           required @checked($course->lang === 'en')>
                    <label for="lang-en" class="form-check-label">English</label>
                </div>
                <div class="form-check form-check-inline mb-3">
                    <input type="radio" name="lang" id="lang-ua" class="form-check-input" value="ua"
                           required @checked($course->lang === 'ua')>
                    <label for="lang-ua" class="form-check-label">Українська</label>
                </div>
                <div class="form-check form-check-inline mb-3">
                    <input type="radio" name="lang" id="lang-ru" class="form-check-input" value="ru"
                           required @checked($course->lang === 'ru')>
                    <label for="lang-ru" class="form-check-label">Русский</label>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label form-dark" for="name">@lang('school.course_name')</label>
                    <input type="text" class="form-control form-dark" name="name" id="name" value="{{ $course->name }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="service_alt">@lang('school.keywords')</label>
                    <textarea name="course_alt" id="service_alt" rows="3" class="form-control form-dark">{{ $course->course_alt }}</textarea>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    @if($course->id)
        <form action="{{ route('school.courses.destroy', $course->id) }}" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-outline-danger" onclick="return confirm('@lang('school.delete_course')?')">
                <i class="fa-solid fa-trash me-2"></i>@lang('shared.admin.delete')
            </button>
        </form>
    @endif
    <button class="btn btn-primary" form="edit_form" type="submit">
        <i class="fa-solid fa-check me-2"></i>@lang('shared.admin.save')
    </button>
</div>
