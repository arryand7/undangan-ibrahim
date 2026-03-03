<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Undangan Pernikahan Ibrahim & Dewi — 26 Maret 2026">
    <meta name="theme-color" content="#0a0a1a">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Wedding of Ibrahim & Dewi</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    {{-- Main CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="preloading">
    {{-- Preloader (1.5s logo fade) --}}
    <div id="preloader" class="preloader" aria-hidden="true">
        <div class="preloader-inner">
            <span class="preloader-title">Ibrahim & Dewi</span>
            <span class="preloader-sub">Wedding Invitation</span>
        </div>
    </div>

    {{-- Background Music --}}
    <audio id="bgMusic" loop preload="none">
        <source src="{{ asset('audio/backsound.mp3') }}" type="audio/mpeg">
    </audio>

    {{-- Music Toggle Button --}}
    <button id="musicToggle" class="music-toggle" aria-label="Toggle Music" title="Toggle Music">
        <svg id="musicIconOn" class="music-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 18V5l12-2v13"/>
            <circle cx="6" cy="18" r="3"/>
            <circle cx="18" cy="16" r="3"/>
        </svg>
        <svg id="musicIconOff" class="music-icon hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 18V5l12-2v13"/>
            <circle cx="6" cy="18" r="3"/>
            <circle cx="18" cy="16" r="3"/>
            <line x1="1" y1="1" x2="23" y2="23" stroke-width="2.5"/>
        </svg>
    </button>

    {{-- Toast notification --}}
    <div id="toast" class="toast"></div>

    @yield('content')

    {{-- Main App JS --}}
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
