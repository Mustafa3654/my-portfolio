@php $me = config('portfolio.identity'); @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', $me['name'] . ' — ' . $me['role'])</title>
    <meta name="description" content="@yield('description', 'Full-stack systems and web engineer. Multi-vendor delivery dispatch, bilingual storefronts, QR menus and the admin panels that keep them honest — shipped and running in the Lebanese market.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700;12..96,800&family=IBM+Plex+Mono:wght@400;500;600&family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/portfolio.js'])

    {{-- Nothing may stay stuck at opacity 0 when JavaScript is unavailable. --}}
    <noscript><style>.reveal,.board-row{opacity:1!important;transform:none!important}</style></noscript>
</head>
<body id="top" class="font-sans antialiased">

    @include('partials.nav')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

</body>
</html>
