<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Undangan Pernikahan Ibrahim & Dewi — 26 Maret 2026">
    <meta name="theme-color" content="#FCFFF8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Wedding of Dewi & Ibrahim</title>

    {{-- Google Fonts: Montserrat + Dancing Script --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- AOS - Animate on Scroll --}}
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    {{-- Main CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="preloading">
    {{-- Preloader --}}
    <div id="preloader" class="preloader" aria-hidden="true">
        <div class="preloader-inner">
            <span class="preloader-title">Dewi & Ibrahim</span>
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

    {{-- Bottom Navigation --}}
    <nav id="bottomNav" class="bottom-nav" style="display: none;">
        <div class="nav-inner">
            <a href="#couple" class="nav-link" title="Mempelai">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
            </a>
            <a href="#events" class="nav-link" title="Acara">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </a>
            <a href="#gift" class="nav-link" title="Kado">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 12 20 22 4 22 4 12"/>
                    <rect x="2" y="7" width="20" height="5"/>
                    <line x1="12" y1="22" x2="12" y2="7"/>
                    <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/>
                    <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/>
                </svg>
            </a>
            <a href="#rsvp" class="nav-link" title="RSVP">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </a>
        </div>
    </nav>

    {{-- AOS JS --}}
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    
    {{-- Main App JS --}}
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
