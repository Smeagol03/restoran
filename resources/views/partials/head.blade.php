<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="theme-color" content="#ea580c">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

{{-- Primary Meta Tags --}}
<title>{{ filled($title ?? null) ? $title.' - '.config('app.name', 'Laravel') : config('app.name', 'Laravel') }}</title>
<meta name="title" content="{{ config('app.name', 'Laravel') }} - Pengalaman Kuliner Modern">
<meta name="description" content="Nikmati hidangan otentik dengan sentuhan modern. Pesan sekarang untuk pengalaman kuliner tak terlupakan.">

{{-- Open Graph / Facebook --}}
<meta property="og:type" content="website">
<meta property="og:url" content="https://pink-hamster-250175.hostingersite.com/">
<meta property="og:title" content="{{ config('app.name', 'Laravel') }} - Rasa Otentik Modern">
<meta property="og:description" content="Dapur kami adalah laboratorium memori. Nikmati masakan terbaik dengan bahan segar pilihan.">
<meta property="og:image" content="https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?auto=format&fit=crop&q=80&w=1200">

{{-- Twitter --}}
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="https://pink-hamster-250175.hostingersite.com/">
<meta property="twitter:title" content="{{ config('app.name', 'Laravel') }} - Rasa Otentik Modern">
<meta property="twitter:description" content="Nikmati hidangan otentik dengan sentuhan modern. Pesan sekarang untuk pengalaman kuliner tak terlupakan.">
<meta property="twitter:image" content="https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?auto=format&fit=crop&q=80&w=1200">

<link rel="manifest" href="/manifest.json">
<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])

{{-- Dark mode script --}}
<script>
    (function () {
        const updateTheme = () => {
            if (localStorage.getItem('appearance') === 'dark' || (!localStorage.getItem('appearance') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        };
        updateTheme();
        document.addEventListener('livewire:navigated', updateTheme);
    })();
</script>
