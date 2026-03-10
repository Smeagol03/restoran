@props([
    'color' => 'zinc',
    'variant' => null,
    'size' => null,
])

@php
$sizeClasses = match ($size) {
    'sm' => 'text-xs px-2 py-0.5',
    'lg' => 'text-sm px-3 py-1.5',
    default => 'text-xs px-2.5 py-1',
};

$colorClasses = $variant === 'solid' ? match ($color) {
    'orange' => 'bg-orange-500 text-white',
    'yellow' => 'bg-yellow-500 text-white',
    'green' => 'bg-green-500 text-white',
    'red' => 'bg-red-500 text-white',
    'blue' => 'bg-blue-500 text-white',
    default => 'bg-zinc-600 text-white',
} : match ($color) {
    'orange' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-300',
    'yellow' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
    'green' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
    'red' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
    'blue' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
    default => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300',
};
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center font-medium rounded-md $sizeClasses $colorClasses"]) }}>
    {{ $slot }}
</span>
