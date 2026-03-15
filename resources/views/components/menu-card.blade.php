@props(['item'])

<div class="flex flex-col h-full overflow-hidden group relative bg-white/90 dark:bg-zinc-900/90 border border-zinc-200 dark:border-zinc-800 rounded-3xl hover:border-orange-500/50 transition-all duration-300">
    {{-- Image Container --}}
    <div class="aspect-4/3 relative overflow-hidden m-2 rounded-2xl bg-zinc-100 dark:bg-zinc-800">
        @if($item->image_url)
            <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <svg class="size-12 text-zinc-300 dark:text-zinc-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" /></svg>
            </div>
        @endif
        
        {{-- Floating Category (Light Glass) --}}
        <div class="absolute top-3 left-3">
            @if($item->category)
                <div class="px-3 py-1 backdrop-blur-md bg-black/40 border border-white/20 text-white text-[10px] font-black uppercase tracking-widest rounded-full">
                    {{ $item->category->name }}
                </div>
            @endif
        </div>

        @if($item->is_featured)
            <div class="absolute top-3 right-3">
                <div class="bg-orange-600 text-white p-2 rounded-full shadow-lg">
                    <svg class="size-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.146 21.271c-1.001.608-2.237-.289-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" /></svg>
                </div>
            </div>
        @endif
    </div>

    {{-- Content --}}
    <div class="flex-1 flex flex-col p-5 pt-2">
        <h3 class="text-lg font-black text-zinc-900 dark:text-white leading-tight uppercase tracking-tight group-hover:text-orange-600 transition-colors">
            {{ $item->name }}
        </h3>
        
        @if($item->preparation_time)
            <div class="flex items-center gap-1 mt-1 text-[10px] font-bold text-zinc-400 uppercase tracking-widest">
                <svg class="size-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ $item->preparation_time }} MIN</span>
            </div>
        @endif
        
        <p class="mt-3 text-sm text-zinc-500 dark:text-zinc-400 font-medium line-clamp-2 leading-snug">
            {{ $item->description }}
        </p>

        {{-- Footer --}}
        <div class="mt-auto flex items-center justify-between pt-4">
            <div class="flex flex-col">
                <span class="text-xl font-black text-orange-600 italic tracking-tighter">
                    <span class="text-[10px] font-bold not-italic mr-0.5">IDR</span>{{ number_format($item->price, 0, ',', '.') }}
                </span>
            </div>
            
            <livewire:public.add-to-cart :menuItemId="$item->id" :key="'add-to-cart-'.$item->id" />
        </div>
    </div>
</div>
