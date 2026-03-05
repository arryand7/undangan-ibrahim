@extends('layout')

@section('content')

    {{-- Cover Section --}}
    @include('sections.hero')

    {{-- Main Content (hidden until "Buka Undangan") --}}
    <main id="mainContent" class="main-content">
        @include('sections.opening')
        @include('sections.couple')
        @include('sections.events')
        @include('sections.gift')
        @include('sections.rsvp')
        @include('sections.guestbook')

        {{-- Closing Section --}}
        <div class="leaf-separator flip">
            <img src="{{ asset('images/leaf-3.png') }}" alt="">
        </div>

        <section class="closing-section" data-aos="zoom-in">
            <div class="container">
                <p class="closing-message">
                    Atas kehadiran saudara/(i) & do'a restunya, kami ucapkan terimakasih
                </p>
                <p class="closing-thanks">Hormat Kami</p>
                <p class="closing-names">Ibrahim & Dewi</p>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="section footer-section">
            <div class="container">
                <p class="footer-text">Made with ❤️ for Ibrahim & Dewi</p>
                <p class="footer-sub">26 Maret 2026</p>
            </div>
        </footer>
    </main>

@endsection
