@props([
    'label' => null,
    'name' => '',
    'placeholder' => '',
    'error' => null,
])

<div
    x-data="{
        displayValue: '',
        rawValue: @entangle($attributes->wire('model')),
        format(val) {
            if (val === null || val === undefined || val === '') return '';
            // Strip non-digits and format with dots
            return val.toString().replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        },
        updateRaw(val) {
            let numeric = val.replace(/\D/g, '');
            this.rawValue = numeric ? parseInt(numeric) : 0;
            this.displayValue = this.format(this.rawValue);
        }
    }"
    x-init="displayValue = format(rawValue); $watch('rawValue', v => displayValue = format(v))"
>
    @if($label)
        <x-label :for="$name" :value="$label" />
    @endif
    
    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
            <span class="text-zinc-500 text-sm font-bold">Rp</span>
        </div>
        <input
            type="text"
            id="{{ $name }}"
            x-model="displayValue"
            x-on:input="updateRaw($event.target.value)"
            placeholder="{{ $placeholder }}"
            {{ $attributes->whereDoesntStartWith('wire:model')->merge(['class' => 'block w-full rounded-xl border ' . ($errors->has($name) || $error ? 'border-red-300 dark:border-red-900/50' : 'border-zinc-200 dark:border-zinc-800') . ' bg-zinc-50/50 dark:bg-zinc-900/50 pl-10 pr-3 py-2.5 text-sm font-medium text-zinc-900 placeholder-zinc-400 shadow-sm focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 focus:outline-none dark:text-white dark:placeholder-zinc-500 transition-all']) }}
        />
    </div>
    
    @error($name)
        <x-error :messages="$message" />
    @enderror
</div>
