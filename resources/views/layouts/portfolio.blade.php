<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', $profile->name . ' — ' . $profile->role)</title>
    <meta name="description" content="@yield('description', 'Full-stack systems and web engineer. Multi-vendor delivery dispatch, bilingual storefronts, QR menus and the admin panels that keep them honest — shipped and running in the Lebanese market.')">

    {{-- Set the theme before the stylesheet loads, otherwise a light-mode
         visitor gets a dark flash on every navigation. Inline and synchronous
         on purpose: a deferred or bundled script paints first. --}}
    <script>
        (() => {
            try {
                const stored = localStorage.getItem('theme');
                const prefersLight = window.matchMedia('(prefers-color-scheme: light)').matches;
                document.documentElement.dataset.theme = stored || (prefersLight ? 'light' : 'dark');
            } catch (e) {
                document.documentElement.dataset.theme = 'dark';
            }
        })();
    </script>

    {{-- Fonts are self-hosted via the Bunny helper in vite.config.js, so the page
         makes no third-party request at runtime. Vite::fonts() emits the preload
         links and the @font-face rules; without it the display face silently
         falls back to the system stack. --}}
    {{ Vite::fonts() }}

    @vite(['resources/css/app.css', 'resources/js/portfolio.js'])

    {{-- Nothing may stay stuck at opacity 0 when JavaScript is unavailable. --}}
    <noscript><style>.reveal,.board-row{opacity:1!important;transform:none!important}
.line-mask>span{transform:none!important}</style></noscript>
</head>
<body id="top" class="font-sans antialiased">

    @include('partials.nav')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

</body>
</html>
