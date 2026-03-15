<x-layouts.public>
    <div class="bg-white dark:bg-black w-full overflow-hidden font-sans selection:bg-orange-500 selection:text-white">
        {{-- Hero Section --}}
        <div class="relative min-h-[85vh] lg:min-h-screen flex items-center justify-center overflow-hidden">
            {{-- Background Layers --}}
            <div class="absolute inset-0 z-0">
                {{-- Fixed Background Parallax Optimized --}}
                <div class="absolute inset-0 bg-cover bg-center bg-no-repeat bg-fixed" style="background-image: url('https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?auto=format&fit=crop&q=75&w=1280');"></div>
                {{-- Simplified Overlays --}}
                <div class="absolute inset-0 bg-black/50 dark:bg-black/70"></div>
                <div class="absolute inset-0 bg-linear-to-b from-black/60 via-transparent to-black/90"></div>
            </div>

            <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 w-full grid grid-cols-1 lg:grid-cols-12 gap-12 items-center py-24 pt-32 lg:pt-24">
                <div class="lg:col-span-8 space-y-10 text-left">
                    <div class="flex items-center gap-4">
                        <span class="w-12 h-px bg-orange-600"></span>
                        <span class="text-orange-500 font-black uppercase tracking-[0.4em] text-xs">Est. 2026 / Modern Dining</span>
                    </div>
                    
                    <h1 class="text-7xl lg:text-[10rem] font-black text-white leading-[0.8] tracking-tighter uppercase">
                        Seni<br>
                        <span class="text-orange-600 italic font-serif lowercase tracking-normal">Rasa</span><br>
                        Tanpa Batas.
                    </h1>

                    <p class="text-xl lg:text-2xl text-zinc-300 max-w-2xl font-medium leading-relaxed">
                        Menghadirkan harmoni antara tradisi lokal dan teknik modern dalam setiap piring yang kami sajikan.
                    </p>

                    <div class="flex flex-wrap items-center gap-8 pt-4">
                        <a href="{{ route('menu.index') }}" class="group relative inline-flex items-center gap-4 bg-orange-600 hover:bg-white text-white hover:text-black px-12 py-6 text-xl font-black uppercase tracking-widest transition-all duration-500 shadow-2xl overflow-hidden" wire:navigate>
                            <span class="relative z-10">Lihat Menu</span>
                            <svg class="size-6 transition-transform group-hover:translate-x-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                        <a href="#featured" class="text-lg font-black uppercase tracking-widest text-white/80 hover:text-orange-500 transition-colors border-b-2 border-white/20 hover:border-orange-500 pb-1">Eksplorasi &darr;</a>
                    </div>
                </div>

                <div class="lg:col-span-4 self-end pb-12 hidden lg:block">
                    <div class="bg-white/5 backdrop-blur-3xl border-l-4 border-orange-600 p-10 shadow-2xl">
                        <p class="text-2xl text-zinc-200 leading-tight font-bold mb-8 italic italic-custom">
                            "Dapur kami adalah laboratorium di mana bahan-bahan sederhana berubah menjadi memori tak terlupakan."
                        </p>
                        <div class="flex items-center gap-6">
                            <div class="w-16 h-px bg-orange-600"></div>
                            <div>
                                <span class="block text-sm font-black uppercase tracking-widest text-orange-500">Executive Chef</span>
                                <span class="text-zinc-400 text-xs font-bold uppercase tracking-widest mt-1 block">Adrian Pratama</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Featured Section --}}
        <section id="featured" class="bg-zinc-50 dark:bg-zinc-950 pt-32 pb-48 border-t-0 relative">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start mb-24">
                    <div class="lg:col-span-6">
                        <span class="text-orange-600 font-bold uppercase tracking-widest text-sm mb-4 block">01 / Signature</span>
                        <h2 class="text-6xl lg:text-8xl font-black text-black dark:text-white leading-[0.85] tracking-tighter uppercase">
                            Karya<br>Terbaik.
                        </h2>
                    </div>
                    <div class="lg:col-span-6 flex lg:justify-end lg:items-end h-full">
                        <p class="text-2xl text-zinc-600 dark:text-zinc-400 leading-snug lg:max-w-md font-medium lg:text-right">
                            Pilihan menu kurasi yang mencerminkan identitas dapur kami. Eksklusif, terbatas, dan penuh karakter.
                        </p>
                    </div>
                </div>

                @if ($featuredItems->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 pt-12 mb-24">
                        @foreach ($featuredItems as $i => $item)
                            <div class="group cursor-pointer border-t-[3px] border-black dark:border-zinc-800 pt-8">
                                <div class="flex justify-between items-end pb-6 mb-8">
                                    <span class="font-black text-4xl leading-none text-zinc-300 dark:text-zinc-800">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="text-orange-600 font-black text-2xl tracking-tight">IDR {{ number_format($item->price, 0, ',', '.') }}</span>
                                </div>
                                <div class="aspect-16/10 bg-zinc-200 dark:bg-zinc-900 mb-8 overflow-hidden relative shadow-lg group-hover:shadow-2xl transition-shadow duration-500">
                                    @if($item->image_url)
                                        <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="absolute inset-0 w-full h-full object-cover transition-all duration-700 group-hover:scale-105">
                                    @else
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <svg class="size-16 text-zinc-400 dark:text-zinc-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" /></svg>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-black/10 group-hover:bg-orange-600/10 transition-colors duration-500"></div>
                                    <div class="absolute bottom-4 left-4">
                                        <span class="bg-orange-600 text-white text-[10px] font-black uppercase tracking-[0.2em] px-3 py-1">Featured</span>
                                    </div>
                                </div>
                                <h3 class="text-3xl font-black uppercase tracking-tight mb-4 text-black dark:text-white group-hover:text-orange-600 transition-colors">{{ $item->name }}</h3>
                                <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed font-medium line-clamp-2">{{ $item->description }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="mb-24">
                        <x-empty-state
                            title="Belum Ada Menu Unggulan"
                            description="Kami sedang mengkurasi hidangan terbaik untuk ditampilkan di sini."
                            action-label="Eksplorasi Semua Menu"
                            action-url="{{ route('menu.index') }}"
                        />
                    </div>
                @endif

                <div class="flex justify-center mt-20">
                    <a href="{{ route('menu.index') }}" class="inline-flex items-center gap-6 border-[3px] border-black dark:border-white text-black dark:text-white hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black px-12 py-6 text-xl font-black uppercase tracking-widest transition-all duration-300 group" wire:navigate>
                        Jelajahi Menu Lengkap
                        <svg class="size-6 transition-transform group-hover:translate-x-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>
        </section>

        {{-- Story Section --}}
        <section id="about" class="py-32 bg-black text-white relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">
                    <div class="order-2 lg:order-1">
                        <span class="text-orange-600 font-bold uppercase tracking-widest text-sm mb-8 block">02 / Cerita Kami</span>
                        <h2 class="text-7xl lg:text-[7rem] font-black leading-[0.8] tracking-tighter uppercase mb-12">
                            Akar<br>Kami.
                        </h2>
                        
                        <div class="space-y-10">
                            <p class="text-2xl text-zinc-300 font-medium leading-relaxed italic-custom">
                                Berawal dari sebuah obsesi kecil akan kesempurnaan rasa, kami membangun tempat ini bukan sekadar sebagai restoran, tapi sebagai rumah bagi eksplorasi kuliner.
                            </p>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-12 pt-8 border-t border-zinc-800">
                                <div class="space-y-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-8 h-8 bg-orange-600 flex items-center justify-center font-black text-xs">01</div>
                                        <h3 class="text-xl font-black uppercase tracking-widest">Integritas</h3>
                                    </div>
                                    <p class="text-zinc-500 font-medium">Bahan-bahan yang kami gunakan berasal dari sumber yang beretika dan terjamin kesegarannya.</p>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-8 h-8 bg-white text-black flex items-center justify-center font-black text-xs">02</div>
                                        <h3 class="text-xl font-black uppercase tracking-widest">Inovasi</h3>
                                    </div>
                                    <p class="text-zinc-500 font-medium">Teknik tradisional yang kami dekonstruksi dan definisikan ulang untuk zaman modern.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="order-1 lg:order-2 relative">
                        <div class="aspect-4/5 bg-zinc-900 shadow-2xl relative overflow-hidden group">
                            <img src="https://images.unsplash.com/photo-1600565193348-f74bd3c7ccdf?auto=format&fit=crop&q=75&w=800" alt="Kitchen Action" class="absolute inset-0 w-full h-full object-cover grayscale transition-all duration-1000 group-hover:grayscale-0 group-hover:scale-105">
                            <div class="absolute inset-0 bg-linear-to-t from-black via-transparent to-transparent opacity-60"></div>
                        </div>
                        
                        {{-- Overlay Card --}}
                        <div class="absolute -bottom-10 -left-10 bg-orange-600 p-12 hidden md:block shadow-2xl">
                            <div class="text-center">
                                <span class="block text-6xl font-black leading-none mb-2">10+</span>
                                <span class="text-xs font-black uppercase tracking-[0.3em]">Tahun Dedikasi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Experience/Vibe Section --}}
        <section class="py-32 bg-zinc-50 dark:bg-zinc-950">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center mb-24">
                    <span class="text-orange-600 font-bold uppercase tracking-widest text-sm mb-4 block">03 / Atmosfer</span>
                    <h2 class="text-6xl lg:text-8xl font-black text-black dark:text-white uppercase tracking-tighter">Vibe Kami.</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 min-h-[400px] md:h-[600px]">
                    <div class="md:col-span-2 h-[300px] md:h-auto relative overflow-hidden group">
                        <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&q=75&w=800" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors"></div>
                    </div>
                    <div class="md:col-span-1 h-[200px] md:h-auto relative overflow-hidden group">
                        <img src="https://images.unsplash.com/photo-1552566626-52f8b828add9?auto=format&fit=crop&q=75&w=400" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors"></div>
                    </div>
                    <div class="md:col-span-1 grid grid-cols-2 md:grid-cols-1 gap-4">
                        <div class="h-[150px] md:h-auto relative overflow-hidden group">
                            <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?auto=format&fit=crop&q=75&w=400" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors"></div>
                        </div>
                        <div class="h-[150px] md:h-auto relative overflow-hidden group">
                            <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?auto=format&fit=crop&q=75&w=400" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- CTA Section --}}
        <section class="relative py-48 bg-orange-600 overflow-hidden">
            <div class="max-w-5xl mx-auto px-6 lg:px-8 relative z-10 text-center">
                <h2 class="text-7xl lg:text-[9rem] font-black text-white leading-[0.85] tracking-tighter uppercase mb-16">
                    Mari<br>Rayakan.
                </h2>
                <div class="flex flex-col md:flex-row items-center justify-center gap-8">
                    <a href="{{ route('menu.index') }}" class="bg-black text-white px-16 py-8 text-2xl font-black uppercase tracking-widest hover:bg-white hover:text-black transition-all duration-500 shadow-2xl w-full md:w-auto text-center" wire:navigate>
                        Pesan Meja
                    </a>
                    <a href="https://wa.me/{{ config('app.admin_phone') }}" target="_blank" class="text-white text-2xl font-black uppercase tracking-widest border-b-4 border-white pb-2 hover:bg-white hover:text-orange-600 px-4 transition-all">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-layouts.public>
