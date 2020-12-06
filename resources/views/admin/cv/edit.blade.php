@extends('admin.layout.layout')

@section('admin-content')

    <div class="container">
        <form action="{{ route('cv_admin') }}/document" method="post">
            @csrf
            <input type="hidden" name="id" value="{{ $cv->id }}">
            <button class="btn btn-info" type="submit"><span class="glyphicon glyphicon-save" aria-hidden="true"></span> Сохранить в документ</button>
        </form>
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <h5><i>1. @lang('cv.name')</i></h5>
                <blockquote><b>{{ $cv->name }}</b></blockquote>
            </div>
            <div class="col-xs-12 col-md-6">
                <h5><i>2. @lang('user.email')</i></h5>
                <blockquote><b>{{ $cv->email }}</b></blockquote>
            </div>
            <div class="col-xs-12 col-md-6">
                <h5><i>3. @lang('cv.birth_date')</i></h5>
                <blockquote><b>{{ date('j F Y', $cv->birth_date->getTimestamp()) }}</b></blockquote>
            </div>
            <div class="col-xs-12 col-md-6">
                <h5><i>4. @lang('cv.phone_number')</i></h5>
                <blockquote><b>{{ $cv->phone_number }}</b></blockquote>
            </div>
            <div class="col-xs-12">
                <h5><i>5. @lang('cv.address')</i></h5>
                <blockquote><b>{{ $cv->address }}</b></blockquote>
            </div>

            <div class="col-xs-12">
                <h5><i>7. @lang('cv.education')</i></h5>
                <blockquote><b>{{ $cv->education }}</b></blockquote>
            </div>
            <div class="col-xs-12">
                <h5><i>8. @lang('cv.job')</i></h5>
                <blockquote><b>{{ $cv->job }}</b></blockquote>
            </div>
            <div class="col-xs-12">
                <h5><i>9. @lang('cv.dj_name')</i></h5>
                <blockquote><b>{{ $cv->dj_name ?? '—' }}</b></blockquote>
            </div>
            <div class="col-xs-12">
                <h5><i>10. @lang('cv.sound_engineer_skills')</i></h5>
                <blockquote><b>{{ $cv->sound_engineer_skills ?? '—' }}</b></blockquote>
            </div>
            <div class="col-xs-12">
                <h5><i>11. @lang('cv.sound_producer_skills')</i></h5>
                <blockquote><b>{{ $cv->sound_producer_skills ?? '—' }}</b></blockquote>
            </div>
            <div class="col-xs-12">
                <h5><i>12. @lang('cv.dj_skills')</i></h5>
                <blockquote><b>{{ $cv->dj_skills ?? '—' }}</b></blockquote>
            </div>
            <div class="col-xs-12">
                <h5><i>13. @lang('cv.music_genres')</i></h5>
                <blockquote><b>{{ $cv->music_genres }}</b></blockquote>
            </div>
            <div class="col-xs-12">
                <h5><i>14. @lang('cv.additional_info')</i></h5>
                <blockquote><b>{{ $cv->additional_info ?? '—' }}</b></blockquote>
            </div>
            <div class="col-xs-12">
                <h5><i>15. @lang('cv.learned_about_ctschool')</i></h5>
                <blockquote><b>{{ $cv->learned_about_ctschool }}</b></blockquote>
            </div>
            <div class="col-xs-12">
                <h5><i>16. @lang('cv.course')</i></h5>
                <blockquote><b>{{ $cv->course }}</b></blockquote>
            </div>
            <div class="col-xs-12">
                <h5><i>17. @lang('cv.what_to_learn')</i></h5>
                <blockquote><b>{{ $cv->what_to_learn ?? '—' }}</b></blockquote>
            </div>
            <div class="col-xs-12">
                <h5><i>18. @lang('cv.purpose_of_learning')</i></h5>
                <blockquote><b>{{ $cv->purpose_of_learning ?? '—' }}</b></blockquote>
            </div>
        </div>
    </div>

@endsection
