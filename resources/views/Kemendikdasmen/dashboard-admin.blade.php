<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Pilih Jalanmu Admin - National Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "tertiary": "#5d3100",
                    "on-tertiary-fixed": "#2e1500",
                    "surface-container-low": "#f2f4f6",
                    "on-secondary": "#ffffff",
                    "surface-tint": "#1b60a2",
                    "on-error-container": "#93000a",
                    "inverse-on-surface": "#eff1f3",
                    "surface-variant": "#e0e3e5",
                    "error": "#ba1a1a",
                    "secondary-container": "#7ef7e5",
                    "primary-fixed-dim": "#a2c9ff",
                    "on-secondary-fixed": "#00201c",
                    "on-secondary-container": "#007166",
                    "on-surface": "#191c1e",
                    "surface-container": "#eceef0",
                    "inverse-surface": "#2d3133",
                    "surface": "#f7f9fb",
                    "on-primary-fixed-variant": "#004881",
                    "on-primary": "#ffffff",
                    "on-error": "#ffffff",
                    "inverse-primary": "#a2c9ff",
                    "tertiary-fixed": "#ffdcc2",
                    "on-tertiary-container": "#ffb87c",
                    "outline": "#727781",
                    "on-primary-fixed": "#001c38",
                    "primary": "#003e6f",
                    "on-tertiary": "#ffffff",
                    "primary-fixed": "#d3e4ff",
                    "surface-container-high": "#e6e8ea",
                    "secondary": "#006a60",
                    "outline-variant": "#c1c7d2",
                    "on-surface-variant": "#414750",
                    "error-container": "#ffdad6",
                    "tertiary-container": "#7f4400",
                    "tertiary-fixed-dim": "#ffb77a",
                    "surface-container-highest": "#e0e3e5",
                    "on-background": "#191c1e",
                    "on-secondary-fixed-variant": "#005048",
                    "primary-container": "#005596",
                    "surface-bright": "#f7f9fb",
                    "background": "#f7f9fb",
                    "surface-container-lowest": "#ffffff",
                    "on-tertiary-fixed-variant": "#6d3a00",
                    "on-primary-container": "#a4caff",
                    "surface-dim": "#d8dadc",
                    "secondary-fixed": "#7ef7e5",
                    "secondary-fixed-dim": "#5fdac9"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "spacing": {
                    "stack-md": "1rem",
                    "stack-lg": "1.5rem",
                    "stack-sm": "0.5rem",
                    "gutter": "1rem",
                    "container-margin": "1.25rem"
            },
            "fontFamily": {
                    "display-lg": ["Inter"],
                    "headline-md": ["Inter"],
                    "body-sm": ["Inter"],
                    "title-lg": ["Inter"],
                    "label-bold": ["Inter"],
                    "headline-md-mobile": ["Inter"],
                    "body-base": ["Inter"]
            },
            "fontSize": {
                    "display-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                    "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                    "title-lg": ["18px", {"lineHeight": "24px", "fontWeight": "600"}],
                    "label-bold": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "700"}],
                    "headline-md-mobile": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                    "body-base": ["16px", {"lineHeight": "24px", "fontWeight": "400"}]
            }
          },
        },
      }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7f9fb;
        }
    </style>
</head>
<body class="flex overflow-hidden h-screen m-0 p-0">

