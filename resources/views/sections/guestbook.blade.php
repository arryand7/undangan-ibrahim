{{-- Guestbook Section --}}
<section id="guestbook" class="section guestbook-section">
    <div class="container">
        <h2 class="section-title animate-on-scroll">Buku Tamu</h2>
        <div class="section-divider animate-on-scroll"></div>

        <div id="guestbookList" class="guestbook-list">
            {{-- Guest entries will be loaded via AJAX --}}
            <div class="guestbook-empty" id="guestbookEmpty">
                <p>Belum ada ucapan. Jadilah yang pertama!</p>
            </div>
        </div>
    </div>
</section>

{{-- RSVP & Guestbook JS --}}
<script src="{{ asset('js/rsvp.js') }}" defer></script>
