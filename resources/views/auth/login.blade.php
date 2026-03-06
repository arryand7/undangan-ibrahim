<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — Pencatatan Tamu</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="auth-body">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <span class="auth-title font-title">Dewi & Ibrahim</span>
                <span class="auth-subtitle">Pencatatan Tamu</span>
            </div>

            @if($errors->any())
                <div class="auth-alert auth-alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="auth-form">
                @csrf

                <div class="auth-field">
                    <label for="email" class="auth-label">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        class="auth-input"
                        placeholder="masukkan email"
                    >
                </div>

                <div class="auth-field">
                    <label for="password" class="auth-label">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="auth-input"
                        placeholder="masukkan password"
                    >
                </div>

                <div class="auth-remember">
                    <label class="auth-checkbox-label">
                        <input type="checkbox" name="remember" class="auth-checkbox">
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="auth-btn" id="loginButton">
                    <span>Masuk</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </button>
            </form>
        </div>

        <a href="{{ url('/') }}" class="auth-back-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Kembali ke undangan
        </a>
    </div>
</body>
</html>
