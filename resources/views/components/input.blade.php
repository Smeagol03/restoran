@props([
    'label' => null,
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'value' => null,
    'error' => null,
])

<div>
    @if($label)
        <x-label :for="$name" :value="$label" />
    @endif
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'block w-full rounded-xl border ' . ($errors->has($name) || $error ? 'border-red-300 dark:border-red-900/50' : 'border-zinc-200 dark:border-zinc-800') . ' bg-zinc-50/50 dark:bg-zinc-900/50 px-3 py-2.5 text-sm text-zinc-900 placeholder-zinc-400 shadow-sm focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 focus:outline-none dark:text-white dark:placeholder-zinc-500 transition-all']) }}
    />
    @error($name)
        <x-error :messages="$message" />
    @enderror
</div>
