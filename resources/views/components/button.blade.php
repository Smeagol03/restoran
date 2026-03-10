@props([
    'variant' => 'outline',
    'type' => 'button',
    'href' => null,
    'icon' => null,
    'iconTrailing' => null,
    'size' => 'base',
])

@php
$base = 'inline-flex items-center justify-center font-medium transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

$sizes = match ($size) {
    'sm' => 'px-3 py-1.5 text-sm rounded-md',
    'xs' => 'px-2 py-1 text-xs rounded-md',
    default => 'px-4 py-2.5 text-sm rounded-lg',
};

$variants = match ($variant) {
    'primary' => 'bg-zinc-900 text-white hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-100 focus:ring-zinc-500',
    'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
    'ghost' => 'bg-transparent text-zinc-700 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800 focus:ring-zinc-400',
    'subtle' => 'bg-transparent text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white focus:ring-zinc-400',
    'filled' => 'bg-zinc-100 text-zinc-800 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-white dark:hover:bg-zinc-700 focus:ring-zinc-400',
    default => 'bg-white text-zinc-800 border border-zinc-300 hover:bg-zinc-50 dark:bg-zinc-800 dark:text-white dark:border-zinc-600 dark:hover:bg-zinc-700 shadow-sm focus:ring-zinc-400',
};

$classes = "$base $sizes $variants";
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
