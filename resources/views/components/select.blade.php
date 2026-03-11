@props([
    'disabled' => false,
    'error' => false,
])

<select {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => 'block w-full rounded-xl border ' . ($error ? 'border-red-300 dark:border-red-900/50' : 'border-zinc-200 dark:border-zinc-800') . ' bg-zinc-50/50 dark:bg-zinc-900/50 px-3 py-2.5 text-sm text-zinc-900 placeholder-zinc-400 shadow-sm focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 focus:outline-none dark:text-white dark:placeholder-zinc-500 transition-all']) }}>
    {{ $slot }}
</select>