<aside class="h-screen w-64 fixed left-0 top-0 bg-surface-container-low flex flex-col p-stack-md gap-stack-sm z-50 border-r border-outline-variant">
    <div class="flex items-center gap-3 px-2 mb-8">
        <span class="material-symbols-outlined text-primary text-3xl" style="font-variation-settings: 'FILL' 1;">admin_panel_settings</span>
        <div class="flex flex-col">
            <span class="font-headline-md text-headline-md text-primary leading-tight">Admin Central</span>
            <span class="font-label-bold text-[10px] text-on-surface-variant uppercase tracking-wider">Super User Access</span>
        </div>
    </div>
    
    <nav class="flex-1 space-y-1">
        <a class="bg-secondary-container text-on-secondary-container rounded-lg font-bold flex items-center px-4 py-3 transition-all duration-200" href="{{ route('kemendikdasmen.dashboard') }}">
            <span class="material-symbols-outlined mr-3">dashboard</span>
            <span class="font-label-bold text-label-bold">Dashboard</span>
        </a>
        <a class="text-on-surface-variant hover:bg-surface-variant rounded-lg flex items-center px-4 py-3 transition-all duration-200" href="{{ route('kemendikdasmen.users') }}">
            <span class="material-symbols-outlined mr-3">group</span>
            <span class="font-label-bold text-label-bold">User Management</span>
        </a>
        <a class="text-on-surface-variant hover:bg-outline-variant/30 rounded-lg flex items-center px-4 py-3 transition text-xs font-bold" 
        href="{{ route('kemendikdasmen.questions') }}">
        <span class="material-symbols-outlined mr-3">quiz</span>Manajemen Soal
        </a>

        <a class="text-on-surface-variant hover:bg-surface-variant rounded-lg flex items-center px-4 py-3 transition-all duration-200" href="{{ route('kemendikdasmen.settings') }}">
            <span class="material-symbols-outlined mr-3">settings</span>
            <span class="font-label-bold text-label-bold">System Settings</span>
        </a>
        <a class="text-on-surface-variant hover:bg-surface-variant rounded-lg flex items-center px-4 py-3 transition-all duration-200" href="{{ route('kemendikdasmen.broadcast') }}">
            <span class="material-symbols-outlined mr-3">campaign</span>
            <span class="font-label-bold text-label-bold">Broadcast Center</span>
        </a>
    </nav>


    <div class="pt-4 border-t border-outline-variant">
        <form action="{{ route('kemendikdasmen.logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full text-red-600 hover:bg-red-50 rounded-lg flex items-center px-4 py-3 transition-all duration-200 font-bold">
                <span class="material-symbols-outlined mr-3">logout</span>
                <span class="font-label-bold text-label-bold">Keluar</span>
            </button>
        </form>
        <div class="text-center mt-4 text-[10px] text-on-surface-variant">
        </div>
    </div>
</aside>

