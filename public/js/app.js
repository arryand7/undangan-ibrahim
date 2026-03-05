/**
 * App.js — Main Application Logic
 * Scroll animations, countdown, music, clipboard copy, toast.
 * Tema Hijau Sage
 */

(function () {
    'use strict';

    // ============================================
    // 0. PRELOADER (1.5s logo fade)
    // ============================================
    var preloader = document.getElementById('preloader');
    if (preloader) {
        window.addEventListener('load', function () {
            setTimeout(function () {
                preloader.classList.add('hidden');
                document.body.classList.remove('preloading');
            }, 1500);
        });
    }

    // ============================================
    // 1. OPEN INVITATION (Cover → Main Content)
    // ============================================
    var openBtn = document.getElementById('openInvitation');
    var cover = document.getElementById('cover');
    var mainContent = document.getElementById('mainContent');
    var bgMusic = document.getElementById('bgMusic');
    var bottomNav = document.getElementById('bottomNav');
    var invitationOpened = false;
    var isMusicPlaying = false;

    function snapToTopOfInvitation() {
        var opening = document.getElementById('opening');
        if (opening) {
            opening.scrollIntoView({ behavior: 'auto', block: 'start' });
        } else {
            window.scrollTo({ top: 0, left: 0, behavior: 'auto' });
        }

        // Extra safety for mobile browsers with quirky scroll restoration.
        document.documentElement.scrollTop = 0;
        document.body.scrollTop = 0;
    }

    function openInvitationFlow() {
        if (invitationOpened) return;
        invitationOpened = true;

        // Fade out cover
        if (cover) {
            cover.classList.add('cover-exit');
        }

        // Show main content
        if (mainContent) {
            mainContent.style.display = 'block';
            requestAnimationFrame(function () {
                mainContent.classList.add('visible');
            });
        }

        snapToTopOfInvitation();

        // Show bottom nav
        if (bottomNav) {
            bottomNav.style.display = 'flex';
        }

        // Auto-play music
        playMusic();

        // Initialize AOS after content becomes visible
        setTimeout(function () {
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 800,
                    easing: 'ease-out',
                    once: true,
                    offset: 50
                });
            }
            refreshInViewAnimations();
        }, 300);

        // Remove cover after animation
        setTimeout(function () {
            if (cover) {
                cover.style.display = 'none';
            }
            snapToTopOfInvitation();
            refreshInViewAnimations();
        }, 800);
    }

    if (openBtn) {
        openBtn.addEventListener('click', openInvitationFlow);
    }

    var autopenEnabled = new URLSearchParams(window.location.search).get('autopen') === '1';
    if (autopenEnabled) {
        window.addEventListener('load', function () {
            // Wait for preloader sequence before entering content
            setTimeout(function () {
                openInvitationFlow();
            }, 1700);
        });
    }

    // ============================================
    // 2. BACKGROUND MUSIC
    // ============================================
    var musicToggle = document.getElementById('musicToggle');
    var musicIconOn = document.getElementById('musicIconOn');
    var musicIconOff = document.getElementById('musicIconOff');

    function playMusic() {
        if (bgMusic && !isMusicPlaying) {
            var playPromise = bgMusic.play();
            if (playPromise !== undefined) {
                playPromise.then(function () {
                    isMusicPlaying = true;
                    updateMusicIcon();
                }).catch(function () {
                    // Autoplay blocked — user will toggle manually
                    isMusicPlaying = false;
                    updateMusicIcon();
                });
            }
        }
    }

    function toggleMusic() {
        if (!bgMusic) return;
        if (isMusicPlaying) {
            bgMusic.pause();
            isMusicPlaying = false;
        } else {
            bgMusic.play().then(function () {
                isMusicPlaying = true;
            }).catch(function () {});
        }
        updateMusicIcon();
    }

    function updateMusicIcon() {
        if (!musicIconOn || !musicIconOff) return;
        if (isMusicPlaying) {
            musicIconOn.classList.remove('hidden');
            musicIconOff.classList.add('hidden');
        } else {
            musicIconOn.classList.add('hidden');
            musicIconOff.classList.remove('hidden');
        }
    }

    if (musicToggle) {
        musicToggle.addEventListener('click', toggleMusic);
    }

    // ============================================
    // 3. SCROLL ANIMATIONS (IntersectionObserver)
    // ============================================
    function isInViewport(el) {
        if (!el) return false;
        var rect = el.getBoundingClientRect();
        var viewportH = window.innerHeight || document.documentElement.clientHeight;
        var visibleTop = Math.max(rect.top, 0);
        var visibleBottom = Math.min(rect.bottom, viewportH);
        var visibleHeight = visibleBottom - visibleTop;
        if (visibleHeight <= 0) return false;
        var minVisible = Math.min(Math.max(rect.height * 0.12, 24), 120);
        return visibleHeight >= minVisible;
    }

    function revealAosInViewport() {
        var aosItems = document.querySelectorAll('[data-aos]');
        aosItems.forEach(function (el) {
            if (isInViewport(el)) {
                el.classList.add('aos-animate');
            }
        });
    }

    function refreshInViewAnimations() {
        if (typeof AOS !== 'undefined') {
            AOS.refreshHard();
        }
        revealAosInViewport();
        initScrollAnimations();
    }

    function initScrollAnimations() {
        var elements = document.querySelectorAll('.animate-on-scroll');
        if (!elements.length) return;

        if ('IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

            elements.forEach(function (el) {
                if (el.classList.contains('visible') || isInViewport(el)) {
                    el.classList.add('visible');
                    return;
                }
                observer.observe(el);
            });
        } else {
            // Fallback for old browsers
            elements.forEach(function (el) {
                el.classList.add('visible');
            });
        }
    }

    // ============================================
    // 4. COUNTDOWN TIMER
    // ============================================
    var countDays = document.getElementById('countDays');
    var countHours = document.getElementById('countHours');
    var countMinutes = document.getElementById('countMinutes');
    var countSeconds = document.getElementById('countSeconds');
    var openingDays = document.querySelectorAll('.opening-intro-countdown [data-count-unit="days"]');
    var openingHours = document.querySelectorAll('.opening-intro-countdown [data-count-unit="hours"]');
    var openingMinutes = document.querySelectorAll('.opening-intro-countdown [data-count-unit="minutes"]');
    var openingSeconds = document.querySelectorAll('.opening-intro-countdown [data-count-unit="seconds"]');
    var coverCountdown = document.getElementById('coverCountdown');

    // Target: 26 March 2026 07:00 WIB (UTC+7)
    var targetAttr = coverCountdown ? coverCountdown.getAttribute('data-target') : null;
    var TARGET_DATE = targetAttr ? new Date(targetAttr) : new Date('2026-03-26T07:00:00+07:00');

    function updateCountdown() {
        var now = new Date();
        var diff = TARGET_DATE - now;

        if (diff <= 0) {
            setCountdownValue(countDays, '00');
            setCountdownValue(countHours, '00');
            setCountdownValue(countMinutes, '00');
            setCountdownValue(countSeconds, '00');
            setCountdownGroupValue(openingDays, '00');
            setCountdownGroupValue(openingHours, '00');
            setCountdownGroupValue(openingMinutes, '00');
            setCountdownGroupValue(openingSeconds, '00');
            return;
        }

        var days = Math.floor(diff / (1000 * 60 * 60 * 24));
        var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((diff % (1000 * 60)) / 1000);

        setCountdownValue(countDays, padZero(days));
        setCountdownValue(countHours, padZero(hours));
        setCountdownValue(countMinutes, padZero(minutes));
        setCountdownValue(countSeconds, padZero(seconds));
        setCountdownGroupValue(openingDays, padZero(days));
        setCountdownGroupValue(openingHours, padZero(hours));
        setCountdownGroupValue(openingMinutes, padZero(minutes));
        setCountdownGroupValue(openingSeconds, padZero(seconds));

        requestAnimationFrame(function () {
            setTimeout(updateCountdown, 1000);
        });
    }

    function setCountdownValue(el, value) {
        if (!el) return;
        var current = el.textContent;
        if (current !== value) {
            el.textContent = value;
            el.style.transform = 'scale(1.15)';
            setTimeout(function () {
                el.style.transform = 'scale(1)';
            }, 200);
        }
    }

    function setCountdownGroupValue(elements, value) {
        if (!elements || !elements.length) return;
        elements.forEach(function (el) {
            setCountdownValue(el, value);
        });
    }

    function padZero(num) {
        return num < 10 ? '0' + num : '' + num;
    }

    // Start countdown
    updateCountdown();

    // ============================================
    // 5. COPY TO CLIPBOARD
    // ============================================
    window.copyToClipboard = function (text, button) {
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(function () {
                onCopySuccess(button);
            }).catch(function () {
                fallbackCopy(text, button);
            });
        } else {
            fallbackCopy(text, button);
        }
    };

    function fallbackCopy(text, button) {
        var textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';
        document.body.appendChild(textarea);
        textarea.select();
        try {
            document.execCommand('copy');
            onCopySuccess(button);
        } catch (e) {
            showToast('Gagal menyalin', 'error');
        }
        document.body.removeChild(textarea);
    }

    function onCopySuccess(button) {
        showToast('Berhasil disalin!', 'success');
        if (button) {
            button.classList.add('copied');
            var originalSpan = button.querySelector('span');
            var originalText = originalSpan ? originalSpan.textContent : '';
            if (originalSpan) originalSpan.textContent = 'Tersalin!';
            setTimeout(function () {
                button.classList.remove('copied');
                if (originalSpan) originalSpan.textContent = originalText;
            }, 2000);
        }
    }

    // ============================================
    // 6. TOAST NOTIFICATION
    // ============================================
    window.showToast = function (message, type) {
        var toast = document.getElementById('toast');
        if (!toast) return;
        toast.textContent = message;
        toast.className = 'toast visible';
        if (type) toast.classList.add(type);

        setTimeout(function () {
            toast.classList.remove('visible');
        }, 3000);
    };

})();
