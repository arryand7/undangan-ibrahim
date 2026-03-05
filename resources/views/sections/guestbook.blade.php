{{-- Ucapan & Doa Section --}}

{{-- Leaf separator --}}
<div class="leaf-separator">
    <img src="{{ asset('images/leaf-3.png') }}" alt="">
</div>

<section id="guestbook" class="section guestbook-section">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Ucapan & Doa</h2>
        <div class="section-divider" data-aos="fade-up"></div>

        {{-- Simple form: nama + message --}}
        <form id="rsvpForm2" class="ucapan-form" data-aos="fade-up" novalidate>
            <div class="form-group">
                <input type="text" id="ucapanNama" name="nama" placeholder="Nama" required maxlength="100" autocomplete="name">
            </div>
            <div class="form-group">
                <textarea id="ucapanPesan" name="pesan" placeholder="Tulis ucapan & doa" rows="4" maxlength="500"></textarea>
            </div>
            <button type="submit" id="submitUcapan" class="btn-submit-ucapan">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
                <span class="btn-text">Kirim Ucapan</span>
                <span class="btn-loader hidden">
                    <svg class="spinner" viewBox="0 0 24 24" width="20" height="20">
                        <circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="3" stroke-dasharray="30 70" stroke-linecap="round"/>
                    </svg>
                </span>
            </button>
        </form>

        {{-- Guest entries list --}}
        <div id="guestbookList" class="guestbook-list" data-aos="fade-up">
            <div class="guestbook-empty" id="guestbookEmpty">
                <p>Belum ada ucapan. Jadilah yang pertama!</p>
            </div>
        </div>
    </div>
</section>

{{-- RSVP & Guestbook JS --}}
<script src="{{ asset('js/rsvp.js') }}" defer></script>
