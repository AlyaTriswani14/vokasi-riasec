<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Admin Login - Kemendikdasmen RI</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "inverse-surface": "#2d3133",
                    "surface-dim": "#d8dadc",
                    "on-error": "#ffffff",
                    "on-secondary": "#ffffff",
                    "secondary-fixed-dim": "#5fdac9",
                    "error": "#ba1a1a",
                    "surface": "#f7f9fb",
                    "on-secondary-fixed": "#00201c",
                    "on-primary-fixed-variant": "#004881",
                    "on-primary": "#ffffff",
                    "secondary-fixed": "#7ef7e5",
                    "background": "#f7f9fb",
                    "primary": "#002060", 
                    "on-tertiary-container": "#ffb87c",
                    "surface-container-high": "#e6e8ea",
                    "outline": "#727781",
                    "tertiary-container": "#7f4400",
                    "on-tertiary-fixed-variant": "#6d3a00",
                    "error-container": "#ffdad6",
                    "secondary-container": "#7ef7e5",
                    "on-tertiary-fixed": "#2e1500",
                    "on-background": "#191c1e",
                    "on-primary-fixed": "#001c38",
                    "on-tertiary": "#ffffff",
                    "primary-fixed-dim": "#a2c9ff",
                    "on-secondary-container": "#007166",
                    "on-primary-container": "#a4caff",
                    "tertiary": "#5d3100",
                    "surface-bright": "#f7f9fb",
                    "secondary": "#006a60",
                    "inverse-on-surface": "#eff1f3",
                    "outline-variant": "#c1c7d2",
                    "surface-container-low": "#f2f4f6",
                    "primary-container": "#004b87", 
                    "surface-container-lowest": "#ffffff",
                    "on-secondary-fixed-variant": "#005048",
                    "primary-fixed": "#d3e4ff",
                    "on-surface-variant": "#414750",
                    "tertiary-fixed-dim": "#ffb77a",
                    "on-surface": "#191c1e",
                    "surface-tint": "#1b60a2",
                    "tertiary-fixed": "#ffdcc2",
                    "on-error-container": "#93000a",
                    "surface-container": "#eceef0",
                    "surface-variant": "#e0e3e5",
                    "surface-container-highest": "#e0e3e5",
                    "inverse-primary": "#a2c9ff"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "spacing": {
                    "stack-sm": "0.5rem",
                    "stack-lg": "1.5rem",
                    "container-margin": "1.25rem",
                    "stack-md": "1rem",
                    "gutter": "1rem"
            },
            "fontFamily": {
                    "label-bold": ["Inter"],
                    "body-sm": ["Inter"],
                    "headline-md": ["Inter"],
                    "title-lg": ["Inter"],
                    "display-lg": ["Inter"],
                    "body-base": ["Inter"]
            },
            "fontSize": {
                    "label-bold": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "700"}],
                    "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                    "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                    "title-lg": ["18px", {"lineHeight": "24px", "fontWeight": "600"}],
                    "display-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "body-base": ["16px", {"lineHeight": "24px", "fontWeight": "400"}]
            }
          },
        },
      }
    </script>
    <style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-white text-on-surface font-body-base min-h-screen m-0 p-0 overflow-x-hidden">

