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
[{{ route('cv_admin').'/edit/'.$cv->id.'/student' }}]({{ route('cv_admin').'/edit/'.$cv->id.'/student' }})

@component('mail::button', ['url' => url('/'). '/cv/'.$cv->document])
Скачать анкету
@endcomponent

@endcomponent
