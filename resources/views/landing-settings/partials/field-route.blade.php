@php
    $inputId = $id ?? str_replace(['[', ']', '.'], '_', $name);
    $selected = old($name, $value ?? 'landing');
@endphp
<div class="{{ $class ?? '' }}">
    <label for="{{ $inputId }}" class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">{{ $label }}</label>
    <select id="{{ $inputId }}" name="{{ $name }}" class="form-select">
        @foreach ($ctaRoutes as $route => $routeLabel)
            <option value="{{ $route }}" @selected($selected === $route)>{{ $routeLabel }}</option>
        @endforeach
    </select>
</div>