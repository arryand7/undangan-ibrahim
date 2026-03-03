{{-- RSVP Section --}}
<section id="rsvp" class="section rsvp-section">
    <div class="container">
        <h2 class="section-title animate-on-scroll">RSVP</h2>
        <div class="section-divider animate-on-scroll"></div>
        <p class="section-desc animate-on-scroll">Konfirmasi kehadiran Anda</p>

        <form id="rsvpForm" class="rsvp-form animate-on-scroll" novalidate>
            <div class="form-group">
                <label for="nama">Nama Lengkap <span class="required">*</span></label>
                <input type="text" id="nama" name="nama" placeholder="Masukkan nama Anda" required maxlength="100" autocomplete="name">
            </div>

            <div class="form-group">
                <label for="jumlah_hadir">Jumlah yang Hadir</label>
                <input type="number" id="jumlah_hadir" name="jumlah_hadir" min="1" max="10" value="1">
            </div>

            <div class="form-group">
                <label>Konfirmasi Kehadiran <span class="required">*</span></label>
                <div class="radio-group">
                    <label class="radio-label">
                        <input type="radio" name="status_hadir" value="hadir" checked>
                        <span class="radio-custom"></span>
                        <span>Hadir</span>
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="status_hadir" value="tidak">
                        <span class="radio-custom"></span>
                        <span>Tidak Hadir</span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="pesan">Ucapan & Doa</label>
                <textarea id="pesan" name="pesan" placeholder="Tuliskan ucapan dan doa untuk kedua mempelai..." rows="3" maxlength="500"></textarea>
            </div>

            <button type="submit" id="submitRsvp" class="btn-submit">
                <span class="btn-text">Kirim RSVP</span>
                <span class="btn-loader hidden">
                    <svg class="spinner" viewBox="0 0 24 24" width="20" height="20">
                        <circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="3" stroke-dasharray="30 70" stroke-linecap="round"/>
                    </svg>
                </span>
            </button>
        </form>
    </div>
</section>
