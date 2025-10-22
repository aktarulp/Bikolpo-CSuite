@props([
    'size' => 'lg', // sm, md, lg, xl
    'href' => null,
    'showTagline' => true,
    'bg' => 'bg-white/80 dark:bg-gray-800/80 backdrop-blur-md', // default background classes – translucent white in light mode / dark gray in dark mode
])

@php
    $sizeConfig = [
        'sm' => [
            'logo' => 'w-8 h-8',
            'brand' => 'text-lg font-black tracking-wide',
            'tagline' => 'text-[10px] font-medium',
            'gap' => 'space-x-2',
        ],
        'md' => [
            'logo' => 'w-10 h-10',
            'brand' => 'text-xl font-black tracking-wide',
            'tagline' => 'text-xs font-medium',
            'gap' => 'space-x-3',
        ],
        'lg' => [
            'logo' => 'w-12 h-12',
            'brand' => 'text-2xl font-black tracking-wide',
            'tagline' => 'text-sm font-medium',
            'gap' => 'space-x-3',
        ],
        'xl' => [
            'logo' => 'w-16 h-16',
            'brand' => 'text-3xl font-black tracking-wide',
            'tagline' => 'text-base font-medium',
            'gap' => 'space-x-4',
        ],
    ];

    $config = $sizeConfig[$size] ?? $sizeConfig['lg'];
@endphp

@if($href)
<a href="{{ $href }}" class="inline-block transform hover:scale-105 transition-transform duration-200">
@else
<div>
@endif
    <div class="flex items-center {{ $config['gap'] }} rounded-2xl px-3 py-2 shadow-lg {{ $bg }}">
        <!-- Logo image -->
        <img src="{{ asset('images/bikolpoLive_TR.png') }}" alt="Bikolpo Live Logo" class="{{ $config['logo'] }} object-contain select-none" draggable="false" />

        <!-- Brand title & tagline -->
        <div class="leading-tight">
            <h1 class="{{ $config['brand'] }} text-gray-900 dark:text-white whitespace-nowrap">
                Bikolpo <span class="text-primaryGreen">Live</span>
            </h1>
            @if($showTagline)
                <p class="{{ $config['tagline'] }} text-gray-600 dark:text-gray-400 whitespace-nowrap">Your Smart Exam Partner</p>
            @endif
        </div>
    </div>
@if($href)
</a>
@else
</div>
@endif