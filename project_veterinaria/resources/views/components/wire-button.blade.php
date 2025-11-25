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
    // Determine color classes - usando paleta pastel tierna
    $colorClasses = '';
    if ($blue) {
        // Botón principal: aguamarina suave
        $colorClasses = 'bg-pastel-aqua hover:bg-[#8FD9D9] focus:ring-pastel-aqua/50 text-white shadow-soft hover:shadow-soft-lg';
    } elseif ($red) {
        // Botón de acción destructiva: rosa pastel más intenso
        $colorClasses = 'bg-pastel-pink hover:bg-[#F5B5C0] focus:ring-pastel-pink/50 text-white shadow-soft-pink hover:shadow-soft-lg';
    } elseif ($green) {
        // Botón de éxito: aguamarina con toque verde
        $colorClasses = 'bg-pastel-aqua hover:bg-[#8FD9D9] focus:ring-pastel-aqua/50 text-white shadow-soft hover:shadow-soft-lg';
    } elseif ($yellow) {
        // Botón de advertencia: amarillo pastel
        $colorClasses = 'bg-pastel-yellow hover:bg-[#FFF59E] focus:ring-pastel-yellow/50 text-pastel-gray-text shadow-soft hover:shadow-soft-lg';
    } elseif ($purple) {
        // Botón secundario: melocotón suave
        $colorClasses = 'bg-pastel-peach hover:bg-[#FFD0A8] focus:ring-pastel-peach/50 text-pastel-gray-text shadow-soft hover:shadow-soft-lg';
    } else {
        // Botón por defecto: gris suave
        $colorClasses = 'bg-pastel-gray-text/20 hover:bg-pastel-gray-text/30 focus:ring-pastel-gray-text/30 text-pastel-gray-text shadow-soft hover:shadow-soft-lg';
    }
    
    // Determine size classes
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









