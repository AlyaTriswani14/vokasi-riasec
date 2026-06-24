<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pilih Jalanmu - Buat Akun Guru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8FAFC;
        }
        .form-shadow {
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between py-6 px-4 md:px-8">
    
    <!-- Wrapper to center content vertically on desktop -->
    <div class="flex-grow flex items-center justify-center w-full">
        <!-- Main Card (Responsive width: mobile-optimized max-w-md, desktop max-w-5xl) -->
        <div class="w-full max-w-[430px] md:max-w-[1000px] bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden p-6 md:p-10 form-shadow transition-all duration-300">
            
            <!-- Header / Logo -->
            <header class="flex items-center gap-3 mb-6 md:mb-8 pb-4 border-b border-gray-100">
                <!-- Graduation Cap SVG Icon -->
                <svg class="w-8 h-8 text-[#003E70]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14v7" />
                </svg>
                <h1 class="text-xl md:text-2xl font-bold text-[#003E70]">Portal Guru</h1>
            </header>

            <!-- Responsive Grid (1 column on mobile, 2 columns on desktop) -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-10 items-start">
                
                <!-- Left Side: Banner & Greeting Card (md:col-span-5) -->
                <div class="md:col-span-5 flex flex-col gap-6">
                    <!-- Banner Card -->
                    <div class="relative w-full h-[180px] md:h-[240px] rounded-2xl overflow-hidden group">
                        <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=800&q=80" alt="Ilustrasi Guru" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                        <!-- Overlay Text -->
                        <div class="absolute bottom-4 left-4 right-4">
                            <h2 class="text-white text-xl md:text-2xl font-bold tracking-wide">Dampingi Langkah Mereka!</h2>
                        </div>
                    </div>

                    <!-- Greeting Card (Halo, Bapak/Ibu Guru) -->
                    <div class="bg-[#E6FFFA] rounded-2xl p-5 border border-[#B2F5EA] flex gap-3">
                        <div class="flex-shrink-0 mt-0.5">
                            <!-- Sparkle SVG Icon -->
                            <svg class="w-6 h-6 text-[#00A389]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 21L8.188 15.904L3 15L8.188 14.096L9 9L9.813 14.096L15 15L9.813 15.904Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.071 4.929L18.5 7.5L17.929 4.929L15.5 4.357L17.929 3.786L18.5 1.214L19.071 3.786L21.5 4.357L19.071 4.929Z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-[#007A66] font-bold text-base mb-1">Halo, Bapak/Ibu Guru!</h3>
                            <p class="text-[#007A66] text-xs md:text-sm leading-relaxed">
                                Mari bergabung untuk memantau dan mendampingi hasil pemetaan minat serta bakat siswa-siswi di sekolah Anda.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Form (md:col-span-7) -->
                <div class="md:col-span-7">
                    <!-- Registration Form -->
                    <form action="{{ url('/register') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <!-- Penanda Role Guru -->
                        <input type="hidden" name="role" value="guru">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- NAMA LENGKAP -->
                            <div class="space-y-1.5">
                                <label for="name" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Lengkap & Gelar</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                                        <!-- User SVG Icon -->
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </span>
                                    <input type="text" id="name" name="name" placeholder="Contoh: Budi Santoso, S.Pd." value="{{ old('name') }}" required
                                        class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent text-sm transition">
                                </div>
                                @error('name')
                                    <p class="text-[11px] text-red-500 mt-0.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NIP / NUPTK -->
                            <div class="space-y-1.5">
                                <label for="nip" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">NIP / NUPTK</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                                        <!-- ID Card SVG Icon -->
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 014 0m-6 8a2 2 0 100-4 2 2 0 000 4zm7-2.5h3m-3 2.5h3"></path>
                                        </svg>
                                    </span>
                                    <input type="text" id="nip" name="nip" placeholder="Masukkan NIP atau NUPTK" value="{{ old('nip') }}" required
                                        class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent text-sm transition">
                                </div>
                                <p class="text-[10px] text-gray-400 italic">Isi dengan NUPTK jika tidak memiliki NIP.</p>
                                @error('nip')
                                    <p class="text-[11px] text-red-500 mt-0.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- ASAL SEKOLAH -->
                            <div class="space-y-1.5">
                                <label for="asal_sekolah" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Tempat Mengajar</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                                        <!-- School/Building SVG Icon -->
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </span>
                                    <input type="text" id="asal_sekolah" name="asal_sekolah" placeholder="Contoh: SMP Negeri 1 Jakarta" value="{{ old('asal_sekolah') }}" required
                                        class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent text-sm transition">
                                </div>
                                @error('asal_sekolah')
                                    <p class="text-[11px] text-red-500 mt-0.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NPSN -->
                            <div class="space-y-1.5">
                                <label for="npsn" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">NPSN</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                                        <!-- School/Building SVG Icon -->
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </span>
                                    <input type="text" id="npsn" name="npsn" placeholder="Contoh: 10101234" value="{{ old('npsn') }}" maxlength="8" required
                                        class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent text-sm transition">
                                </div>
                                <p class="text-[10px] text-gray-400 italic">8 Digit Nomor Pokok Sekolah Nasional.</p>
                                @error('npsn')
                                    <p class="text-[11px] text-red-500 mt-0.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- EMAIL AKTIF -->
                            <div class="space-y-1.5 sm:col-span-2">
                                <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Email Aktif</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                                        <!-- Envelope/Mail SVG Icon -->
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </span>
                                    <input type="email" id="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}" required
                                        class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent text-sm transition">
                                </div>
                                @error('email')
                                    <p class="text-[11px] text-red-500 mt-0.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- KATA SANDI -->
                            <div class="space-y-1.5">
                                <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Kata Sandi</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                                        <!-- Lock SVG Icon -->
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </span>
                                    <input type="password" id="password" name="password" placeholder="Minimal 8 Karakter" required
                                        class="w-full pl-11 pr-11 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent text-sm transition">
                                    <!-- Eye Toggle Button -->
                                    <button type="button" onclick="togglePasswordVisibility('password', this)" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-gray-600 focus:outline-none">
                                        <svg class="w-5 h-5 show-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <svg class="w-5 h-5 hide-icon hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="text-[11px] text-red-500 mt-0.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- ULANGI KATA SANDI -->
                            <div class="space-y-1.5">
                                <label for="password_confirmation" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Ulangi Kata Sandi</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                                        <!-- Lock SVG Icon -->
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </span>
                                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi Kata Sandi" required
                                        class="w-full pl-11 pr-11 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent text-sm transition">
                                    <!-- Eye Toggle Button -->
                                    <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-gray-600 focus:outline-none">
                                        <svg class="w-5 h-5 show-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <svg class="w-5 h-5 hide-icon hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Buat Akun Button -->
                        <button type="submit"
                            class="w-full bg-[#003E70] hover:bg-[#002B4E] text-white py-3.5 px-6 rounded-full font-bold text-base flex items-center justify-center gap-2 shadow-lg shadow-blue-900/10 hover:shadow-blue-900/20 active:scale-[0.98] transition duration-200 mt-6">
                            Buat Akun Guru
                            <!-- Right Arrow SVG Icon -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </form>

                    <!-- Login Redirect Link -->
                    <div class="mt-6 text-center space-y-1 pb-2">
                        <p class="text-xs text-gray-500">Sudah punya akun sebelumnya?</p>
                        <a href="{{ route('login') }}" class="block text-xs font-bold text-[#008073] hover:text-[#005c52] tracking-wider transition">
                            MASUK KE AKUN LOGIN
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Footer (Managed By) -->
    <footer class="mt-8 pt-4 pb-2 flex flex-col items-center w-full max-w-[1000px] mx-auto">
        <!-- Line divider -->
        <div class="relative w-full flex items-center justify-center mb-2">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <span class="relative px-3 bg-[#F8FAFC] text-[10px] text-gray-400 font-medium uppercase tracking-wider">
                Dikelola Oleh
            </span>
        </div>
        <!-- Kemendikbud text -->
        <p class="text-xs md:text-sm font-bold text-[#003E70] text-center tracking-wide">
            Kemendikdasmen Republik Indonesia
        </p>
    </footer>

    <!-- Password visibility toggle script -->
    <script>
        function togglePasswordVisibility(inputId, button) {
            const input = document.getElementById(inputId);
            const showIcon = button.querySelector('.show-icon');
            const hideIcon = button.querySelector('.hide-icon');

            if (input.type === 'password') {
                input.type = 'text';
                showIcon.classList.add('hidden');
                hideIcon.classList.remove('hidden');
            } else {
                input.type = 'password';
                showIcon.classList.remove('hidden');
                hideIcon.classList.add('hidden');
            }
        }
    </script>
</body>
</html>