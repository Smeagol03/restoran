@props([
    'name' => '',
    'label' => null,
    'checked' => false,
])

<label class="flex items-center gap-2 cursor-pointer">
    <input
        type="checkbox"
        name="{{ $name }}"
        @checked(old($name, $checked))
        {{ $attributes->merge(['class' => 'rounded border-zinc-300 text-zinc-900 shadow-sm focus:ring-zinc-500/20 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white dark:focus:ring-zinc-400/20']) }}
    />
    @if($label)
        <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
    @endif
</label>
