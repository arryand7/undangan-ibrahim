Berikut adalah **blueprint arsitektur lengkap + flow animasi detail per section** untuk website undangan:

Subdomain: `ibrahim.sabira-iibs.id`
Tema: Modern Minimalis
Target: HP kentang (low-end Android friendly)
Stack: Laravel + Blade + Three.js (ringan) + AJAX RSVP

Saya jelaskan secara sistematis: arsitektur → struktur folder → flow UX → flow animasi → database → optimasi performa.

────────────────────────
I. ARSITEKTUR SISTEM
────────────────────────

Frontend Layer

* Blade Template
* Three.js (hanya di hero)
* GSAP (animasi ringan)
* Vanilla JS (AJAX RSVP)

Backend Layer

* Laravel 11
* MySQL
* API endpoint untuk RSVP & Guestbook

Server Layer

* Ubuntu 24.04 (VPS Anda)
* Nginx
* PHP-FPM 8.2
* SSL Let's Encrypt

Arsitektur ini memastikan:

* Animasi hanya di atas (tidak berat)
* Scroll biasa setelah hero (hemat GPU)
* Database ringan (1 tabel utama)

────────────────────────
II. STRUKTUR FOLDER PROJECT
────────────────────────

resources/views/

* layout.blade.php
* sections/

  * hero.blade.php
  * couple.blade.php
  * event.blade.php
  * countdown.blade.php
  * location.blade.php
  * gift.blade.php
  * rsvp.blade.php
  * guestbook.blade.php

public/

* js/three-hero.js
* js/rsvp.js
* audio/backsound.mp3
* images/

────────────────────────
III. FLOW UX (USER EXPERIENCE FLOW)
────────────────────────

1. User buka link
2. Loading 1.5 detik (logo fade)
3. Hero 3D muncul
4. User klik “Buka Undangan”
5. Musik mulai
6. Scroll smooth ke section berikutnya
7. RSVP isi form
8. Data langsung tampil di buku tamu

Semua dibuat linear & simpel (tidak membingungkan).

────────────────────────
IV. FLOW ANIMASI DETAIL PER SECTION
────────────────────────

SECTION 1 — HERO 3D (Only 1 Scene WebGL)

Scene Elements:

* Background gradient gelap
* 40 particle floating
* Text 3D tipis: IBRAHIM & DEWI

Animasi:

* Particle slow drift
* Text fade-in opacity 0 → 1 (1.2s)
* Subtext slide-up
* Button fade

Saat klik:

* Camera zoom 1.0 → 0.85 (0.8s)
* Hero opacity turun
* Main content fade in

Optimization:

* No shadow
* No environment map
* No heavy geometry

Target FPS: stabil 30 di HP low-end

────────────────────────

SECTION 2 — COUPLE PROFILE

Style:
Card minimal dengan glass blur ringan

Animasi:

* Fade up ketika scroll masuk viewport
* Duration 0.6s
* Stagger delay 0.2s antar card

Tidak ada 3D di sini (hemat resource).

────────────────────────

SECTION 3 — DETAIL ACARA

Layout:
Dua card terpisah:

* Akad & Resepsi
* Tasyakur

Animasi:

* Slide dari kiri dan kanan
* Soft shadow glow
* Hover micro animation (scale 1.02)

Google Maps:
Tombol buka link saja (tidak embed map iframe agar ringan).

────────────────────────

SECTION 4 — COUNTDOWN

Animasi:

* Number flip ringan tiap detik
* Menggunakan requestAnimationFrame
* Tanpa library berat

Countdown target:
26 Maret 2026 07:00 WIB

────────────────────────

SECTION 5 — WEDDING GIFT

Design:
Card modern

* Logo Bank
* Nomor rekening
* Tombol Copy

Animasi:

* Fade up
* Button micro animation

Detail rekening:

BRI
005501040264534
IBRAHIM HASAN MULUDI

BSI
7121574386
IBRAHIM HASAN MAULUDI

