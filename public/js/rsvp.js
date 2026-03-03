/**
 * RSVP & Guestbook — Vanilla JS (AJAX)
 * Handles RSVP form submission and guestbook display.
 */

(function () {
    'use strict';

    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]');
    const form = document.getElementById('rsvpForm');
    const submitBtn = document.getElementById('submitRsvp');
    const guestbookList = document.getElementById('guestbookList');
    const guestbookEmpty = document.getElementById('guestbookEmpty');

    // ---- Load guestbook on page load ----
    loadGuestbook();

    // ---- RSVP Form Submit ----
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            // Basic validation
            const nama = form.querySelector('#nama').value.trim();
            if (!nama) {
                showToast('Mohon isi nama Anda', 'error');
                form.querySelector('#nama').focus();
                return;
            }

            // Get form data
            const formData = {
                nama: nama,
                jumlah_hadir: parseInt(form.querySelector('#jumlah_hadir').value) || 1,
                status_hadir: form.querySelector('input[name="status_hadir"]:checked').value,
                pesan: form.querySelector('#pesan').value.trim(),
            };

            // Show loading
            setSubmitLoading(true);

            // POST to API
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
                    setSubmitLoading(false);

                    if (result.ok && result.data.success) {
                        showToast('RSVP berhasil dikirim! Terima kasih 🙏');
                        form.reset();
                        // Reset radio to default
                        var defaultRadio = form.querySelector('input[name="status_hadir"][value="hadir"]');
                        if (defaultRadio) defaultRadio.checked = true;

                        // Reload guestbook
                        loadGuestbook();

                        // Scroll to guestbook
                        setTimeout(function () {
                            var gb = document.getElementById('guestbook');
                            if (gb) {
                                gb.scrollIntoView({ behavior: 'smooth', block: 'start' });
                            }
                        }, 500);
                    } else {
                        // Validation errors
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
                .catch(function (err) {
                    setSubmitLoading(false);
                    console.error('RSVP error:', err);
                    showToast('Gagal mengirim. Periksa koneksi Anda.', 'error');
                });
        });
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

        // Hide empty message
        if (guestbookEmpty) guestbookEmpty.style.display = 'none';

        // Clear existing entries
        var existing = guestbookList.querySelectorAll('.guest-entry');
        existing.forEach(function (el) { el.remove(); });

        // Render each guest
        guests.forEach(function (guest, index) {
            var entry = document.createElement('div');
            entry.className = 'guest-entry';
            entry.style.animationDelay = (index * 0.1) + 's';

            var statusClass = guest.status_hadir === 'hadir' ? 'hadir' : 'tidak';
            var statusText = guest.status_hadir === 'hadir' ? 'Hadir' : 'Tidak Hadir';

            var date = new Date(guest.created_at);
            var dateStr = date.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
            });

            entry.innerHTML =
                '<div class="guest-header">' +
                '  <span class="guest-name">' + escapeHtml(guest.nama) + '</span>' +
                '  <span class="guest-status ' + statusClass + '">' + statusText + '</span>' +
                '</div>' +
                (guest.pesan ? '<p class="guest-message">' + escapeHtml(guest.pesan) + '</p>' : '') +
                '<span class="guest-date">' + dateStr + '</span>';

            guestbookList.appendChild(entry);
        });
    }

    // ---- Submit Loading State ----
    function setSubmitLoading(loading) {
        if (!submitBtn) return;
        var btnText = submitBtn.querySelector('.btn-text');
        var btnLoader = submitBtn.querySelector('.btn-loader');

        if (loading) {
            submitBtn.disabled = true;
            if (btnText) btnText.classList.add('hidden');
            if (btnLoader) btnLoader.classList.remove('hidden');
        } else {
            submitBtn.disabled = false;
            if (btnText) btnText.classList.remove('hidden');
            if (btnLoader) btnLoader.classList.add('hidden');
        }
    }

    // ---- Escape HTML ----
    function escapeHtml(text) {
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
})();
