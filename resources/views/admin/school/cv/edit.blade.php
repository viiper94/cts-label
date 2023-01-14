@extends('admin.layout.layout')

@section('title')
    Анкета от {{ $cv->name }} | CTS Records Admin Panel
@endsection

@section('admin-content')

    <div class="container-fluid admin-cv">
        <div class="d-flex my-3">
            @if(is_file(public_path('cv/'.$cv->document)))
                <a href="{{ url('/'). '/cv/'.$cv->document }}" class="btn btn-primary">
                    <i class="fa-solid fa-file-word me-2"></i>Скачать анкету
                </a>
            @else
                <a href="{{ route('school.cv.document', $cv->id) }}" class="btn btn-primary">
                    <i class="fa-solid fa-gears me-2"></i>Cгенерировать документ
                </a>
            @endif
        </div>
        <div class="card text-bg-dark cv-data mb-3">
            <div class="card-body row g-0">
                <div class="col-xs-12 col-md-6 my-3 px-3">
                    <p class="text-muted mb-0"><i>1. @lang('cv.name')</i></p>
                    <p class="mb-0 fs-4"><b>{{ $cv->name }}</b></p>
                </div>
                <div class="col-xs-12 col-md-6 my-3 px-3">
                    <p class="text-muted mb-0"><i>2. @lang('user.email')</i></p>
                    <p class="mb-0 fs-4"><b>{{ $cv->email }}</b></p>
                </div>
                <div class="col-xs-12 col-md-6 my-3 px-3">
                    <p class="text-muted mb-0"><i>3. @lang('cv.birth_date')</i></p>
                    <p class="mb-0 fs-4"><b>{{ date('j F Y', $cv->birth_date->getTimestamp()) }}</b></p>
                </div>
                <div class="col-xs-12 col-md-6 my-3 px-3">
                    <p class="text-muted mb-0"><i>4. @lang('cv.phone_number')</i></p>
                    <p class="mb-0 fs-4"><b>{{ $cv->phone_number }}</b></p>
                </div>
                <div class="col-xs-12 my-3 px-3">
                    <p class="text-muted mb-0"><i>5. @lang('cv.address')</i></p>
                    <p class="mb-0 fs-4"><b>{{ $cv->address }}</b></p>
                </div>

                <div class="col-xs-12 col-md-6 my-3 px-3">
                    <p class="text-muted mb-0"><i>7. @lang('cv.education')</i></p>
                    <p class="mb-0 fs-4"><b>{{ $cv->education }}</b></p>
                </div>
                <div class="col-xs-12 col-md-6 my-3 px-3">
                    <p class="text-muted mb-0"><i>8. @lang('cv.job')</i></p>
                    <p class="mb-0 fs-4"><b>{{ $cv->job }}</b></p>
                </div>
                <div class="col-xs-12 col-md-6 my-3 px-3">
                    <p class="text-muted mb-0"><i>9. @lang('cv.dj_name')</i></p>
                    <p class="mb-0 fs-4"><b>{{ $cv->dj_name ?? '—' }}</b></p>
                </div>
                <div class="col-xs-12 col-md-6 my-3 px-3">
                    <p class="text-muted mb-0"><i>10. @lang('cv.sound_engineer_skills')</i></p>
                    <p class="mb-0 fs-4"><b>{{ $cv->sound_engineer_skills ?? '—' }}</b></p>
                </div>
                <div class="col-xs-12 col-md-6 my-3 px-3">
                    <p class="text-muted mb-0"><i>11. @lang('cv.sound_producer_skills')</i></p>
                    <p class="mb-0 fs-4"><b>{{ $cv->sound_producer_skills ?? '—' }}</b></p>
                </div>
                <div class="col-xs-12 col-md-6 my-3 px-3">
                    <p class="text-muted mb-0"><i>12. @lang('cv.dj_skills')</i></p>
                    <p class="mb-0 fs-4"><b>{{ $cv->dj_skills ?? '—' }}</b></p>
                </div>
                <div class="col-xs-12 my-3 px-3">
                    <p class="text-muted mb-0"><i>13. @lang('cv.music_genres')</i></p>
                    <p class="mb-0 fs-4"><b>{{ $cv->music_genres }}</b></p>
                </div>
                <div class="col-xs-12 col-md-6 my-3 px-3">
                    <p class="text-muted mb-0"><i>14. @lang('cv.os')</i></p>
                    <p class="mb-0 fs-4"><b>{{ $cv->os ?? '—' }}</b></p>
                </div>
                <div class="col-xs-12 col-md-6 my-3 px-3">
                    <p class="text-muted mb-0"><i>15. @lang('cv.equipment')</i></p>
                    <p class="mb-0 fs-4"><b>{{ $cv->equipment ?? '—' }}</b></p>
                </div>
                <div class="col-xs-12 my-3 px-3">
                    <p class="text-muted mb-0"><i>16. @lang('cv.additional_info')</i></p>
                    <p class="mb-0 fs-4"><b>{{ $cv->additional_info ?? '—' }}</b></p>
                </div>
                <div class="col-xs-12 my-3 px-3">
                    <p class="text-muted mb-0"><i>17. @lang('cv.learned_about_ctschool')</i></p>
                    <p class="mb-0 fs-4"><b>{{ $cv->learned_about_ctschool }}</b></p>
                </div>
                <div class="col-xs-12 my-3 px-3">
                    <p class="text-muted mb-0"><i>18. @lang('cv.course')</i></p>
                    <p class="mb-0 fs-4"><b>{{ $cv->course }}</b></p>
                </div>
                <div class="col-xs-12 col-md-6 my-3 px-3">
                    <p class="text-muted mb-0"><i>19. @lang('cv.what_to_learn')</i></p>
                    <p class="mb-0 fs-4"><b>{{ $cv->what_to_learn ?? '—' }}</b></p>
                </div>
                <div class="col-xs-12 col-md-6 my-3 px-3">
                    <p class="text-muted mb-0"><i>20. @lang('cv.purpose_of_learning')</i></p>
                    <p class="mb-0 fs-4"><b>{{ $cv->purpose_of_learning ?? '—' }}</b></p>
                </div>
                <div class="col-xs-12 my-3 px-3">
                    <p class="text-muted mb-0"><i>21. Дата заполнения</i></p>
                    <p class="mb-0 fs-4"><b>{{ $cv->created_at->format('d/m/Y H:i') }}</b></p>
                </div>
            </div>
        </div>
    </div>

@endsection
