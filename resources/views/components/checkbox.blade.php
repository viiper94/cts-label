@props(['id' => null, 'checked' => false, 'class' => ''])

<div {{ $attributes->merge(['class' => 'form-check '.$class]) }}>
    <input type="hidden" name="{{ $name }}" value="0">
    <input type="checkbox" name="{{ $name }}" id="{{ $id ?? $name }}" class="form-check-input" value="1" @checked($checked)>
    <label for="{{ $id ?? $name }}" class="form-check-label">{!! $label !!}</label>
</div>
