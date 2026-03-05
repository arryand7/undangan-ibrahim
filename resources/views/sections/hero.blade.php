{{-- Cover Section — Sage Green Theme --}}
<section id="cover" class="cover-section">
    <div class="cover-card">
        <div class="cover-border">
            {{-- Leaf Ornaments --}}
            <img src="{{ asset('images/leaf-1.png') }}" class="cover-leaf-top" alt="">
            <img src="{{ asset('images/leaf-2.png') }}" class="cover-leaf-bottom" alt="">

            {{-- Large Couple Photo with Gradient --}}
            <div class="cover-photo-area fade-in delay-1">
                <div class="cover-photo-frame">
                    <img src="{{ asset('images/cover-hero-bg.jpeg') }}" alt="Ibrahim & Dewi" class="cover-main-photo">
                    <div class="cover-photo-dim"></div>
                    <div class="cover-photo-texture"></div>
                    <div class="cover-photo-gradient"></div>
                </div>
            </div>

            {{-- Names & Date --}}
            <div class="cover-info">
                <p class="cover-label fade-in delay-2">Undangan Pernikahan</p>
                <div class="cover-names fade-in delay-2">
                    <span class="name">Ibrahim</span>
                    <span class="name">&</span>
                    <span class="name">Dewi</span>
                </div>

                <div class="cover-date fade-in delay-3">
                    <div>Kamis</div>
                    <div>26 • Maret • 2026</div>
                </div>

                {{-- Guest --}}
                <div class="cover-guest fade-in delay-4">
                    <div>Kepada:</div>
                    <div class="guest-name recipient-guest-name">Bapak/Ibu/Saudara/i</div>
                </div>

                {{-- Buka Undangan --}}
                <button id="openInvitation" class="btn-open fade-in delay-4">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="btn-icon">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                    <span>Buka Undangan</span>
                </button>
            </div>
        </div>
    </div>
</section>
