@extends('layout.layout')

@section('content')

    <div class="container anketa">
        @include('admin.layout.alert')

        <div class="d-flex justify-content-between py-3">
            <h1 class="text-light mb-0">@lang('cv.title')</h1>
            <div class="lang-switch">
                <div class="btn-group">
                    <a @class(['btn switch-btn', 'active' => isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'en'])
                       data-lang="en" href="{{ route('school.cv') }}">
                        @lang('shared.en')
                    </a>
                    <a @class(['btn switch-btn', 'active' => isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'ru'])
                       data-lang="ru" href="{{ route('school.cv') }}">
                        @lang('shared.ru')
                    </a>
                    <a @class(['btn switch-btn', 'active' => isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'ua' || !isset($_COOKIE['lang'])])
                       data-lang="ua" href="{{ route('school.cv') }}">
                        @lang('shared.ua')
                    </a>
                </div>
            </div>
        </div>

        <form method="post">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-md">
                    <div class="form-group mb-3">
                        <label class="form-label" for="name">1. @lang('cv.name')*</label>
                        <input type="text" class="form-control form-dark" id="name" name="name" required value="{{ old('name') }}" maxlength="190">
                        @if($errors->has('name'))
                            <p class="help-block">{{ $errors->first('name') }}</p>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" for="email">3. @lang('user.email')*</label>
                        <input type="email" class="form-control form-dark" id="email" name="email" required value="{{ old('email') }}" maxlength="190">
                        @if($errors->has('email'))
                            <p class="help-block">{{ $errors->first('email') }}</p>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" for="phone_number">4. @lang('cv.phone_number')*</label>
                        <input type="text" class="form-control form-dark" id="phone_number" name="phone_number" required value="{{ old('phone_number') }}" maxlength="190">
                        @if($errors->has('phone_number'))
                            <p class="help-block">{{ $errors->first('phone_number') }}</p>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" for="address">5. @lang('cv.address')*</label>
                        <input type="text" class="form-control form-dark" id="address" name="address" required value="{{ old('address') }}">
                        @if($errors->has('address'))
                            <p class="help-block">{{ $errors->first('address') }}</p>
                        @endif
                    </div>
                </div>
                <div class="col-xs-12 col-md-auto">
                    <div class="form-group d-flex flex-column mb-3">
                        <label class="form-label" for="birth_date">2. @lang('cv.birth_date')*</label>
                        <input type="hidden" class="form-control form-dark" id="birth_date" name="birth_date" required value="{{ old('birth_date') }}" autocomplete="off">
                        @if($errors->has('birth_date'))
                            <p class="help-block">{{ $errors->first('birth_date') }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-xs-12 mb-3 user-socials">
                    <label class="form-label">6. @lang('cv.social')</label>
                    <div class="col-12 mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input social-checkbox" id="facebook">
                            <label for="facebook" class="form-check-label">@lang('cv.facebook')</label>
                        </div>
                        <div class="col-xs-12">
                            <input type="text" class="form-control form-dark social-input" name="facebook" id="facebook" value="{{ old('facebook') }}" maxlength="190">
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input social-checkbox" id="instagram">
                            <label for="instagram" class="form-check-label">@lang('cv.instagram')</label>
                        </div>
                        <div class="col-xs-12">
                            <input type="text" class="form-control form-dark social-input" name="instagram" id="instagram" value="{{ old('instagram') }}" maxlength="190">
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input social-checkbox" id="soundcloud">
                            <label for="soundcloud" class="form-check-label">@lang('cv.soundcloud')</label>
                        </div>
                        <div class="col-xs-12">
                            <input type="text" class="form-control form-dark social-input" name="soundcloud" id="soundcloud" value="{{ old('soundcloud') }}" maxlength="190">
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input social-checkbox" id="other_social">
                            <label for="other_social" class="form-check-label">@lang('cv.other_social')</label>
                        </div>
                        <div class="col-xs-12">
                            <input type="text" class="form-control form-dark social-input" name="other_social" id="other_social" value="{{ old('other_social') }}" maxlength="190">
                        </div>
                    </div>
                </div>
                <div class="form-group col-xs-12 mb-3">
                    <label class="form-label" for="education">7. @lang('cv.education')*</label>
                    <input type="text" class="form-control form-dark" id="education" name="education" required value="{{ old('education') }}">
                    @if($errors->has('education'))
                        <p class="help-block">{{ $errors->first('education') }}</p>
                    @endif
                </div>
                <div class="form-group col-xs-12 mb-3">
                    <label class="form-label" for="job">8. @lang('cv.job')*</label>
                    <input type="text" class="form-control form-dark" id="job" name="job" required value="{{ old('job') }}">
                    @if($errors->has('job'))
                        <p class="help-block">{{ $errors->first('job') }}</p>
                    @endif
                </div>
                <div class="form-group col-xs-12 mb-3">
                    <label class="form-label" for="dj_name">9. @lang('cv.dj_name')</label>
                    <input type="text" class="form-control form-dark" id="dj_name" name="dj_name" value="{{ old('dj_name') }}">
                    @if($errors->has('dj_name'))
                        <p class="help-block">{{ $errors->first('dj_name') }}</p>
                    @endif
                </div>
                <div class="form-group col-xs-12 mb-3">
                    <label class="form-label" for="sound_engineer_skills">10. @lang('cv.sound_engineer_skills')</label>
                    <textarea class="form-control form-dark" id="sound_engineer_skills" name="sound_engineer_skills">{{ old('sound_engineer_skills') }}</textarea>
                    @if($errors->has('sound_engineer_skills'))
                        <p class="help-block">{{ $errors->first('sound_engineer_skills') }}</p>
                    @endif
                </div>
                <div class="form-group col-xs-12 mb-3">
                    <label class="form-label" for="sound_producer_skills">11. @lang('cv.sound_producer_skills')</label>
                    <textarea class="form-control form-dark" id="sound_producer_skills" name="sound_producer_skills">{{ old('sound_producer_skills') }}</textarea>
                    @if($errors->has('sound_producer_skills'))
                        <p class="help-block">{{ $errors->first('sound_producer_skills') }}</p>
                    @endif
                </div>
                <div class="form-group col-xs-12 mb-3">
                    <label class="form-label" for="dj_skills">12. @lang('cv.dj_skills')</label>
                    <textarea class="form-control form-dark" id="dj_skills" name="dj_skills">{{ old('dj_skills') }}</textarea>
                    @if($errors->has('dj_skills'))
                        <p class="help-block">{{ $errors->first('dj_skills') }}</p>
                    @endif
                </div>
                <div class="form-group col-xs-12 mb-3">
                    <label class="form-label" for="music_genres">13. @lang('cv.music_genres')</label>
                    <textarea class="form-control form-dark" id="music_genres" name="music_genres">{{ old('music_genres') }}</textarea>
                    @if($errors->has('music_genres'))
                        <p class="help-block">{{ $errors->first('music_genres') }}</p>
                    @endif
                </div>
                <div class="form-group col-xs-12 mb-3">
                    <label class="form-label" for="os">14. @lang('cv.os')</label>
                    <input type="text" class="form-control form-dark" id="os" name="os" value="{{ old('os') }}">
                    @if($errors->has('os'))
                        <p class="help-block">{{ $errors->first('os') }}</p>
                    @endif
                </div>
                <div class="form-group col-xs-12 mb-3">
                    <label class="form-label" for="equipment">15. @lang('cv.equipment')</label>
                    <textarea class="form-control form-dark" id="equipment" name="equipment">{{ old('equipment') }}</textarea>
                    @if($errors->has('equipment'))
                        <p class="help-block">{{ $errors->first('equipment') }}</p>
                    @endif
                </div>
                <div class="form-group col-xs-12 mb-3">
                    <label class="form-label" for="additional_info">16. @lang('cv.additional_info')</label>
                    <textarea class="form-control form-dark" name="additional_info" id="additional_info">{{ old('additional_info') }}</textarea>
                    @if($errors->has('additional_info'))
                        <p class="help-block">{{ $errors->first('additional_info') }}</p>
                    @endif
                </div>
                <div class="form-group col-xs-12 mb-3">
                    <label class="form-label" for="learned_about_ctschool">17. @lang('cv.learned_about_ctschool')*</label>
                    <textarea class="form-control form-dark" id="learned_about_ctschool" name="learned_about_ctschool" required>{{ old('learned_about_ctschool') }}</textarea>
                    @if($errors->has('learned_about_ctschool'))
                        <p class="help-block">{{ $errors->first('learned_about_ctschool') }}</p>
                    @endif
                </div>
                <div class="form-group col-xs-12 mb-3">
                    <label class="form-label" for="course">18. @lang('cv.course')*</label>
                    <select class="form-control form-dark" id="course" name="course" required>
                        <option selected disabled>@lang('cv.pick_a_course')</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->name }}" @if(old('course') === $course->name) selected @endif>{{ $course->name }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('course'))
                        <p class="help-block">{{ $errors->first('course') }}</p>
                    @endif
                </div>
                <div class="form-group col-xs-12 mb-3">
                    <label class="form-label" for="what_to_learn">19. @lang('cv.what_to_learn')</label>
                    <textarea class="form-control form-dark" id="what_to_learn" name="what_to_learn">{{ old('what_to_learn') }}</textarea>
                    @if($errors->has('what_to_learn'))
                        <p class="help-block">{{ $errors->first('what_to_learn') }}</p>
                    @endif
                </div>
                <div class="form-group col-xs-12 mb-3">
                    <label class="form-label" for="purpose_of_learning">20. @lang('cv.purpose_of_learning')</label>
                    <textarea class="form-control form-dark" id="purpose_of_learning" name="purpose_of_learning">{{ old('purpose_of_learning') }}</textarea>
                    @if($errors->has('purpose_of_learning'))
                        <p class="help-block">{{ $errors->first('purpose_of_learning') }}</p>
                    @endif
                </div>
                <div class="form-group col-xs-12">
                    <button type="submit" class="btn btn-lg btn-outline">@lang('cv.submit')</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        const picker = new Litepicker({
            element: document.getElementById('birth_date'),
            inlineMode: true,
            lang: '{{ app()->getLocale() }}',
            dropdowns: {
                "minYear": 1950,
                "maxYear": null,
                "months": true,
                "years": true
            }
        });
    </script>
@endsection
