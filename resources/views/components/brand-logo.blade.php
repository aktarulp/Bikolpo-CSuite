@props([
    'size' => 'md', // sm, md, lg, xl
    'showTagline' => true,
    'variant' => 'default', // default, minimal, hero, footer
    'href' => null,
    'logoSize' => null
])

@php
    $sizeConfig = [
        'sm' => [
            'container' => 'flex items-center space-x-2',
            'logo' => 'w-8 h-8',
            'brand' => 'text-lg font-brand tracking-wide',
            'tagline' => 'text-xs font-medium'
        ],
        'md' => [
            'container' => 'flex items-center space-x-3',
            'logo' => 'w-10 h-10',
            'brand' => 'text-xl font-brand tracking-wide',
            'tagline' => 'text-xs font-medium'
        ],
        'lg' => [
            'container' => 'flex items-center space-x-3',
            'logo' => 'w-12 h-12',
            'brand' => 'text-2xl font-black font-brand tracking-wide',
            'tagline' => 'text-xs font-medium'
        ],
        'xl' => [
            'container' => 'flex items-center space-x-4',
            'logo' => 'w-16 h-16',
            'brand' => 'text-3xl font-black font-brand tracking-wide',
            'tagline' => 'text-sm font-medium'
        ]
    ];

    $variantConfig = [
        'default' => [
            'logoBg' => 'bg-gradient-to-br from-primaryGreen to-green-600 shadow-lg',
            'brand' => 'brand-visible',
            'tagline' => 'text-gray-500 dark:text-gray-400 font-medium'
        ],
        'minimal' => [
            'logoBg' => 'bg-gray-100 dark:bg-gray-800 shadow-md',
            'brand' => 'text-gray-900 dark:text-white',
            'tagline' => 'text-gray-500 dark:text-gray-400 font-medium'
        ],
        'hero' => [
            'logoBg' => 'bg-gradient-to-br from-primaryGreen to-green-600 shadow-xl',
            'brand' => 'brand-visible',
            'tagline' => 'text-gray-600 dark:text-gray-400 font-medium'
        ],
        'footer' => [
            'logoBg' => 'bg-gradient-to-br from-primaryGreen to-green-600 shadow-lg',
            'brand' => 'text-white',
            'tagline' => 'text-gray-400 font-medium'
        ]
    ];

    $config = $sizeConfig[$size];
    $variant = $variantConfig[$variant];
    $logoSize = $logoSize ?? $config['logo'];
@endphp

@if($href)
    <a href="{{ $href }}" class="brand-logo-link {{ $config['container'] }} hover:scale-105 transition-transform duration-200">
@else
    <div class="brand-logo-container {{ $config['container'] }}">
@endif

    <!-- Logo -->
    <div class="relative">
        <div class="{{ $logoSize }} {{ $variant['logoBg'] }} rounded-2xl flex items-center justify-center shadow-lg overflow-hidden">
            <img src="{{ asset('images/lq-logo.png') }}" alt="Bikolpo LQ Logo" class="{{ $logoSize }} object-contain">
        </div>
        @if($variant === 'default')
            <div class="absolute -top-1 -right-1 w-3 h-3 bg-primaryOrange rounded-full animate-pulse"></div>
        @endif
    </div>

    <!-- Brand Text -->
    <div class="brand-text">
        <h1 class="brand-name {{ $config['brand'] }} {{ $variant['brand'] }} leading-tight">
            Bikolpo LQ
        </h1>
        @if($showTagline)
            <p class="brand-tagline {{ $config['tagline'] }} {{ $variant['tagline'] }} mt-1">
                Your Smart Exam Partner
            </p>
        @endif
    </div>

@if($href)
    </a>
@else
    </div>
@endif
