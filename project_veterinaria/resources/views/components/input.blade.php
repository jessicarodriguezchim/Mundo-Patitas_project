@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-pastel-aqua/30 focus:border-pastel-aqua focus:ring-pastel-aqua/20 rounded-soft shadow-soft']) !!}>
