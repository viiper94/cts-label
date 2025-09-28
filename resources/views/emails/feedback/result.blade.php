@component('mail::message')

## {{ $result->name }} оцінив "{{ $feedback->feedback_title }}":

@foreach($result->rates as $track => $score)
**{{ $score }}** - *{{ $track }}*<br>
@endforeach

@if(count($result->rates) > 1)
### На його думку, найкращий мікс в цому релізі:<br>
### *{{ $result->best_track }}*
@endif

{{$result->name}} <br>
{{$result->email}} <br>

{{$result->comment}}

@endcomponent
