{{-- RSVP Section --}}

{{-- Leaf separator --}}
<div class="leaf-separator flip">
    <img src="{{ asset('images/leaf-3.png') }}" alt="">
</div>

<section id="rsvp" class="section rsvp-section">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Konfirmasi Kehadiran</h2>
        <div class="section-divider" data-aos="fade-up"></div>

        {{-- Big Konfirmasi Kehadiran Button --}}
        <div class="rsvp-btn-area" data-aos="fade-up">
            <button type="button" class="btn-big-action" id="openRsvpModal">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="28" height="28">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="8.5" cy="7" r="4"/>
                    <polyline points="17 11 19 13 23 9"/>
                </svg>
                <span>Konfirmasi Kehadiran</span>
            </button>
        </div>
    </div>
</section>

{{-- RSVP Modal --}}
<div id="rsvpModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Konfirmasi Kehadiran</h3>
            <button class="modal-close" id="closeRsvpModal" aria-label="Close">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="15" y1="9" x2="9" y2="15"/>
                    <line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <form id="rsvpForm" novalidate>
                <div class="form-group">
                    <input type="text" id="rsvp_nama" name="nama" placeholder="Nama Tamu" required maxlength="100" autocomplete="name">
                </div>

                <div class="form-group">
                    <input type="number" id="jumlah_hadir" name="jumlah_hadir" min="1" max="10" value="1" placeholder="Jumlah Tamu">
                </div>

                <div class="modal-actions">
                    <button type="submit" class="btn-modal-action btn-hadir" data-status="hadir">Hadir</button>
                    <button type="submit" class="btn-modal-action btn-tidak" data-status="tidak">Tidak Hadir</button>
                    <button type="button" class="btn-modal-action btn-tutup" id="closeRsvpModal2">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
