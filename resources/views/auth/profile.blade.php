<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profil Akun — Pencatatan Tamu</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="att-body">
    <header class="att-header">
        <div class="att-header-inner">
            <span class="att-header-title font-title">Dewi & Ibrahim</span>
            <div class="att-header-right">
                <a href="{{ route('attendance.index') }}" class="att-profile-btn" title="Kembali">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5"/>
                        <path d="M12 19l-7-7 7-7"/>
                    </svg>
                </a>
                <span class="att-user-name">{{ $user->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="att-logout-form">
                    @csrf
                    <button type="submit" class="att-logout-btn" title="Logout">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="att-main">
        @if(session('success'))
            <div class="att-alert att-alert-success">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="att-alert att-alert-error">
                <ul class="att-error-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="att-form-card att-profile-wrap">
            <h2 class="att-form-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 21a8 8 0 0 1 16 0"/>
                </svg>
                Update Profil
            </h2>

            <p class="att-profile-desc">Ubah nama, user (email), dan password akun Anda.</p>

            <form method="POST" action="{{ route('profile.update') }}" class="att-form">
                @csrf
                @method('PUT')

                <div class="att-field">
                    <label for="name" class="att-label">Nama <span class="att-required">*</span></label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="att-input"
                        value="{{ old('name', $user->name) }}"
                        maxlength="255"
                        required
                    >
                </div>

                <div class="att-field">
                    <label for="email" class="att-label">User (Email) <span class="att-required">*</span></label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="att-input"
                        value="{{ old('email', $user->email) }}"
                        maxlength="255"
                        required
                    >
                </div>

                <div class="att-field">
                    <label for="current_password" class="att-label">Password Saat Ini</label>
                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        class="att-input"
                        autocomplete="current-password"
                    >
                    <small class="att-field-hint">Wajib diisi jika ingin mengganti password.</small>
                </div>

                <div class="att-field">
                    <label for="password" class="att-label">Password Baru</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="att-input"
                        autocomplete="new-password"
                    >
                    <small class="att-field-hint">Minimal 8 karakter, kombinasi huruf dan angka.</small>
                </div>

                <div class="att-field">
                    <label for="password_confirmation" class="att-label">Konfirmasi Password Baru</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="att-input"
                        autocomplete="new-password"
                    >
                </div>

                <div class="att-profile-actions">
                    <a href="{{ route('attendance.index') }}" class="att-cancel-btn">Batal</a>
                    <button type="submit" class="att-submit-btn">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
