@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-pastel-gray-text']) }}>
    {{ $value ?? $slot }}
</label>