(Saya sarankan samakan ejaan agar tidak membingungkan tamu.)

────────────────────────

SECTION 6 — RSVP

Form:

* Nama
* Jumlah hadir
* Status hadir
* Pesan doa

Animasi:

* Input glow saat fokus
* Submit button loading spinner

AJAX:
POST /api/rsvp

Response:

* Success toast
* Auto scroll ke guestbook

────────────────────────

SECTION 7 — BUKU TAMU

Layout:
List card minimal

Animasi:

* New entry fade-in
* Tanpa reload halaman

Pagination:
Load 10 terakhir (agar ringan)

────────────────────────
V. DATABASE SCHEMA
────────────────────────

Table: guests

id (bigint)
nama (varchar 100)
jumlah_hadir (int)
status_hadir (enum hadir/tidak)
pesan (text)
created_at

Index:

* created_at index

Tidak perlu relasi tabel lain.

────────────────────────
VI. PERFORMANCE STRATEGY (PENTING UNTUK HP KENTANG)
────────────────────────

* Total JS < 300KB
* Total page < 2MB
* Audio < 1.5MB
* Gambar WebP max 150KB
* Lazy load images
* Compress via gzip Nginx
* Cache static asset 30 hari

Three.js hanya aktif di hero. Setelah scroll keluar hero, render loop dihentikan untuk hemat baterai.

────────────────────────
VII. ESTIMASI RESOURCE VPS

RAM usage: sangat kecil
DB query ringan
Traffic 1.000 tamu aman

Server Anda lebih dari cukup.

────────────────────────
VIII. OPSI TAMBAHAN (JIKA INGIN LEBIH PREMIUM)

* Animasi partikel berbentuk kaligrafi
* Preloader cinematic
* QR check-in system
* Admin panel untuk lihat RSVP

────────────────────────

dan Berikut adalah **Dokumen Teknis (Technical Specification Document)** untuk pengembangan website undangan digital:

PROJECT:
Wedding Invitation – IBRAHIM & DEWI
Subdomain: ibrahim.sabira-iibs.id
Environment: VPS Ubuntu 24.04 + Nginx + PHP-FPM + MySQL
Framework: Laravel 11
Frontend: Blade + Three.js (hero only) + Vanilla JS

Dokumen ini disusun agar developer bisa langsung implement tanpa interpretasi ambigu.

────────────────────────

1. OBJECTIVE SISTEM
   ────────────────────────

Membangun website undangan pernikahan modern minimalis dengan animasi 3D ringan, dioptimalkan untuk perangkat low-end Android (HP kentang), dengan fitur:

* Hero 3D ringan
* Detail acara (2 lokasi)
* Countdown
* Wedding Gift (BRI & BSI)
* RSVP system
* Buku tamu realtime
* Background music

Non-goals:

* Tidak ada admin panel kompleks
* Tidak ada dashboard analytics
* Tidak embed Google Maps (link only)

────────────────────────
2. SYSTEM ARCHITECTURE
────────────────────────

Client Layer:

* HTML5
* CSS3 (Tailwind optional)
* Three.js (hero only)
* GSAP (optional, ringan)
* Vanilla JS (AJAX RSVP)

Application Layer:

* Laravel 11 (MVC)
* REST endpoint untuk RSVP

Database Layer:

* MySQL (single table core)

Web Server:

* Nginx
* PHP-FPM 8.2+

SSL:

* Let's Encrypt

────────────────────────
3. DIRECTORY STRUCTURE
────────────────────────

/app
/routes
/database
/resources/views
layout.blade.php
welcome.blade.php
sections/
hero.blade.php
couple.blade.php
events.blade.php
countdown.blade.php
gift.blade.php
rsvp.blade.php
guestbook.blade.php

/public
js/three-hero.js
js/rsvp.js
audio/backsound.mp3
images/

────────────────────────
4. DATABASE DESIGN
────────────────────────

Database: wedding_ibrahim

Table: guests

Field Specification:

