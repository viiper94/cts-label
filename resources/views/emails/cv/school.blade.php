@component('mail::message')
# @lang('cv.title')

**@lang('cv.name')**<br>
*{{ $cv->name }}*

**@lang('user.email')**<br>
*{{ $cv->email }}*

**@lang('cv.birth_date')**<br>
*{{ $cv->birth_date->format('d/m/Y') }}*

**@lang('cv.phone_number')**<br>
*{{ $cv->phone_number }}*

**@lang('cv.course')**<br>
*{{ $cv->course }}*

**@lang('cv.created_at')**<br>
*{{ $cv->created_at->format('d/m/Y H:i') }}*

...

@lang('cv.full_cv_access_by_link'):<br>
[{{ route('school.cv.index', $cv->id) }}]({{ route('school.cv.index', $cv->id) }})

@endcomponent
