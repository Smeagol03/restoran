@props(['item'])

<x-card class="flex flex-col h-full overflow-hidden group hover:shadow-xl hover:shadow-orange-500/5 transition-all duration-500 border-zinc-100 dark:border-zinc-800/50">
    {{-- Image Container --}}
    <div class="aspect-[4/3] bg-zinc-100 dark:bg-zinc-900 relative overflow-hidden">
        @if($item->image_url)
            <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
        @else
            <div class="w-full h-full flex items-center justify-center bg-zinc-50 dark:bg-zinc-900/50">
                <svg class="size-16 text-zinc-200 dark:text-zinc-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" /></svg>
            </div>
        @endif
        
        {{-- Badges Over Image --}}
        <div class="absolute top-3 left-3 flex flex-col gap-2">
            @if($item->category)
                <x-badge color="orange" variant="solid" size="sm" class="backdrop-blur-md bg-orange-600/90 shadow-sm uppercase tracking-wider font-bold">
                    {{ $item->category->name }}
                </x-badge>
            @endif
        </div>

        @if($item->is_featured)
            <div class="absolute top-3 right-3">
                <div class="bg-yellow-400 text-yellow-950 p-1.5 rounded-full shadow-lg animate-pulse">
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.146 21.271c-1.001.608-2.237-.289-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" /></svg>
                </div>
            </div>
        @endif

        {{-- Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
    </div>

    {{-- Content --}}
    <div class="flex-1 flex flex-col p-5">
        <div class="mb-4">
            <h3 class="text-xl font-black text-zinc-900 dark:text-white leading-tight uppercase tracking-tight group-hover:text-orange-600 transition-colors duration-300">
                {{ $item->name }}
            </h3>
        </div>
        
        {{-- Metadata --}}
        <div class="flex items-center gap-4 mb-6 text-xs font-bold uppercase tracking-widest text-zinc-400 dark:text-zinc-600">
            @if($item->preparation_time)
                <div class="flex items-center gap-1.5">
                    <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ $item->preparation_time }} MIN</span>
                </div>
            @endif
        </div>

        {{-- Footer --}}
        <div class="mt-auto flex items-center justify-between pt-5 border-t border-zinc-100 dark:border-zinc-800/50">
            <span class="text-2xl font-black text-orange-600 tracking-tighter italic">
                <span class="text-xs font-bold not-italic mr-0.5">IDR</span>{{ number_format($item->price, 0, ',', '.') }}
            </span>
            
            <div class="relative group/btn">
                <div class="absolute -inset-2 bg-orange-600/20 rounded-full blur-xl opacity-0 group-hover/btn:opacity-100 transition-opacity duration-500"></div>
                <livewire:public.add-to-cart :menuItemId="$item->id" :key="'add-to-cart-'.$item->id" />
            </div>
        </div>
    </div>
</x-card>
