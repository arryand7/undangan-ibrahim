/**
 * App.js — Main Application Logic
 * Scroll animations, countdown, music, clipboard copy, toast.
 */

(function () {
    'use strict';

    // ============================================
    // 0. PRELOADER (1.5s logo fade)
    // ============================================
    var preloader = document.getElementById('preloader');
    if (preloader) {
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                preloader.classList.add('preloader-hide');
                document.body.classList.remove('preloading');
                setTimeout(function () {
                    if (preloader && preloader.parentNode) {
                        preloader.parentNode.removeChild(preloader);
                    }
                }, 700);
            }, 1500);
        });
    } else {
        document.body.classList.remove('preloading');
    }

    // ============================================
    // 1. "BUKA UNDANGAN" — Hero Dismiss
    // ============================================
    var openBtn = document.getElementById('openInvitation');
    var hero = document.getElementById('hero');
    var mainContent = document.getElementById('mainContent');
    var bgMusic = document.getElementById('bgMusic');
    var isMusicPlaying = false;

    if (openBtn) {
        openBtn.addEventListener('click', function () {
            // Fade out hero
            if (hero) {
                hero.classList.add('hero-exit');
            }

            // Show main content
            setTimeout(function () {
                if (mainContent) {
                    mainContent.classList.add('visible');
                }

                // Hide hero completely after animation
                setTimeout(function () {
                    if (hero) {
                        hero.style.display = 'none';
                    }
                }, 500);

                // Start music
                playMusic();

                // Trigger scroll animations for visible elements
                setTimeout(initScrollAnimations, 200);

                // Auto-scroll to the next section
                var firstSection = document.getElementById('couple');
                if (firstSection) {
                    setTimeout(function () {
                        firstSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 300);
                }
            }, 600);
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
            bgMusic.volume = 0.3;
            var playPromise = bgMusic.play();
            if (playPromise !== undefined) {
                playPromise.then(function () {
                    isMusicPlaying = true;
                    updateMusicIcon();
                }).catch(function () {
                    // Autoplay blocked — that's okay
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
            }).catch(function () { });
        }
        updateMusicIcon();
    }

    function updateMusicIcon() {
        if (musicIconOn && musicIconOff) {
            if (isMusicPlaying) {
                musicIconOn.classList.remove('hidden');
                musicIconOff.classList.add('hidden');
            } else {
                musicIconOn.classList.add('hidden');
                musicIconOff.classList.remove('hidden');
            }
        }
    }

    if (musicToggle) {
        musicToggle.addEventListener('click', toggleMusic);
    }

    // ============================================
    // 3. SCROLL ANIMATIONS (IntersectionObserver)
    // ============================================
    function initScrollAnimations() {
        if (!('IntersectionObserver' in window)) {
            // Fallback: show all immediately
            document.querySelectorAll('.animate-on-scroll').forEach(function (el) {
                el.classList.add('visible');
            });
            return;
        }

        var observer = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            },
            {
                threshold: 0.15,
                rootMargin: '0px 0px -40px 0px',
            }
        );

        document.querySelectorAll('.animate-on-scroll').forEach(function (el) {
            observer.observe(el);
        });
    }

    // ============================================
    // 4. COUNTDOWN TIMER
    // ============================================
    var countDays = document.getElementById('countDays');
    var countHours = document.getElementById('countHours');
    var countMinutes = document.getElementById('countMinutes');
    var countSeconds = document.getElementById('countSeconds');
    var countdownTimer = document.getElementById('countdownTimer');

    // Target: 26 March 2026 07:00 WIB (UTC+7)
    var targetAttr = countdownTimer ? countdownTimer.getAttribute('data-target') : null;
    var TARGET_DATE = targetAttr ? new Date(targetAttr) : new Date('2026-03-26T07:00:00+07:00');

    function updateCountdown() {
        var now = new Date();
        var diff = TARGET_DATE - now;

        if (diff <= 0) {
            setCountdownValue(countDays, '00');
            setCountdownValue(countHours, '00');
            setCountdownValue(countMinutes, '00');
            setCountdownValue(countSeconds, '00');
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

        requestAnimationFrame(function () {
            setTimeout(updateCountdown, 1000);
        });
    }

    function setCountdownValue(el, value) {
        if (!el) return;
        if (el.textContent !== value) {
            el.textContent = value;
            el.classList.remove('flip');
            // Trigger reflow
            void el.offsetWidth;
            el.classList.add('flip');
        }
    }

    function padZero(num) {
        return num < 10 ? '0' + num : String(num);
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
        var ta = document.createElement('textarea');
        ta.value = text;
        ta.style.position = 'fixed';
        ta.style.left = '-9999px';
        document.body.appendChild(ta);
        ta.select();
        try {
            document.execCommand('copy');
            onCopySuccess(button);
        } catch (e) {
            showToast('Gagal menyalin', 'error');
        }
        document.body.removeChild(ta);
    }

    function onCopySuccess(button) {
        showToast('Nomor rekening disalin!');
        if (button) {
            button.classList.add('copied');
            var span = button.querySelector('span');
            if (span) {
                var original = span.textContent;
                span.textContent = 'Disalin!';
                setTimeout(function () {
                    button.classList.remove('copied');
                    span.textContent = original;
                }, 2000);
            }
        }
    }

    // ============================================
    // 6. TOAST NOTIFICATION
    // ============================================
    window.showToast = function (message, type) {
        var toast = document.getElementById('toast');
        if (!toast) return;

        toast.textContent = message;
        toast.style.borderColor = type === 'error' ? '#f87171' : '#c9a96e';
        toast.classList.add('show');

        setTimeout(function () {
            toast.classList.remove('show');
        }, 3000);
    };

})();
