@props(['hash' => null])

<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')" :img="false">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{{ $subcopy }}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
@if($hash)
<a href="{{ route('unsubscribe', $hash) }}">@lang('emailing.unsubscribe.unsubscribe_from_letters')</a>
@endif

© {{ date('Y') }} {{ config('app.name') }}. @lang('footer.copyright')
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
