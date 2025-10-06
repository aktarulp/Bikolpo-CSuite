@props([
    'size' => 'lg', // sm, md, lg, xl
    'showTagline' => true,
    'variant' => 'default' // default, minimal, hero
])

@php
    $sizeClasses = [
        'sm' => [
            'container' => 'text-lg',
            'brand' => 'text-lg font-brand tracking-wide',
            'tagline' => 'text-xs font-medium'
        ],
        'md' => [
            'container' => 'text-xl',
            'brand' => 'text-xl font-brand tracking-wide',
            'tagline' => 'text-xs font-medium'
        ],
        'lg' => [
            'container' => 'text-2xl',
            'brand' => 'text-2xl font-brand tracking-wide',
            'tagline' => 'text-xs font-medium'
        ],
        'xl' => [
            'container' => 'text-3xl',
            'brand' => 'text-3xl font-brand tracking-wide',
            'tagline' => 'text-sm font-medium'
        ]
    ];

    $variantClasses = [
        'default' => [
            'brand' => 'brand-visible',
            'tagline' => 'text-gray-500 dark:text-gray-400 font-medium'
        ],
        'minimal' => [
            'brand' => 'text-gray-900 dark:text-white',
            'tagline' => 'text-gray-500 dark:text-gray-400 font-medium'
        ],
        'hero' => [
            'brand' => 'brand-visible',
            'tagline' => 'text-gray-600 dark:text-gray-400 font-medium'
        ]
    ];

    $classes = $sizeClasses[$size];
    $variantStyles = $variantClasses[$variant];
@endphp

<div class="brand-name-container {{ $classes['container'] }}">
    <h1 class="brand-name {{ $classes['brand'] }} {{ $variantStyles['brand'] }} leading-tight">
        Bikolpo Live
    </h1>
    @if($showTagline)
        <p class="brand-tagline {{ $classes['tagline'] }} {{ $variantStyles['tagline'] }} mt-1">
            Your Smart Exam Partner
        </p>
    @endif
</div>
