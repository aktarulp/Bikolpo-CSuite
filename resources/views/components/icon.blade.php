@props([
    'name',
    'class' => 'w-5 h-5',
    'title' => null
])

<svg 
    {{ $attributes->merge(['class' => $class]) }}
    @if($title)
        role="img" 
        aria-label="{{ $title }}"
    @else
        aria-hidden="true"
    @endif
>
    <use xlink:href="#icon-{{ $name }}"></use>
</svg>
