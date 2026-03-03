@extends('layout')

@section('content')

    {{-- Hero Section (Three.js) --}}
    @include('sections.hero')

    {{-- Main Content (hidden until "Buka Undangan") --}}
    <main id="mainContent" class="main-content">
        @include('sections.couple')
        @include('sections.events')
        @include('sections.countdown')
        @include('sections.gift')
        @include('sections.rsvp')
        @include('sections.guestbook')

        {{-- Footer --}}
        <footer class="section footer-section">
            <div class="container">
                <p class="footer-text">Made with ❤️ for Ibrahim & Dewi</p>
                <p class="footer-sub">26 Maret 2026</p>
            </div>
        </footer>
    </main>

@endsection
