@props(['active'])

@php
$classes = ($active ?? false)
            ? 'text-orange-600'
            : 'text-zinc-500 hover:text-orange-600 dark:text-zinc-400 dark:hover:text-white';
@endphp

<a {{ $attributes->merge(['class' => "px-4 py-2 text-xs font-black uppercase tracking-widest transition-colors $classes"]) }} wire:navigate>
    {{ $slot }}
</a>
