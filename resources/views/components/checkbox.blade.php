@props(['id' => null, 'checked' => false, 'class' => '', 'value' => '1'])

<div {{ $attributes->merge(['class' => 'form-check '.$class]) }}>
    <input type="hidden" name="{{ $name }}" value="0">
    <input type="checkbox" name="{{ $name }}" id="{{ $id ?? $name }}" class="form-check-input" value="{{ $value }}" @checked($checked)>
    <label for="{{ $id ?? $name }}" class="form-check-label">{{ $slot }}</label>
</div>
