

@props([
    'href' => null,
    'type' => 'button',
    'blue' => false,
    'red' => false,
    'green' => false,
    'yellow' => false,
    'purple' => false,
    'xs' => false,
    'sm' => false,
    'lg' => false,
])

@php
    $colorClasses = '';
    if ($blue) {
        $colorClasses = 'bg-pet-green-500 hover:bg-pet-green-600 focus:ring-pet-green-500/50 text-white shadow-soft-green hover:shadow-soft-lg';
    } elseif ($red) {
        $colorClasses = 'bg-pet-orange-600 hover:bg-pet-orange-700 focus:ring-pet-orange-600/50 text-white shadow-soft hover:shadow-soft-lg';
    } elseif ($green) {
        $colorClasses = 'bg-pet-green-500 hover:bg-pet-green-600 focus:ring-pet-green-500/50 text-white shadow-soft-green hover:shadow-soft-lg';
    } elseif ($yellow) {
        $colorClasses = 'bg-pet-orange-300 hover:bg-pet-orange-400 focus:ring-pet-orange-300/50 text-pet-orange-800 shadow-soft hover:shadow-soft-lg';
    } elseif ($purple) {
        $colorClasses = 'bg-pet-orange-200 hover:bg-pet-orange-300 focus:ring-pet-orange-200/50 text-pet-orange-700 shadow-soft-pink hover:shadow-soft-lg';
    } else {
        $colorClasses = 'bg-pet-orange-500 hover:bg-pet-orange-600 focus:ring-pet-orange-500/50 text-white shadow-soft hover:shadow-soft-lg';
    }
    
    $sizeClasses = '';
    if ($xs) {
        $sizeClasses = 'px-2 py-1 text-xs';
    } elseif ($sm) {
        $sizeClasses = 'px-3 py-1.5 text-sm';
    } elseif ($lg) {
        $sizeClasses = 'px-6 py-3 text-base';
    } else {
        $sizeClasses = 'px-4 py-2 text-sm';
    }
    
    $baseClasses = 'inline-flex items-center justify-center border border-transparent rounded-soft font-semibold uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 transition-all ease-in-out duration-200';
    
    $classes = "$baseClasses $colorClasses $sizeClasses";
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif

