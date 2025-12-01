

@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-pet-orange-200 focus:border-pet-orange-400 focus:ring-pet-orange-400/20 rounded-soft shadow-soft bg-pet-cream-50']) !!}>
