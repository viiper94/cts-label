@component('mail::message')
# @lang('artists.cv.title')

**@lang('artists.cv.contact_name')**<br>
*{{ $cv->main_contact_name }}*

**@lang('user.email')**<br>
*{{ $cv->main_contact_email }}*

**@lang('artists.cv.phone')**<br>
*{{ $cv->main_contact_phone }}*

**@lang('artists.cv.artists')**<br>
*{{ count($cv->artists_info) }}*

**@lang('cv.created_at')**<br>
*{{ $cv->created_at->format('d/m/Y H:i') }}*

...

@lang('cv.full_cv_access_by_link'):<br>
[{{ route('artists_cv.show', $cv->id) }}]({{ route('artists_cv.show', $cv->id) }})

@endcomponent
