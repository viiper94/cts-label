@props([
    'url',
     'img' => true])
<tr>
<td class="header">
@if($img)
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'CTS Records')
<img src="https://cts-label.com/images/logo.png" class="logo" alt="CTS Records logo" style="width: auto">
@else
{{ $slot }}
@endif
</a>
@endif
</td>
</tr>
