@component('mail::message')

## {{ $result->name }} оценил "{{ $feedback->feedback_title }}":

@foreach($result->rates as $track => $score)
**{{ $score }}** - *{{ $track }}*<br>
@endforeach

@if(count($result->rates) > 1)
### По его мнению, лучший микс в этом релизе:<br>
### *{{ $result->best_track }}*
@endif

{{$result->name}} <br>
{{$result->email}} <br>

{{$result->comment}}

@endcomponent
