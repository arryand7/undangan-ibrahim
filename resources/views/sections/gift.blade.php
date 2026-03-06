{{-- Wedding Gift Section --}}

{{-- Leaf separator --}}
<div class="leaf-separator">
    <img src="{{ asset('images/leaf-3.png') }}" alt="">
</div>

<section id="gift" class="section gift-section">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Kado</h2>
        <div class="section-divider" data-aos="fade-up"></div>
        <p class="section-desc" data-aos="fade-up">
            Doa restu anda merupakan karunia yang sangat berarti bagi kedua mempelai. Namun jika memberi adalah ungkapan tanda kasih anda, anda dapat menggunakan fitur berikut
        </p>

        {{-- Big Kirim Kado Button --}}
        <div class="gift-btn-area" data-aos="fade-up">
            <button type="button" class="btn-big-action" id="openGiftModal">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="28" height="28">
                    <polyline points="20 12 20 22 4 22 4 12"/>
                    <rect x="2" y="7" width="20" height="5"/>
                    <line x1="12" y1="22" x2="12" y2="7"/>
                    <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/>
                    <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/>
                </svg>
                <span>Kirim Kado</span>
            </button>
        </div>

        {{-- Address --}}
        <div class="gift-address-area" data-aos="fade-up">
            <p class="gift-address-title">Kirim Kado Ke Alamat</p>
            <p class="gift-address-desc">Anda juga dapat mengirimkan melalui alamat berikut</p>
            <div class="gift-address-box">
                <ul class="gift-address-list" align="left">
                    <li>Rumah Dewi : Kp. Selauni RT 013 RW 004, Ds. Kertamandala, Kec. Panjalu, Kab. Ciamis, Jawa Barat</li>
                    <li>Rumah Ibrahim : Terungkulon RT 003 RW 001, Ds. Terungkulon, Kec. Krian, Kab. Sidoarjo, Jawa Timur</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- Gift Modal --}}
<div id="giftModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Kado</h3>
            <button class="modal-close" id="closeGiftModal" aria-label="Close">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="15" y1="9" x2="9" y2="15"/>
                    <line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <h4 class="modal-subtitle">Kado Cashless</h4>
            <p class="modal-subdesc">Anda dapat mengirimkan kado cashless. Pilih metode pembayaran dibawah</p>

            {{-- BRI Accordion --}}
            <div class="bank-accordion">
                <button type="button" class="bank-accordion-header" data-target="briDetail">
                    <span class="bank-header-left">
                        <span class="bank-logo-pill">
                            <img src="{{ asset('images/bri.svg') }}" alt="Logo BRI" class="bank-logo-small">
                        </span>
                        <span class="bank-name-text">BRI</span>
                    </span>
                    <svg class="accordion-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </button>
                <div class="bank-accordion-body" id="briDetail">
                    <div class="bank-detail-card">
                        <div class="bank-detail-logo-wrap">
                            <img src="{{ asset('images/bri.svg') }}" alt="Logo BRI" class="bank-detail-logo">
                        </div>
                        <p class="bank-label-title">Bank BRI</p>
                        <p class="bank-label">Nama Rekening</p>
                        <p class="bank-value">DEWI SRI MULYANI</p>
                        <p class="bank-label">Nomor Rekening</p>
                        <p class="bank-value bank-number">
                            <span id="briAccountNum">135401019188500</span>
                            <button class="btn-copy-inline" onclick="copyToClipboard('135401019188500', this)" aria-label="Copy">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                                </svg>
                            </button>
                        </p>
                    </div>
                </div>
            </div>

            {{-- BRI Accordion --}}
            <div class="bank-accordion">
                <button type="button" class="bank-accordion-header" data-target="briDetail2">
                    <span class="bank-header-left">
                        <span class="bank-logo-pill">
                            <img src="{{ asset('images/bri.svg') }}" alt="Logo BRI" class="bank-logo-small">
                        </span>
                        <span class="bank-name-text">BRI</span>
                    </span>
                    <svg class="accordion-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </button>
                <div class="bank-accordion-body" id="briDetail2">
                    <div class="bank-detail-card">
                        <div class="bank-detail-logo-wrap">
                            <img src="{{ asset('images/bri.svg') }}" alt="Logo BRI" class="bank-detail-logo">
                        </div>
                        <p class="bank-label-title">Bank BRI</p>
                        <p class="bank-label">Nama Rekening</p>
                        <p class="bank-value">IBRAHIM HASAN MULUDI</p>
                        <p class="bank-label">Nomor Rekening</p>
                        <p class="bank-value bank-number">
                            <span id="briAccountNum">005501040264534</span>
                            <button class="btn-copy-inline" onclick="copyToClipboard('005501040264534', this)" aria-label="Copy">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                                </svg>
                            </button>
                        </p>
                    </div>
                </div>
            </div>

            {{-- BSI Accordion --}}
            <div class="bank-accordion">
                <button type="button" class="bank-accordion-header" data-target="bsiDetail">
                    <span class="bank-header-left">
                        <span class="bank-logo-pill">
                            <img src="{{ asset('images/bsi.png') }}" alt="Logo BSI" class="bank-logo-small">
                        </span>
                        <span class="bank-name-text">BSI</span>
                    </span>
                    <svg class="accordion-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </button>
                <div class="bank-accordion-body" id="bsiDetail">
                    <div class="bank-detail-card">
                        <div class="bank-detail-logo-wrap">
                            <img src="{{ asset('images/bsi.png') }}" alt="Logo BSI" class="bank-detail-logo">
                        </div>
                        <p class="bank-label-title">Bank BSI</p>
                        <p class="bank-label">Nama Rekening</p>
                        <p class="bank-value">IBRAHIM HASAN MAULUDI</p>
                        <p class="bank-label">Nomor Rekening</p>
                        <p class="bank-value bank-number">
                            <span id="bsiAccountNum">7121574386</span>
                            <button class="btn-copy-inline" onclick="copyToClipboard('7121574386', this)" aria-label="Copy">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                                </svg>
                            </button>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Address in modal --}}
            <div class="modal-address-area">
                <h4 class="modal-subtitle" style="margin-top: 24px;">Kirim Kado Ke Alamat</h4>
                <p class="modal-subdesc">Anda juga dapat mengirimkan melalui alamat berikut</p>
                <ul style="text-align: left; margin-left: 10px;">
                    <li>Rumah Dewi : Kp. Selauni RT 013 RW 004, Ds. Kertamandala, Kec. Panjalu, Kab. Ciamis, Jawa Barat</li>
                    <li>Rumah Ibrahim : Terungkulon RT 003 RW 001, Ds. Terungkulon, Kec. Krian, Kab. Sidoarjo, Jawa Timur</li>
                </ul>
            </div>

            <div class="modal-footer-actions">
                <button type="button" class="btn-modal-close-text" id="closeGiftModal2">Close</button>
            </div>
        </div>
    </div>
</div>
