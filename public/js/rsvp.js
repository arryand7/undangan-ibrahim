/**
 * RSVP & Guestbook — Vanilla JS (AJAX)
 * Handles RSVP modal, Gift modal with accordion, and Ucapan & Doa form.
 */

(function () {
    'use strict';

    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]');
    const DEFAULT_GUEST_TEXT = 'Bapak/Ibu/Saudara/i';
    const RSVP_NAME_KEYS = ['to', 'guest', 'nama', 'name', 'n'];

    // ---- DOM Elements ----
    const rsvpModal = document.getElementById('rsvpModal');
    const giftModal = document.getElementById('giftModal');
    const guestbookList = document.getElementById('guestbookList');
    const guestbookEmpty = document.getElementById('guestbookEmpty');
    const recipientGuestNameEls = document.querySelectorAll('.recipient-guest-name');
    const rsvpNameInput = document.getElementById('rsvp_nama');

    // ---- Load guestbook on page load ----
    loadGuestbook();
    initGuestIdentity();

    function normalizeGuestName(value) {
        return (value || '')
            .replace(/\s+/g, ' ')
            .trim();
    }

    function getGuestNameFromQuery() {
        const params = new URLSearchParams(window.location.search);
        for (let i = 0; i < RSVP_NAME_KEYS.length; i++) {
            const key = RSVP_NAME_KEYS[i];
            const value = normalizeGuestName(params.get(key));
            if (value) {
                return value;
            }
        }
        return '';
    }

    function getGuestNameFromCover() {
        if (!recipientGuestNameEls.length) return '';
        for (let i = 0; i < recipientGuestNameEls.length; i++) {
            const value = normalizeGuestName(recipientGuestNameEls[i].textContent);
            if (value && value !== DEFAULT_GUEST_TEXT) {
                return value;
            }
        }
        return '';
    }

    function syncGuestName(name) {
        const normalized = normalizeGuestName(name);
        if (!normalized) return;
        recipientGuestNameEls.forEach(function (el) {
            el.textContent = normalized;
        });
        if (rsvpNameInput) {
            rsvpNameInput.value = normalized;
        }
    }

    function initGuestIdentity() {
        const queryGuestName = getGuestNameFromQuery();
        const currentGuestName = getGuestNameFromCover();
        const finalGuestName = queryGuestName || currentGuestName;
        if (finalGuestName) {
            syncGuestName(finalGuestName);
        }
    }

    // ========================
    // RSVP MODAL
    // ========================
    var openRsvpBtn = document.getElementById('openRsvpModal');
    var closeRsvpBtn = document.getElementById('closeRsvpModal');
    var closeRsvpBtn2 = document.getElementById('closeRsvpModal2');

    if (openRsvpBtn) {
        openRsvpBtn.addEventListener('click', function () {
            if (!rsvpModal) return;
            rsvpModal.classList.add('active');
            if (rsvpNameInput && !normalizeGuestName(rsvpNameInput.value)) {
                setTimeout(function () {
                    rsvpNameInput.focus();
                }, 50);
            }
        });
    }

    if (closeRsvpBtn) {
        closeRsvpBtn.addEventListener('click', function () {
            rsvpModal.classList.remove('active');
        });
    }

    if (closeRsvpBtn2) {
        closeRsvpBtn2.addEventListener('click', function () {
            rsvpModal.classList.remove('active');
        });
    }

    // Close modal on overlay click
    if (rsvpModal) {
        rsvpModal.addEventListener('click', function (e) {
            if (e.target === rsvpModal) rsvpModal.classList.remove('active');
        });
    }

    // RSVP Hadir / Tidak Hadir buttons
    var hadirBtn = document.querySelector('.btn-hadir');
    var tidakBtn = document.querySelector('.btn-tidak');

    if (hadirBtn) {
        hadirBtn.addEventListener('click', function (e) {
            e.preventDefault();
            submitRsvp('hadir');
        });
    }

    if (tidakBtn) {
        tidakBtn.addEventListener('click', function (e) {
            e.preventDefault();
            submitRsvp('tidak');
        });
    }

    function submitRsvp(status) {
        var nama = rsvpNameInput ? normalizeGuestName(rsvpNameInput.value) : '';
        if (!nama) {
            showToast('Mohon isi nama tamu', 'error');
            if (rsvpNameInput) rsvpNameInput.focus();
            return;
        }

        var jumlahInput = document.getElementById('jumlah_hadir');
        var jumlah = jumlahInput ? parseInt(jumlahInput.value) || 1 : 1;
        if (jumlah < 1) jumlah = 1;
        if (jumlah > 10) jumlah = 10;

        var formData = {
            nama: nama,
            jumlah_hadir: jumlah,
            status_hadir: status,
            pesan: '',
        };

        syncGuestName(nama);

        fetch('/api/rsvp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN ? CSRF_TOKEN.content : '',
            },
            body: JSON.stringify(formData),
        })
            .then(function (response) {
                return response.json().then(function (data) {
                    return { ok: response.ok, data: data };
                });
            })
            .then(function (result) {
                if (result.ok && result.data.success) {
                    var msg = status === 'hadir' ? 'Terima kasih! Kami tunggu kehadirannya 🙏' : 'Terima kasih atas konfirmasinya 🙏';
                    showToast(msg);
                    rsvpModal.classList.remove('active');
                } else {
                    var errorMsg = 'Terjadi kesalahan. Silakan coba lagi.';
                    if (result.data.message) errorMsg = result.data.message;
                    showToast(errorMsg, 'error');
                }
            })
            .catch(function () {
                showToast('Gagal mengirim. Periksa koneksi Anda.', 'error');
            });
    }

    // ========================
    // GIFT MODAL
    // ========================
    var openGiftBtn = document.getElementById('openGiftModal');
    var closeGiftBtn = document.getElementById('closeGiftModal');
    var closeGiftBtn2 = document.getElementById('closeGiftModal2');

    if (openGiftBtn) {
        openGiftBtn.addEventListener('click', function () {
            giftModal.classList.add('active');
        });
    }

    if (closeGiftBtn) {
        closeGiftBtn.addEventListener('click', function () {
            giftModal.classList.remove('active');
        });
    }

    if (closeGiftBtn2) {
        closeGiftBtn2.addEventListener('click', function () {
            giftModal.classList.remove('active');
        });
    }

    if (giftModal) {
        giftModal.addEventListener('click', function (e) {
            if (e.target === giftModal) giftModal.classList.remove('active');
        });
    }

    // ========================
    // BANK ACCORDION
    // ========================
    var accordionHeaders = document.querySelectorAll('.bank-accordion-header');
    accordionHeaders.forEach(function (header) {
        header.addEventListener('click', function () {
            var targetId = this.getAttribute('data-target');
            var body = document.getElementById(targetId);

            // Close all others
            accordionHeaders.forEach(function (h) {
                if (h !== header) {
                    h.classList.remove('expanded');
                    var otherTarget = h.getAttribute('data-target');
                    var otherBody = document.getElementById(otherTarget);
                    if (otherBody) otherBody.classList.remove('open');
                }
            });

            // Toggle this one
            this.classList.toggle('expanded');
            if (body) body.classList.toggle('open');
        });
    });

    // ========================
    // UCAPAN & DOA FORM
    // ========================
    var ucapanForm = document.getElementById('rsvpForm2');
    var submitUcapanBtn = document.getElementById('submitUcapan');

    if (ucapanForm) {
        ucapanForm.addEventListener('submit', function (e) {
            e.preventDefault();

            var nama = document.getElementById('ucapanNama').value.trim();
            var pesan = document.getElementById('ucapanPesan').value.trim();

            if (!nama) {
                showToast('Mohon isi nama Anda', 'error');
                document.getElementById('ucapanNama').focus();
                return;
            }

            if (!pesan) {
                showToast('Mohon tulis ucapan & doa', 'error');
                document.getElementById('ucapanPesan').focus();
                return;
            }

            var formData = {
                nama: nama,
                jumlah_hadir: 1,
                status_hadir: 'hadir',
                pesan: pesan,
            };

            setUcapanLoading(true);

            fetch('/api/rsvp', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN ? CSRF_TOKEN.content : '',
                },
                body: JSON.stringify(formData),
            })
                .then(function (response) {
                    return response.json().then(function (data) {
                        return { ok: response.ok, data: data };
                    });
                })
                .then(function (result) {
                    setUcapanLoading(false);
                    if (result.ok && result.data.success) {
                        showToast('Ucapan berhasil dikirim! Terima kasih 🙏');
                        ucapanForm.reset();
                        loadGuestbook();
                    } else {
                        var errorMsg = 'Terjadi kesalahan. Silakan coba lagi.';
                        if (result.data.errors) {
                            var firstError = Object.values(result.data.errors)[0];
                            if (Array.isArray(firstError)) errorMsg = firstError[0];
                        } else if (result.data.message) {
                            errorMsg = result.data.message;
                        }
                        showToast(errorMsg, 'error');
                    }
                })
                .catch(function () {
                    setUcapanLoading(false);
                    showToast('Gagal mengirim. Periksa koneksi Anda.', 'error');
                });
        });
    }

    function setUcapanLoading(loading) {
        if (!submitUcapanBtn) return;
        var btnText = submitUcapanBtn.querySelector('.btn-text');
        var btnLoader = submitUcapanBtn.querySelector('.btn-loader');

        if (loading) {
            submitUcapanBtn.disabled = true;
            if (btnText) btnText.classList.add('hidden');
            if (btnLoader) btnLoader.classList.remove('hidden');
        } else {
            submitUcapanBtn.disabled = false;
            if (btnText) btnText.classList.remove('hidden');
            if (btnLoader) btnLoader.classList.add('hidden');
        }
    }

    // ---- Load Guestbook ----
    function loadGuestbook() {
        fetch('/api/guests', {
            headers: { 'Accept': 'application/json' },
        })
            .then(function (response) { return response.json(); })
            .then(function (result) {
                if (result.success && result.data && result.data.length > 0) {
                    renderGuests(result.data);
                }
            })
            .catch(function (err) {
                console.error('Guestbook load error:', err);
            });
    }

    // ---- Render Guest Entries ----
    function renderGuests(guests) {
        if (!guestbookList) return;

        if (guestbookEmpty) guestbookEmpty.style.display = 'none';

        var existing = guestbookList.querySelectorAll('.guest-entry');
        existing.forEach(function (el) { el.remove(); });

        guests.forEach(function (guest, index) {
            var entry = document.createElement('div');
            entry.className = 'guest-entry';
            entry.style.animationDelay = (index * 0.1) + 's';

            var date = new Date(guest.created_at);
            var dateStr = date.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric',
            });
            var timeStr = date.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
            });

            entry.innerHTML =
                '<div class="guest-header">' +
                '  <span class="guest-name">' + escapeHtml(guest.nama) + '</span>' +
                '</div>' +
                '<span class="guest-date">🕐 ' + dateStr + ' ' + timeStr + '</span>' +
                (guest.pesan ? '<p class="guest-message">' + escapeHtml(guest.pesan) + '</p>' : '');

            guestbookList.appendChild(entry);
        });
    }

    // ---- Escape HTML ----
    function escapeHtml(text) {
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
})();
