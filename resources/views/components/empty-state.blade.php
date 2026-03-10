@props([
    'title' => 'Data Kosong',
    'description' => 'Maaf, sepertinya belum ada data yang bisa ditampilkan di sini.',
    'icon' => null,
    'action' => null,
    'actionLabel' => null,
    'actionUrl' => '#',
])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center py-24 px-6 text-center bg-zinc-50 dark:bg-zinc-950 border-2 border-dashed border-zinc-200 dark:border-zinc-800 rounded-3xl']) }}>
    <div class="mb-10 relative">
        @if ($icon)
            <div class="text-zinc-300 dark:text-zinc-700">
                {{ $icon }}
            </div>
        @else
            <div class="p-8 bg-white dark:bg-zinc-900 rounded-full border border-zinc-100 dark:border-zinc-800 shadow-xl relative z-10">
                <svg class="size-16 text-zinc-300 dark:text-zinc-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.32a2.25 2.25 0 0 0-2.159-1.57H6.92a2.25 2.25 0 0 0-2.159 1.57L2.35 12.677a2.25 2.25 0 0 0-.1.661Z" />
                </svg>
            </div>
            <div class="absolute -inset-4 bg-orange-600/5 dark:bg-orange-600/10 rounded-full blur-2xl"></div>
        @endif
    </div>

    <h3 class="text-4xl font-black uppercase tracking-tighter text-black dark:text-white mb-4">
        {{ $title }}
    </h3>

    <p class="text-xl text-zinc-500 dark:text-zinc-400 max-w-lg mx-auto mb-12 font-medium leading-tight italic">
        "{{ $description }}"
    </p>

    @if ($action)
        {{ $action }}
    @elseif ($actionLabel)
        <a href="{{ $actionUrl }}" class="inline-block bg-orange-600 hover:bg-black text-white px-12 py-5 text-xl font-black uppercase tracking-widest transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-orange-600/20" wire:navigate>
            {{ $actionLabel }}
        </a>
    @endif
</div>
