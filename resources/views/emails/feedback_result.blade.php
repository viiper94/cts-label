<h3>{{ $result->name }} ({{ $result->email }}) оценил "{{ $feedback->feedback_title }}":</h3>


@foreach($result->rates as $track => $score)
<p>{{ $score }} - "{{ $track }}"</p>
@endforeach

@if(count($result->rates) > 1)
<p>По его мнению, лучший микс в этом релизе - <b>{{ $result->best_track }}</b></p>
@endif

{{$result->name}}<br>
{{$result->email}}<br>
<br>
{{$result->comment}}
