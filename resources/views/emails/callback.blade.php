@component('mail::message')

*Имя* <br>
**{{ $data['name'] }}**

*Желаемый курс/услуга* <br>
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