id → bigint (PK, auto increment)
nama → varchar(100), not null
jumlah_hadir → int, default 1
status_hadir → enum('hadir','tidak')
pesan → text
created_at → timestamp
updated_at → timestamp

Index:

* created_at (index)

No foreign key required.

────────────────────────
5. ROUTING SPECIFICATION
────────────────────────

Web Routes:

GET /
→ return welcome view

API Routes:

POST /api/rsvp
→ store guest

GET /api/guests
→ return last 10 guests ordered desc

────────────────────────
6. FRONTEND FLOW
────────────────────────

6.1 Hero Section (WebGL)

Library: Three.js

Scene configuration:

* PerspectiveCamera
* Renderer antialias: false
* No shadow
* No HDRI
* Particle count max 40

Objects:

* Particle system (PointsMaterial)
* Text geometry sederhana (atau CSS overlay untuk lebih ringan)

Animation:

* requestAnimationFrame loop
* Drift rotation kecil
* Auto stop render ketika user scroll > 100vh

Button Action:

* Fade out hero
* Start background music
* Scroll to main section

Target FPS: minimum 28 stabil pada device low-end.

────────────────────────

6.2 Couple Section

Layout:

* 2 Card profile
* Glassmorphism ringan

Animation:

* IntersectionObserver trigger
* Fade + translateY 20px
* Duration 600ms

────────────────────────

6.3 Events Section

Card 1:
Akad & Resepsi – 26 Maret 2026 – Ciamis

Card 2:
Tasyakur – 29 Maret 2026 – Sidoarjo

Map:

* Button external link only

Animation:

* Slide in from opposite direction

────────────────────────

6.4 Countdown Section

Target datetime:
2026-03-26 07:00:00 WIB

Logic:

* JS Date object
* Update per second
* Format: Days / Hours / Minutes / Seconds

No heavy flip animation.

────────────────────────

6.5 Wedding Gift Section

Data statis:

BRI
005501040264534
IBRAHIM HASAN MULUDI

BSI
7121574386
IBRAHIM HASAN MAULUDI

Features:

* Copy to clipboard
* Toast notification

────────────────────────

6.6 RSVP Section

Form Fields:

* nama (required)
* jumlah_hadir (min 1)
* status_hadir (radio)
* pesan (optional)

AJAX:
Fetch POST → /api/rsvp
Return JSON success

Validation:

* Required nama
* Max length 100

After submit:

* Clear form
* Auto fetch guestbook
* Scroll to guestbook

────────────────────────

6.7 Guestbook Section

Fetch:
GET /api/guests

Render:
Last 10 entries

Format:
Nama
Status hadir
Pesan
Tanggal

No pagination UI (infinite load optional).

────────────────────────
7. PERFORMANCE OPTIMIZATION
────────────────────────

Critical constraints:
Total page size < 2MB
JS total < 300KB

Strategies:

* Minify JS
* Defer JS loading
* Lazy load images
* Compress audio to 128kbps (max 1.5MB)
* Gzip enabled in Nginx
* Cache static assets 30 days

Three.js render loop dihentikan ketika:
document.visibilityState !== 'visible'
atau
hero section out of viewport

────────────────────────
8. SECURITY MEASURES
────────────────────────

* CSRF protection default Laravel
* Rate limit RSVP (throttle 10/minute)
* Basic sanitization input
* Escape output Blade {{ }}

────────────────────────
9. SERVER CONFIGURATION
────────────────────────

Nginx server block:

server_name ibrahim.sabira-iibs.id;

root /var/www/ibrahim/public;

index index.php;

Enable:
gzip on;
gzip_types text/css application/javascript application/json;

SSL:
certbot --nginx -d ibrahim.sabira-iibs.id

────────────────────────
10. TESTING CHECKLIST
────────────────────────

Functional:

* RSVP insert DB
* Guestbook tampil
* Countdown akurat
* Copy rekening bekerja

Performance:

* Page load < 3 detik 4G
* FPS stabil

Device Test:

* Android RAM 2GB
* Chrome mobile
* Safari iOS