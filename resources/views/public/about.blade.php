<x-layouts.public>
    <div class="bg-white dark:bg-black w-full overflow-hidden font-sans">
        {{-- Hero --}}
        <div class="max-w-7xl mx-auto px-6 lg:px-8 pt-32 pb-24 grid grid-cols-1 lg:grid-cols-12 gap-8 items-end border-b-12 border-black dark:border-zinc-800">
            <div class="lg:col-span-8 flex flex-col justify-end">
                <span class="text-orange-600 font-bold uppercase tracking-widest text-sm mb-6 block">01 / Tentang Kami</span>
                <h1 class="text-7xl lg:text-9xl font-black text-black dark:text-white leading-[0.85] tracking-tighter uppercase wrap-break-word">
                    Warisan <br>
                    Rasa <br>
                    Terjaga.
                </h1>
            </div>
            <div class="lg:col-span-4 flex flex-col justify-end pb-4 lg:pl-4">
                <p class="text-xl text-zinc-600 dark:text-zinc-400 leading-snug font-medium mb-8">
                    Sejak 2020, kami telah berkomitmen untuk menghadirkan pengalaman kuliner yang melampaui sekadar rasa. Ini adalah tentang dedikasi pada kualitas dan kejujuran bahan.
                </p>
            </div>
        </div>

        {{-- Story Section --}}
        <div class="py-32 bg-zinc-50 dark:bg-zinc-950">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-start">
                    <div>
                        <h2 class="text-5xl font-black uppercase tracking-tighter mb-12 text-black dark:text-white">Cerita Kami</h2>
                        <div class="space-y-8 text-xl text-zinc-600 dark:text-zinc-400 font-medium leading-relaxed">
                            <p>
                                Bermula dari sebuah dapur kecil dengan impian besar, {{ config('app.name') }} lahir dari keinginan untuk mengembalikan esensi murni dari masakan tradisional ke dalam konteks modern yang dinamis.
                            </p>
                            <p>
                                Kami percaya bahwa setiap bahan memiliki cerita. Tugas kami adalah membiarkan cerita itu bersinar tanpa gangguan. Dengan membuang segala yang berlebihan, kami menemukan keindahan dalam kesederhanaan yang presisi.
                            </p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="aspect-square bg-zinc-200 dark:bg-zinc-900 flex items-center justify-center">
                            <span class="text-4xl font-black text-zinc-300 dark:text-zinc-800">IMG</span>
                        </div>
                        <div class="aspect-square bg-orange-600 flex items-center justify-center">
                            <span class="text-4xl font-black text-white/20">EST. 2020</span>
                        </div>
                        <div class="aspect-square bg-black dark:bg-zinc-800 flex items-center justify-center">
                            <span class="text-4xl font-black text-white/20">PURE</span>
                        </div>
                        <div class="aspect-square bg-zinc-200 dark:bg-zinc-900 flex items-center justify-center">
                            <span class="text-4xl font-black text-zinc-300 dark:text-zinc-800">TASTE</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Values Section --}}
        <div class="py-32 bg-black text-white">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="mb-24">
                    <span class="text-orange-600 font-bold uppercase tracking-widest text-sm mb-6 block">02 / Nilai Utama</span>
                    <h2 class="text-6xl lg:text-7xl font-black uppercase tracking-tighter leading-none">Apa yang Kami <br> Perjuangkan.</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <div class="border-t-2 border-zinc-800 pt-8">
                        <span class="text-orange-600 font-black text-3xl mb-6 block">01</span>
                        <h3 class="text-2xl font-black uppercase tracking-widest mb-4">Integritas Bahan</h3>
                        <p class="text-zinc-400 text-lg leading-relaxed font-medium">Hanya menggunakan bahan musiman terbaik dari sumber yang berkelanjutan dan etis.</p>
                    </div>
                    <div class="border-t-2 border-zinc-800 pt-8">
                        <span class="text-orange-600 font-black text-3xl mb-6 block">02</span>
                        <h3 class="text-2xl font-black uppercase tracking-widest mb-4">Metode Presisi</h3>
                        <h3 class="text-2xl font-black uppercase tracking-widest mb-4"></h3>
                        <p class="text-zinc-400 text-lg leading-relaxed font-medium">Setiap hidangan adalah hasil dari teknik yang diasah selama bertahun-tahun dengan ketelitian tinggi.</p>
                    </div>
                    <div class="border-t-2 border-zinc-800 pt-8">
                        <span class="text-orange-600 font-black text-3xl mb-6 block">03</span>
                        <h3 class="text-2xl font-black uppercase tracking-widest mb-4">Kejujuran Rasa</h3>
                        <p class="text-zinc-400 text-lg leading-relaxed font-medium">Tidak ada rasa buatan, tidak ada jalan pintas. Hanya keaslian yang kami sajikan di meja Anda.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="py-32 bg-white dark:bg-black">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
                <h2 class="text-5xl lg:text-7xl font-black uppercase tracking-tighter mb-12 text-black dark:text-white">Siap Untuk <br> Mencoba?</h2>
                <a href="{{ route('menu.index') }}" class="inline-block bg-orange-600 hover:bg-black dark:hover:bg-white dark:hover:text-black text-white px-12 py-6 text-xl font-black uppercase tracking-widest transition-colors duration-300" wire:navigate>
                    Lihat Menu &rarr;
                </a>
            </div>
        </div>
    </div>
</x-layouts.public>
