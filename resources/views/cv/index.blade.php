@extends('layout.layout')

@section('assets')
    <link href="/assets/js/gijgo/css/gijgo.min.css" rel="stylesheet">
    <link href="/assets/css/cts-admin.css" rel="stylesheet">
@endsection

@section('scripts')
    <script src="/assets/js/gijgo/js/gijgo.min.js"></script>
@endsection

@section('content')

    <div class="container">
        @include('admin.layout.alert')
        <form method="post">
            @csrf
            <div class="form-group col-md-6 col-xs-12">
                <label for="name">1. @lang('cv.name')*</label>
                <input type="text" class="form-control form-control__dark" id="name" name="name" required value="{{ old('name') }}" maxlength="190">
                @if($errors->has('name'))
                    <p class="help-block">{{ $errors->first('name') }}</p>
                @endif
            </div>
            <div class="form-group col-md-6 col-xs-12">
                <label for="email">2. @lang('user.email')*</label>
                <input type="email" class="form-control form-control__dark" id="email" name="email" required value="{{ old('email') ?? $user->email }}" maxlength="190">
                @if($errors->has('email'))
                    <p class="help-block">{{ $errors->first('email') }}</p>
                @endif
            </div>
            <div class="form-group col-md-6 col-xs-12">
                <label for="birth_date">3. @lang('cv.birth_date')*</label>
                <input type="text" class="form-control form-control__dark" id="birth_date" name="birth_date" required value="{{ old('birth_date') }}" autocomplete="off">
                @if($errors->has('birth_date'))
                    <p class="help-block">{{ $errors->first('birth_date') }}</p>
                @endif
            </div>
            <div class="form-group col-md-6 col-xs-12">
                <label for="phone_number">4. @lang('cv.phone_number')*</label>
                <input type="text" class="form-control form-control__dark" id="phone_number" name="phone_number" required value="{{ old('phone_number') }}" maxlength="190">
                @if($errors->has('phone_number'))
                    <p class="help-block">{{ $errors->first('phone_number') }}</p>
                @endif
            </div>
            <div class="form-group col-xs-12">
                <label for="address">5. @lang('cv.address')*</label>
                <input type="text" class="form-control form-control__dark" id="address" name="address" required value="{{ old('address') }}">
                @if($errors->has('address'))
                    <p class="help-block">{{ $errors->first('address') }}</p>
                @endif
            </div>
            <div class="form-group col-xs-12">
                <label>6. @lang('cv.social')</label>
                <div class="col-xs-12">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="social-checkbox" data-target="vk"> @lang('cv.vk')
                        </label>
                    </div>
                </div>
                <div class="col-xs-12">
                    <input type="text" class="form-control form-control__dark social-input" name="vk" id="vk" value="{{ old('vk') }}" maxlength="190">
                </div>
                <div class="col-xs-12">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="social-checkbox" data-target="facebook"> @lang('cv.facebook')
                        </label>
                    </div>
                </div>
                <div class="col-xs-12">
                    <input type="text" class="form-control form-control__dark social-input" name="facebook" value="{{ old('facebook') }}" maxlength="190">
                </div>
                <div class="col-xs-12">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="social-checkbox" data-target="soundcloud"> @lang('cv.soundcloud')
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-xs-12">
                    <input type="text" class="form-control form-control__dark social-input" name="soundcloud" value="{{ old('soundcloud') }}" maxlength="190">
                </div>
                <div class="col-xs-12">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="social-checkbox" data-target="other_social"> @lang('cv.other_social')
                        </label>
                    </div>
                </div>
                <div class="col-xs-12">
                    <input type="text" class="form-control form-control__dark social-input" name="other_social" value="{{ old('other_social') }}" maxlength="190">
                </div>
            </div>
            <div class="form-group col-xs-12">
                <label for="education">7. @lang('cv.education')*</label>
                <input type="text" class="form-control form-control__dark" id="education" name="education" required value="{{ old('education') }}">
                @if($errors->has('education'))
                    <p class="help-block">{{ $errors->first('education') }}</p>
                @endif
            </div>
            <div class="form-group col-xs-12">
                <label for="job">8. @lang('cv.job')*</label>
                <input type="text" class="form-control form-control__dark" id="job" name="job" required value="{{ old('job') }}">
                @if($errors->has('job'))
                    <p class="help-block">{{ $errors->first('job') }}</p>
                @endif
            </div>
            <div class="form-group col-xs-12">
                <label for="dj_name">9. @lang('cv.dj_name')</label>
                <input type="text" class="form-control form-control__dark" id="dj_name" name="dj_name" value="{{ old('dj_name') }}">
                @if($errors->has('dj_name'))
                    <p class="help-block">{{ $errors->first('dj_name') }}</p>
                @endif
            </div>
            <div class="form-group col-xs-12">
                <label for="sound_engineer_skills">10. @lang('cv.sound_engineer_skills')</label>
                <input type="text" class="form-control form-control__dark" id="sound_engineer_skills" name="sound_engineer_skills" value="{{ old('sound_engineer_skills') }}">
                @if($errors->has('sound_engineer_skills'))
                    <p class="help-block">{{ $errors->first('sound_engineer_skills') }}</p>
                @endif
            </div>
            <div class="form-group col-xs-12">
                <label for="sound_producer_skills">11. @lang('cv.sound_producer_skills')</label>
                <input type="text" class="form-control form-control__dark" id="sound_producer_skills" name="sound_producer_skills" value="{{ old('sound_producer_skills') }}">
                @if($errors->has('sound_producer_skills'))
                    <p class="help-block">{{ $errors->first('sound_producer_skills') }}</p>
                @endif
            </div>
            <div class="form-group col-xs-12">
                <label for="dj_skills">12. @lang('cv.dj_skills')</label>
                <input type="text" class="form-control form-control__dark" id="dj_skills" name="dj_skills" value="{{ old('dj_skills') }}">
                @if($errors->has('dj_skills'))
                    <p class="help-block">{{ $errors->first('dj_skills') }}</p>
                @endif
            </div>
            <div class="form-group col-xs-12">
                <label for="music_genres">13. @lang('cv.music_genres')*</label>
                <input type="text" class="form-control form-control__dark" id="music_genres" name="music_genres" required value="{{ old('music_genres') }}">
                @if($errors->has('music_genres'))
                    <p class="help-block">{{ $errors->first('music_genres') }}</p>
                @endif
            </div>
            <div class="form-group col-xs-12">
                <label for="additional_info">14. @lang('cv.additional_info')</label>
                <textarea class="form-control form-control__dark" name="additional_info" id="additional_info">{{ old('additional_info') }}</textarea>
                @if($errors->has('additional_info'))
                    <p class="help-block">{{ $errors->first('additional_info') }}</p>
                @endif
            </div>
            <div class="form-group col-xs-12">
                <label for="learned_about_ctschool">15. @lang('cv.learned_about_ctschool')*</label>
                <input type="text" class="form-control form-control__dark" id="learned_about_ctschool" name="learned_about_ctschool" required value="{{ old('learned_about_ctschool') }}">
                @if($errors->has('learned_about_ctschool'))
                    <p class="help-block">{{ $errors->first('learned_about_ctschool') }}</p>
                @endif
            </div>
            <div class="form-group col-xs-12">
                <label for="course">16. @lang('cv.course')*</label>
                <select class="form-control form-control__dark" id="course" name="course" required>
                    <option selected disabled>Выберите курс</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->name }}" @if(old('course') === $course->name) selected @endif>{{ $course->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('course'))
                    <p class="help-block">{{ $errors->first('course') }}</p>
                @endif
            </div>
            <div class="form-group col-xs-12">
                <label for="what_to_learn">17. @lang('cv.what_to_learn')</label>
                <input type="text" class="form-control form-control__dark" id="what_to_learn" name="what_to_learn" value="{{ old('what_to_learn') }}">
                @if($errors->has('what_to_learn'))
                    <p class="help-block">{{ $errors->first('what_to_learn') }}</p>
                @endif
            </div>
            <div class="form-group col-xs-12">
                <label for="purpose_of_learning">18. @lang('cv.purpose_of_learning')</label>
                <input type="text" class="form-control form-control__dark" id="purpose_of_learning" name="purpose_of_learning" value="{{ old('purpose_of_learning') }}">
                @if($errors->has('purpose_of_learning'))
                    <p class="help-block">{{ $errors->first('purpose_of_learning') }}</p>
                @endif
            </div>
            <div class="form-group col-xs-12">
                <button type="submit" class="btn btn-default">@lang('cv.submit')</button>
            </div>
        </form>
    </div>

    <script>
        $('#birth_date').datepicker({
            uiLibrary: 'bootstrap',
            format: 'dd mmmm yyyy'
        });
    </script>
@endsection
