@props([
    'sidebar' => false,
])

@if($sidebar)
    <a {{ $attributes->merge(['class' => 'flex items-center gap-2 font-semibold text-zinc-900 dark:text-white']) }}>
        <span class="flex aspect-square size-8 items-center justify-center rounded-md bg-zinc-900 dark:bg-white">
            <x-app-logo-icon class="size-5 fill-current text-white dark:text-black" />
        </span>
        <span>{{ config('app.name') }}</span>
    </a>
@else
    <a {{ $attributes->merge(['class' => 'flex items-center gap-2 font-semibold text-zinc-900 dark:text-white']) }}>
        <span class="flex aspect-square size-8 items-center justify-center rounded-md bg-zinc-900 dark:bg-white">
            <x-app-logo-icon class="size-5 fill-current text-white dark:text-black" />
        </span>
        <span>{{ config('app.name') }}</span>
    </a>
@endif
