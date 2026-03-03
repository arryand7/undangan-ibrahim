{{-- Couple Profile Section --}}
<section id="couple" class="section couple-section">
    <div class="container">
        <h2 class="section-title animate-on-scroll">Mempelai</h2>
        <div class="section-divider animate-on-scroll"></div>

        <div class="couple-cards">
            {{-- Groom --}}
            <div class="couple-card glass-card animate-on-scroll">
                <div class="couple-photo-wrapper">
                    <img src="{{ asset('images/ibrahim.webp') }}" alt="Ibrahim Hasan Mauludi" loading="lazy">
                </div>
                <h3 class="couple-name">Ibrahim Hasan Mauludi</h3>
                <p class="couple-info">Putra dari</p>
                <p class="couple-parents">Bapak ... & Ibu ...</p>
            </div>

            {{-- Ampersand --}}
            <div class="couple-separator animate-on-scroll">
                <span class="couple-amp">&</span>
            </div>

            {{-- Bride --}}
            <div class="couple-card glass-card animate-on-scroll">
                <div class="couple-photo-wrapper">
                    <img src="{{ asset('images/dewi.webp') }}" alt="Dewi" loading="lazy">
                </div>
                <h3 class="couple-name">Dewi</h3>
                <p class="couple-info">Putri dari</p>
                <p class="couple-parents">Bapak ... & Ibu ...</p>
            </div>
        </div>
    </div>
</section>
