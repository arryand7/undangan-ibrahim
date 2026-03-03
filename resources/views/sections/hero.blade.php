{{-- Hero Section — Three.js 3D Particle Scene --}}
<section id="hero" class="hero-section">
    {{-- Three.js Canvas --}}
    <canvas id="heroCanvas"></canvas>

    {{-- CSS Overlay Text (lighter than 3D text geometry) --}}
    <div class="hero-overlay">
        <p class="hero-bismillah fade-in">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</p>
        <p class="hero-subtitle fade-in delay-1">The Wedding of</p>
        <h1 class="hero-names fade-in delay-2">Ibrahim <span class="amp">&</span> Dewi</h1>
        <p class="hero-date fade-in delay-3">26 . 03 . 2026</p>
        <button id="openInvitation" class="btn-open fade-in delay-4">
            <span>Buka Undangan</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="btn-icon">
                <path d="M6 9l6 6 6-6"/>
            </svg>
        </button>
    </div>
</section>

{{-- Three.js loaded from CDN --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js" defer></script>
<script src="{{ asset('js/three-hero.js') }}" defer></script>