<main class="w-screen min-h-screen grid grid-cols-1 lg:grid-cols-2 bg-surface-container-lowest overflow-hidden">
    
    <div class="relative hidden lg:flex flex-col justify-between p-12 bg-primary overflow-hidden">
        <div class="relative z-10 w-full">
            <div class="absolute -top-12 -left-12 bg-white px-8 py-5 rounded-br-3xl shadow-md border-r border-b border-white/10">
                <img src="{{ asset('images/logo_ditjen_vokasi.png') }}" alt="Kemendikdasmen RI" class="h-20 w-auto object-contain">
            </div>
            
            <div class="mt-36">
                <h2 class="text-white font-display-lg text-display-lg leading-tight mb-6">
                    Pusat Kendali <br>Sistem Informasi <br> Bakat Peserta Didik SMK
                </h2>
                <p class="text-slate-300 font-body-base text-body-base max-w-md opacity-90">
                    Platform integrasi data nasional untuk pengelolaan minat bakat yang telah dilakukan oleh peserta didik dalam mengetahui kemampuan murid berdasarkan metode RIASEC.
                </p>
            </div>
        </div>
        
        <div class="relative z-10 flex items-center gap-6 mt-auto">
            <div class="flex flex-col opacity-60">
                <span class="text-white/70 font-label-bold text-label-bold uppercase">ADMINISTRASI PUSAT</span>
                <span class="text-white/60 font-body-sm text-body-sm">Kompleks Kemendikdasmen, Jl. Jenderal Sudirman, Senayan, Jakarta, 10270, Indonesia</span>
            </div>
        </div>
    </div>

    <div class="flex flex-col justify-center items-center p-8 md:p-16 bg-white min-h-screen">
        <div class="w-full max-w-md">
            
            <div class="lg:hidden flex flex-col items-center mb-10">
                <img class="h-20 w-auto object-contain mb-4" src="{{ asset('images/logo_ditjen_vokasi.png') }}" alt="Logo Kemendikdasmen RI">
                <h1 class="font-headline-md text-headline-md text-primary">Kemendikdasmen RI</h1>
            </div>
            
            <header class="mb-10 text-center lg:text-left">
                <h2 class="font-display-lg text-display-lg text-primary mb-2">Admin Login</h2>
                <p class="text-on-surface-variant font-body-base text-body-base">
                    Silakan masuk untuk mengakses panel administrasi pusat.
                </p>
            </header>
            
            <form action="{{ route('kemendikdasmen.login') }}" method="POST" class="space-y-6">
                @csrf
                
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm mb-4">
                        {{ $errors->first() }}
                    </div>
                @endif
                
                <div class="space-y-2">
                    <label class="block font-label-bold text-label-bold text-on-surface-variant uppercase" for="email">NIP / EMAIL</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">person</span>
                        <input name="email" required class="w-full h-14 pl-12 pr-4 bg-surface border border-outline-variant rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all font-body-base outline-none text-on-surface" id="email" placeholder="Masukkan NIP atau Email Resmi" type="text" value="{{ old('email') }}">
                    </div>
                </div>
                
                <div class="space-y-2">
                    <div class="flex justify-between items-end">
                        <label class="block font-label-bold text-label-bold text-on-surface-variant uppercase" for="password">PASSWORD</label>
                        <a class="text-primary font-label-bold text-label-bold hover:underline" href="#">Lupa Kata Sandi?</a>
                    </div>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">lock</span>
                        <input name="password" required class="w-full h-14 pl-12 pr-12 bg-surface border border-outline-variant rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all font-body-base outline-none text-on-surface" id="password" placeholder="••••••••" type="password">
                        <button class="absolute right-4 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface transition-colors" onclick="togglePassword()" type="button">
                            <span class="material-symbols-outlined" id="visibility-icon">visibility</span>
                        </button>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 py-2">
                    <input class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary" id="remember" type="checkbox" name="remember">
                    <label class="font-body-sm text-body-sm text-on-surface-variant cursor-pointer" for="remember">Tetap masuk di perangkat ini</label>
                </div>
                
                <button class="w-full h-14 bg-primary-container text-white font-title-lg text-title-lg rounded-lg hover:bg-primary transition-all transform active:scale-[0.98] shadow-md flex items-center justify-center gap-3" type="submit">
                    Masuk ke Panel Admin
                    <span class="material-symbols-outlined">login</span>
                </button>
            </form>
            
            <footer class="mt-12 pt-8 border-t border-outline-variant flex flex-col sm:flex-row items-center justify-between gap-4 text-on-surface-variant font-body-sm text-body-sm">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">verified_user</span>
                    <span class="">Koneksi Terenkripsi</span>
                </div>
            </footer>
        </div>
    </div>
</main>

<script>
        // Fungsi Sembunyikan/Tampilkan Password
        function togglePassword() {
            const pwd = document.getElementById('password');
            const icon = document.getElementById('visibility-icon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.innerText = 'visibility_off';
            } else {
                pwd.type = 'password';
                icon.innerText = 'visibility';
            }
        }

        // Efek loading animasi tombol saat disubmit
        const form = document.querySelector('form');
        const btn = document.querySelector('button[type="submit"]');
        
        form.addEventListener('submit', function() {
            btn.disabled = true;
            btn.innerHTML = '<span class="material-symbols-outlined animate-spin">progress_activity</span> Memproses...';
        });
    </script>

</body>
</html>