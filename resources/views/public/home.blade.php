<x-layouts.public>
    <div class="bg-white dark:bg-black w-full overflow-hidden font-sans">
        {{-- Hero --}}
        <div class="max-w-7xl mx-auto px-6 lg:px-8 pt-32 pb-24 grid grid-cols-1 lg:grid-cols-12 gap-8 items-end">
            <div class="lg:col-span-8 flex flex-col justify-end">
                <span class="text-orange-600 font-bold uppercase tracking-widest text-sm mb-6 block">01 / Experience</span>
                <h1 class="text-7xl lg:text-9xl font-black text-black dark:text-white leading-[0.85] tracking-tighter uppercase wrap-break-word">
                    Rasa <br>
                    Otentik <br>
                    Modern.
                </h1>
            </div>
            <div class="lg:col-span-4 flex flex-col justify-end pb-4 lg:pl-4">
                <p class="text-xl text-zinc-600 dark:text-zinc-400 leading-snug font-medium mb-8">
                    Kami menyajikan masakan dengan bahan segar setiap hari. Menghadirkan tradisi dalam setiap gigitan dengan presisi tinggi.
                </p>
                <div class="flex flex-wrap items-center gap-6">
                    <a href="{{ route('menu.index') }}" class="inline-block bg-orange-600 hover:bg-black text-white px-8 py-4 text-lg font-bold uppercase tracking-widest transition-colors duration-300" wire:navigate>
                        Pesan
                    </a>
                    <a href="#about" class="text-lg font-bold uppercase tracking-widest text-black dark:text-white hover:text-orange-600 transition-colors">Eksplorasi &darr;</a>
                </div>
            </div>
        </div>

        {{-- Hero Image Block --}}
        <div class="max-w-7xl mx-auto px-6 lg:px-8 pb-32">
            <div class="w-full h-[60vh] bg-zinc-100 dark:bg-zinc-900 flex items-center justify-center relative overflow-hidden group">
                <svg class="size-24 text-zinc-300 dark:text-zinc-800 transition-transform duration-700 group-hover:scale-110" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" /></svg>
                <div class="absolute bottom-0 left-0 w-full sm:w-auto sm:bottom-12 sm:left-12 flex flex-col sm:flex-row items-stretch sm:items-center bg-white dark:bg-zinc-950 sm:bg-transparent">
                    <div class="w-full sm:w-20 h-16 sm:h-20 bg-orange-600 flex items-center justify-center text-white font-black text-2xl tracking-tighter shrink-0">
                        S / M
                    </div>
                    <div class="text-black dark:text-white p-4 sm:p-0 sm:pl-6 sm:bg-transparent bg-white dark:bg-zinc-900">
                        <p class="font-black uppercase text-2xl tracking-tight leading-none mb-1">Special of the Month</p>
                        <p class="font-bold text-zinc-500 uppercase tracking-widest text-xs">Grilled Ribs with Honey Sauce</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Featured Section --}}
        <div class="bg-zinc-50 dark:bg-zinc-950 pt-32 pb-48 border-t-12 border-black dark:border-zinc-800">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start mb-24">
                    <div class="lg:col-span-5">
                        <span class="text-orange-600 font-bold uppercase tracking-widest text-sm mb-4 block">02 / Klasik</span>
                        <h2 class="text-6xl lg:text-7xl font-black text-black dark:text-white leading-[0.9] tracking-tighter uppercase wrap-break-word">
                            Menu<br>Unggulan.
                        </h2>
                    </div>
                    <div class="lg:col-span-7 flex lg:justify-end lg:items-end h-full">
                        <p class="text-2xl lg:text-3xl text-zinc-600 dark:text-zinc-400 leading-tight lg:max-w-xl font-medium lg:text-right">
                            Sebuah kurasi mahakarya kuliner kami. Hidangan favorit yang secara konsisten memberikan kepuasan sempurna.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-12 gap-y-16 border-t-[3px] border-black dark:border-zinc-800 pt-12 mb-24">
                    @foreach ($featuredItems as $i => $item)
                        <div class="flex flex-col group cursor-pointer border-t-[3px] border-black dark:border-zinc-800 pt-4">
                            <div class="flex justify-between items-end pb-4 mb-6">
                                <span class="font-black text-3xl leading-none text-zinc-400 dark:text-zinc-600">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <span class="text-orange-600 font-black text-xl tracking-tight">IDR {{ number_format($item->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="aspect-4/5 bg-zinc-200 dark:bg-zinc-900 mb-6 flex items-center justify-center relative overflow-hidden transition-transform duration-700">
                                <svg class="size-16 text-zinc-400 dark:text-zinc-700 transition-transform duration-700 group-hover:scale-110" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" /></svg>
                                <div class="absolute inset-0 bg-transparent group-hover:bg-orange-600/10 transition-colors duration-500"></div>
                            </div>
                            <h3 class="text-3xl font-black uppercase tracking-tight mb-3 text-black dark:text-white group-hover:text-orange-600 transition-colors">{{ $item->name }}</h3>
                            <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed font-medium">{{ $item->description }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="border-t-[3px] border-zinc-200 dark:border-zinc-800 pt-12 flex justify-end">
                    <a href="{{ route('menu.index') }}" class="inline-block border-4 border-black dark:border-zinc-200 text-black dark:text-white hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black px-12 py-6 text-xl font-black uppercase tracking-widest transition-all duration-300 w-full md:w-auto text-center" wire:navigate>
                        Seluruh Menu &rarr;
                    </a>
                </div>
            </div>
        </div>

        {{-- About Section --}}
        <div id="about" class="py-32 bg-black text-white relative">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24">
                    <div class="flex flex-col">
                        <span class="text-orange-600 font-bold uppercase tracking-widest text-sm mb-8 block">03 / Filosofi</span>
                        <h2 class="text-7xl lg:text-8xl font-black leading-[0.9] tracking-tighter uppercase mb-16 wrap-break-word">
                            Akar <br>
                            Sistem.
                        </h2>
                        
                        <div class="space-y-12 mt-auto">
                            <div class="border-t-2 border-zinc-800 pt-8">
                                <h3 class="text-2xl font-black uppercase tracking-widest mb-4 flex items-center">
                                    <span class="w-8 h-8 bg-orange-600 mr-6 block shrink-0"></span>
                                    Bahan Segar
                                </h3>
                                <p class="text-zinc-400 text-xl leading-relaxed font-medium max-w-lg">Secara ketat diseleksi dari petani lokal terbaik. Minimalis dalam pengolahan, maksimal dalam rasa.</p>
                            </div>
                            <div class="border-t-2 border-zinc-800 pt-8">
                                <h3 class="text-2xl font-black uppercase tracking-widest mb-4 flex items-center">
                                    <span class="w-8 h-8 bg-white mr-6 block shrink-0"></span>
                                    Presisi Dapur
                                </h3>
                                <p class="text-zinc-400 text-xl leading-relaxed font-medium max-w-lg">Metodologi yang sistematis. Setiap teknik diterapkan dengan tingkat akurasi tinggi oleh koki ahli.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="relative min-h-[500px] lg:mt-32">
                        <!-- Abstract Grid Graphic -->
                        <div class="absolute inset-0 bg-zinc-900 grid grid-cols-4 grid-rows-5 gap-1 p-1 shadow-2xl">
                            @for ($i = 0; $i < 20; $i++)
                                <div class="bg-zinc-800 transition-colors duration-1000 hover:bg-orange-600 {{ in_array($i, [0, 5, 10, 15, 3, 6, 9, 14]) ? 'bg-zinc-700' : '' }}"></div>
                            @endfor
                        </div>
                        
                        <!-- Content Card -->
                        <div class="relative z-10 bg-white text-black p-10 sm:p-14 max-w-sm ml-auto mt-24 sm:-ml-8 sm:mr-auto shadow-2xl border-l-12 border-orange-600">
                            <span class="text-zinc-500 font-bold uppercase tracking-widest text-xs mb-4 block">Est. 2020</span>
                            <h3 class="font-black text-5xl uppercase leading-[0.85] tracking-tighter mb-8">
                                Esensi<br>Rasa<br>Murni.
                            </h3>
                            <p class="font-bold text-zinc-700 text-lg leading-snug">
                                Kami membuang semua yang tidak perlu, menyisakan murni hierarki rasa. Bentuk selalu mengikuti fungsionalitas rasa.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
