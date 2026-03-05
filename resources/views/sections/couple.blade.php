{{-- Quote & Couple Profile Section --}}

{{-- Ayat Al-Quran --}}
<section class="quote-section" data-aos="fade-up">
    <div class="container">
        <p class="quote-text">
            وَمِنْ كُلِّ شَيْءٍ خَلَقْنَا زَوْجَيْنِ لَعَلَّكُمْ تَذَكَّرُوْنَ
            <br><br>
            Dan segala sesuatu Kami ciptakan berpasang-pasangan supaya kamu mengingat kebesaran Allah.
        </p>
        <p class="quote-source">Adz Dzariyyat: 49</p>
    </div>
</section>

{{-- Leaf separator --}}
<div class="leaf-separator">
    <img src="{{ asset('images/leaf-3.png') }}" alt="">
</div>

{{-- Couple Section --}}
<section id="couple" class="section couple-section">
    <div class="container">
        <p class="couple-opening animate-on-scroll">Kami mohon do'a & restunya atas pernikahan kami</p>

        <div class="couple-card-container">
            {{-- Groom --}}
            <div data-aos="fade-up">
                <div class="couple-photo-wrapper">
                    <img src="{{ asset('images/ibrahim-portrait.jpeg') }}" alt="Ibrahim Hasan Mauludi" class="couple-photo" loading="lazy">
                </div>
                <h3 class="couple-name">Ibrahim Hasan Mauludi</h3>
                <p class="couple-info">Putra dari</p>
                <p class="couple-parents">Bapak Drs. Eko Purwono & Ibu Winarni Luciana</p>
            </div>

            {{-- Ampersand --}}
            <div class="couple-amp" data-aos="fade-up">&</div>

            {{-- Bride --}}
            <div data-aos="fade-up">
                <div class="couple-photo-wrapper">
                    <img src="{{ asset('images/dewi-portrait.jpeg') }}" alt="Dewi Sri Mulyani" class="couple-photo" loading="lazy">
                </div>
                <h3 class="couple-name">Dewi Sri Mulyani</h3>
                <p class="couple-info">Putri dari</p>
                <p class="couple-parents">Bapak (Alm) Acep Saripudin & Ibu Rohanah</p>
            </div>
        </div>
    </div>
</section>