<main class="flex-1 pl-64 h-screen overflow-y-auto">
    <div class="p-8 space-y-8 max-w-[1400px] mx-auto">
        
        <header class="flex justify-between items-center">
            <div>
                <h1 class="font-display-lg text-display-lg text-primary leading-tight">Pilih Jalanmu Admin</h1>
                <p class="font-label-bold text-xs text-on-surface-variant uppercase tracking-wider mt-1">National Administration Oversight</p>
            </div>
            
            <div class="flex items-center gap-3 bg-surface-container-lowest px-4 py-2 rounded-xl border border-outline-variant shadow-sm">
                <div class="text-right">
                    <h4 class="font-label-bold text-xs text-on-surface">Administrator Utama</h4>
                    <span class="text-[11px] font-medium text-on-surface-variant block">Pusdatin Jakarta</span>
                </div>
                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-primary to-primary-container flex items-center justify-center text-white text-xs font-bold shadow-sm">
                    AU
                </div>
            </div>
        </header>

        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant shadow-sm flex items-center justify-between">
                <div class="space-y-1">
                    <span class="font-label-bold text-xs text-on-surface-variant uppercase tracking-wider block">Lembaga Sekolah</span>
                    <div class="flex items-baseline gap-2">
                        <h3 class="font-display-lg text-3xl text-on-surface">{{ number_format($statSekolahTerdaftar) }}</h3>
                        <span class="text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Unit</span>
                    </div>
                    <p class="text-[11px] text-on-surface-variant">Total SMP & SMK terdaftar di sistem</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-700">
                    <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">holiday_village</span>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant shadow-sm flex items-center justify-between">
                <div class="space-y-1">
                    <span class="font-label-bold text-xs text-on-surface-variant uppercase tracking-wider block">Siswa SMP (Terdaftar)</span>
                    <div class="flex items-baseline gap-2">
                        <h3 class="font-display-lg text-3xl text-on-surface">{{ number_format($statSiswaSmpTerdaftar) }}</h3>
                        <span class="text-[11px] font-bold text-sky-600 bg-sky-50 px-2 py-0.5 rounded-full">Siswa</span>
                    </div>
                    <p class="text-[11px] text-on-surface-variant">Total pengguna jenjang sekolah pertama</p>
                </div>
                <div class="w-12 h-12 bg-primary-fixed rounded-xl flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">group</span>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant shadow-sm flex items-center justify-between">
                <div class="space-y-1">
                    <span class="font-label-bold text-xs text-on-surface-variant uppercase tracking-wider block">Siswa SMK (Terdaftar)</span>
                    <div class="flex items-baseline gap-2">
                        <h3 class="font-display-lg text-3xl text-on-surface">{{ number_format($statSiswaSmkTerdaftar) }}</h3>
                        <span class="text-[11px] font-bold text-primary-container bg-primary-fixed px-2 py-0.5 rounded-full">{{ $persentaseSmk }}% Kuota</span>
                    </div>
                    <p class="text-[11px] text-on-surface-variant">Total pengguna jenjang pendidikan vokasi</p>
                </div>
                <div class="w-12 h-12 bg-secondary-container rounded-xl flex items-center justify-center text-on-secondary-container">
                    <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">badge</span>
                </div>
            </div>
            
        </section>

        <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant shadow-sm min-h-[380px] flex flex-col justify-between">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="font-headline-md text-sm text-on-surface">Peta Sebaran Minat (RIASEC Trends)</h3>
                        <p class="text-[11px] text-on-surface-variant">Grafik tren tipe kepribadian karier dominan skala nasional</p>
                    </div>
                    <div class="flex gap-1 bg-surface-container p-1 rounded-lg text-xs font-semibold">
                        <button class="px-3 py-1 bg-surface-container-lowest rounded-md text-on-surface shadow-sm">Realtime</button>
                    </div>
                </div>
                
                <div class="flex items-end justify-between h-48 px-6 pb-2 border-b border-outline-variant">
                    <div class="flex flex-col items-center w-12 gap-2 h-full justify-end">
                        <div class="w-8 bg-primary rounded-t-lg h-[60%] flex items-end justify-center pb-2 text-[11px] text-white font-bold shadow-sm">60%</div>
                        <span class="text-xs font-bold text-primary">R</span>
                    </div>
                    <div class="flex flex-col items-center w-12 gap-2 h-full justify-end">
                        <div class="w-8 bg-primary-container rounded-t-lg h-[75%] flex items-end justify-center pb-2 text-[11px] text-white font-bold shadow-sm">75%</div>
                        <span class="text-xs font-bold text-primary-container">I</span>
                    </div>
                    <div class="flex flex-col items-center w-12 gap-2 h-full justify-end">
                        <div class="w-8 bg-secondary rounded-t-lg h-[95%] flex items-end justify-center pb-2 text-[11px] text-white font-bold shadow-sm">95%</div>
                        <span class="text-xs font-bold text-secondary">A</span>
                    </div>
                    <div class="flex flex-col items-center w-12 gap-2 h-full justify-end">
                        <div class="w-8 bg-secondary-fixed-dim rounded-t-lg h-[65%] flex items-end justify-center pb-2 text-[11px] text-on-surface font-bold shadow-sm">65%</div>
                        <span class="text-xs font-bold text-on-secondary-container">S</span>
                    </div>
                    <div class="flex flex-col items-center w-12 gap-2 h-full justify-end">
                        <div class="w-8 bg-blue-700 rounded-t-lg h-[85%] flex items-end justify-center pb-2 text-[11px] text-white font-bold shadow-sm">85%</div>
                        <span class="text-xs font-bold text-blue-700">E</span>
                    </div>
                    <div class="flex flex-col items-center w-12 gap-2 h-full justify-end">
                        <div class="w-8 bg-outline rounded-t-lg h-[50%] flex items-end justify-center pb-2 text-[11px] text-white font-bold shadow-sm">50%</div>
                        <span class="text-xs font-bold text-outline">C</span>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-2 text-[11px] text-on-surface-variant pt-4">
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-primary block"></span><strong>R</strong>ealistic</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-secondary block"></span><strong>A</strong>rtistic</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-blue-700 block"></span><strong>E</strong>nterprising</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-primary-container block"></span><strong>I</strong>nvestigative</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-secondary-fixed-dim block"></span><strong>S</strong>ocial</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-outline block"></span><strong>C</strong>onventional</span>
                </div>
            </div>

            <div class="bg-primary text-white p-6 rounded-2xl shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="font-headline-md text-sm">Quick Actions</h3>
                    <p class="font-body-sm text-xs text-primary-fixed opacity-80 mt-1">Kelola operasional sistem pusat kontrol.</p>
                    
                    <div class="mt-6 space-y-3">
                        <div class="bg-white/10 p-3 rounded-xl flex items-center gap-3 border border-white/5">
                            <span class="material-symbols-outlined text-primary-fixed">quiz</span>
                            <div>
                                <h4 class="text-xs font-bold">Bank Soal Kuesioner</h4>
                                <span class="text-[10px] text-primary-fixed opacity-70">1,402 Butir Aktif</span>
                            </div>
                        </div>
                        <div class="bg-white/10 p-3 rounded-xl flex items-center gap-3 border border-white/5">
                            <span class="material-symbols-outlined text-primary-fixed">sync</span>
                            <div>
                                <h4 class="text-xs font-bold">Sinkronisasi Dapodik</h4>
                                <span class="text-[10px] text-primary-fixed opacity-70">Terakhir: 2 Menit lalu</span>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="w-full py-3 bg-primary-container hover:bg-opacity-90 font-bold rounded-xl text-xs transition mt-6 tracking-wide uppercase">
                    Buka Konfigurasi
                </button>
            </div>
            
        </section>

        <section class="bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="font-headline-md text-base text-on-surface">Leaderboard Partisipasi Wilayah</h3>
                    <p class="text-xs text-on-surface-variant">Tabel peringkat provinsi dengan tingkat penyelesaian (Completion Rate) tes tertinggi secara nasional</p>
                </div>
                <button class="px-4 py-2 border border-outline-variant hover:bg-surface text-xs font-bold rounded-xl text-on-surface flex items-center gap-2 transition">
                    <span class="material-symbols-outlined text-sm">download</span> Unduh Laporan PDF
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-outline-variant text-[11px] font-bold text-on-surface-variant uppercase bg-surface-container-low">
                            <th class="p-4 rounded-l-xl">Peringkat</th>
                            <th class="p-4">Nama Provinsi</th>
                            <th class="p-4 text-center">Sekolah Aktif</th>
                            <th class="p-4 text-center">Siswa Mengisi</th>
                            <th class="p-4 text-right rounded-r-xl">Tingkat Penyelesaian</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs divide-y divide-outline-variant/30">
                        @foreach($leaderboardWilayah as $index => $wilayah)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="p-4 font-bold text-on-surface">
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full {{ $index < 3 ? 'bg-primary-fixed text-primary' : 'bg-surface-container text-on-surface-variant' }}">
                                    {{ $index + 1 }}
                                </span>
                            </td>
                            <td class="p-4 font-semibold text-on-surface">{{ $wilayah['provinsi'] }}</td>
                            <td class="p-4 text-center text-on-surface-variant">{{ $wilayah['sekolah'] }}</td>
                            <td class="p-4 text-center text-on-surface-variant">{{ $wilayah['siswa'] }}</td>
                            <td class="p-4 text-right font-bold">
                                <span class="text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md">
                                    {{ $wilayah['completion'] }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</main>

</body>
</html>