@component('mail::message')

*ім'я* <br>
**{{ $data['name'] }}**

*Бажаний курс/послуга* <br>
**{{$data['service']}}**

@if(isset($data['tel']))
*Телефон*<br>
**{{ $data['tel'] }}**
@endif

@if(isset($data['email']))
*E-Mail*<br>
**{{ $data['email'] }}**
@endif

@endcomponent
