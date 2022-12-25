@component('mail::message')
# Анкета на обучение в CTSchool

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

**Дата заполнения**<br>
*{{ $cv->created_at->format('d/m/Y H:i') }}*

...

Полная анкета доступна по ссылке:<br>
[{{ route('school.cv.index', $cv->id) }}]({{ route('school.cv.index', $cv->id) }})

@endcomponent
