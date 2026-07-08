@php
    $inputName = $name;
    $inputId = $id ?? str_replace(['[', ']', '.'], '_', $name);
    $inputValue = old($name, $value ?? '');
    $rows = $rows ?? 1;
@endphp
<div class="{{ $class ?? '' }}">
    <label for="{{ $inputId }}" class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">{{ $label }}</label>
    @if ($rows > 1)
        <textarea id="{{ $inputId }}" name="{{ $inputName }}" class="form-input" rows="{{ $rows }}">{{ $inputValue }}</textarea>
    @else
        <input type="text" id="{{ $inputId }}" name="{{ $inputName }}" class="form-input" value="{{ $inputValue }}">
    @endif
    @if (! empty($hint))
        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $hint }}</p>
    @endif
</div>