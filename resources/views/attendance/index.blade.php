<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pencatatan Tamu — Ibrahim & Dewi</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="att-body">
    {{-- Top Bar --}}
    <header class="att-header">
        <div class="att-header-inner">
            <span class="att-header-title font-title">Dewi & Ibrahim</span>
            <div class="att-header-right">
                <span class="att-user-name">{{ auth()->user()->name }}</span>
                <a href="{{ route('profile.edit') }}" class="att-profile-btn" title="Profil">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 21a8 8 0 0 1 16 0"/>
                    </svg>
                </a>
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
        {{-- Success Message --}}
        @if(session('success'))
            <div class="att-alert att-alert-success" id="successAlert">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Summary Cards --}}
        <div class="att-summary">
            <div class="att-summary-card att-summary-total">
                <div class="att-summary-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div class="att-summary-info">
                    <span class="att-summary-value">{{ number_format($summary['total_tamu']) }}</span>
                    <span class="att-summary-label">Total Tamu</span>
                </div>
            </div>

            <div class="att-summary-card att-summary-pria">
                <div class="att-summary-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="7" r="4"/>
                        <path d="M5 21v-2a7 7 0 0 1 14 0v2"/>
                    </svg>
                </div>
                <div class="att-summary-info">
                    <span class="att-summary-value">{{ number_format($summary['pria']['total_tamu']) }}</span>
                    <span class="att-summary-label">Pihak Pria</span>
                    <span class="att-summary-nominal">Rp {{ number_format($summary['pria']['total_nominal'], 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="att-summary-card att-summary-wanita">
                <div class="att-summary-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="7" r="4"/>
                        <path d="M5 21v-2a7 7 0 0 1 14 0v2"/>
                    </svg>
                </div>
                <div class="att-summary-info">
                    <span class="att-summary-value">{{ number_format($summary['wanita']['total_tamu']) }}</span>
                    <span class="att-summary-label">Pihak Wanita</span>
                    <span class="att-summary-nominal">Rp {{ number_format($summary['wanita']['total_nominal'], 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="att-summary-card att-summary-nominal">
                <div class="att-summary-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="1" x2="12" y2="23"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>
                <div class="att-summary-info">
                    <span class="att-summary-value">Rp {{ number_format($summary['total_nominal'], 0, ',', '.') }}</span>
                    <span class="att-summary-label">Total Nominal</span>
                </div>
            </div>
        </div>

        {{-- Quick Input Form --}}
        <div class="att-form-card">
            <h2 class="att-form-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Catat Tamu Baru
            </h2>

            @if($errors->any())
                <div class="att-alert att-alert-error">
                    <ul class="att-error-list">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('attendance.store') }}" class="att-form" id="attendanceForm">
                @csrf

                <div class="att-form-grid">
                    <div class="att-field att-field-nama">
                        <label for="nama" class="att-label">Nama Tamu <span class="att-required">*</span></label>
                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            value="{{ old('nama') }}"
                            required
                            maxlength="100"
                            class="att-input"
                            placeholder="Nama lengkap tamu"
                            autofocus
                        >
                    </div>

                    <div class="att-field att-field-alamat">
                        <label for="alamat" class="att-label">Alamat</label>
                        <input
                            type="text"
                            id="alamat"
                            name="alamat"
                            value="{{ old('alamat') }}"
                            maxlength="255"
                            class="att-input"
                            placeholder="Alamat tamu (opsional)"
                        >
                    </div>

                    <div class="att-field att-field-pihak">
                        <label class="att-label">Pihak <span class="att-required">*</span></label>
                        <div class="att-radio-group">
                            <label class="att-radio-label att-radio-pria">
                                <input type="radio" name="pihak" value="pria" {{ old('pihak', 'pria') == 'pria' ? 'checked' : '' }} required>
                                <span class="att-radio-btn">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <circle cx="12" cy="7" r="4"/>
                                        <path d="M5 21v-2a7 7 0 0 1 14 0v2"/>
                                    </svg>
                                    Pria
                                </span>
                            </label>
                            <label class="att-radio-label att-radio-wanita">
                                <input type="radio" name="pihak" value="wanita" {{ old('pihak') == 'wanita' ? 'checked' : '' }}>
                                <span class="att-radio-btn">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <circle cx="12" cy="7" r="4"/>
                                        <path d="M5 21v-2a7 7 0 0 1 14 0v2"/>
                                    </svg>
                                    Wanita
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="att-field att-field-nominal">
                        <label for="nominal" class="att-label">Nominal (Rp)</label>
                        <input
                            type="text"
                            id="nominal"
                            name="nominal"
                            value="{{ old('nominal') }}"
                            class="att-input att-input-nominal"
                            placeholder="0"
                            inputmode="numeric"
                        >
                    </div>
                </div>

                <button type="submit" class="att-submit-btn" id="submitBtn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Simpan
                </button>
            </form>
        </div>

        {{-- Attendance Table --}}
        <div class="att-table-card">
            <div class="att-table-header">
                <h2 class="att-table-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    Daftar Tamu ({{ $attendances->count() }})
                </h2>

                {{-- Filter --}}
                <div class="att-filter">
                    <a href="{{ route('attendance.index') }}"
                       class="att-filter-btn {{ !request('filter_pihak') ? 'active' : '' }}">Semua</a>
                    <a href="{{ route('attendance.index', ['filter_pihak' => 'pria']) }}"
                       class="att-filter-btn {{ request('filter_pihak') == 'pria' ? 'active' : '' }}">Pria</a>
                    <a href="{{ route('attendance.index', ['filter_pihak' => 'wanita']) }}"
                       class="att-filter-btn {{ request('filter_pihak') == 'wanita' ? 'active' : '' }}">Wanita</a>
                </div>
            </div>

            @if($attendances->isEmpty())
                <div class="att-empty">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" opacity="0.4">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                    </svg>
                    <p>Belum ada tamu yang dicatat</p>
                </div>
            @else
                <div class="att-table-wrap">
                    <table class="att-table">
                        <thead>
                            <tr>
                                <th class="att-th-no">#</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Pihak</th>
                                <th class="att-th-nominal">Nominal</th>
                                <th class="att-th-action"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $index => $att)
                                <tr class="att-row">
                                    <td class="att-td-no">{{ $index + 1 }}</td>
                                    <td class="att-td-nama">{{ $att->nama }}</td>
                                    <td class="att-td-alamat">{{ $att->alamat ?? '-' }}</td>
                                    <td>
                                        <span class="att-badge att-badge-{{ $att->pihak }}">
                                            {{ ucfirst($att->pihak) }}
                                        </span>
                                    </td>
                                    <td class="att-td-nominal">
                                        @if($att->nominal > 0)
                                            Rp {{ number_format($att->nominal, 0, ',', '.') }}
                                        @else
                                            <span class="att-nominal-zero">-</span>
                                        @endif
                                    </td>
                                    <td class="att-td-action">
                                        <form method="POST" action="{{ route('attendance.destroy', $att) }}"
                                              onsubmit="return confirm('Hapus data tamu {{ $att->nama }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="att-delete-btn" title="Hapus">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <polyline points="3 6 5 6 21 6"/>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </main>

    <script>
        // Auto-dismiss success alert after 3 seconds
        const successAlert = document.getElementById('successAlert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.opacity = '0';
                successAlert.style.transform = 'translateY(-10px)';
                setTimeout(() => successAlert.remove(), 300);
            }, 3000);
        }

        // Format nominal input with thousand separators
        const nominalInput = document.getElementById('nominal');
        if (nominalInput) {
            nominalInput.addEventListener('input', function (e) {
                let value = this.value.replace(/\D/g, '');
                if (value) {
                    this.value = parseInt(value).toLocaleString('id-ID');
                }
            });

            // Remove formatting before submit
            document.getElementById('attendanceForm').addEventListener('submit', function () {
                nominalInput.value = nominalInput.value.replace(/\D/g, '');
            });
        }

        // Focus nama input after page load (for quick re-entry)
        window.addEventListener('load', () => {
            const namaInput = document.getElementById('nama');
            if (namaInput && !namaInput.value) {
                namaInput.focus();
            }
        });
    </script>
</body>
</html>
