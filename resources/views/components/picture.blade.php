@props(['src'])

<picture>
    @foreach($src as $item)
        @if(!$hasFile($item)) @continue @endif
        <source srcset="{{ $item }}" type="{{ $type($item) }}">
        @if($loop->last)
            <img src="{{ $item }}" {{ $attributes }}>
        @endif
    @endforeach
</picture>
