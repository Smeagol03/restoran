@props(['value', 'for' => null])

<label {{ $attributes->merge(['for' => $for, 'class' => 'block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2']) }}>
    {{ $value ?? $slot }}
</label>
