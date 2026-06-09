<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Siswa - Pilih Jalanmu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8fafc] font-sans text-gray-800 min-h-screen flex flex-col relative pb-24">

    <div class="w-full flex items-center p-4 md:px-8 bg-[#f8fafc] sticky top-0 z-50">
        <a href="{{ route('dashboard') }}" class="text-[#003366] hover:text-[#00558f] mr-4 transition-colors">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>
        <h1 class="text-[#003366] font-bold text-lg">Profil Siswa</h1>
    </div>

    @php
        // Mengambil nama dari Auth jika sudah login, jika belum pakai nama default
        $namaUser = Auth::check() ? Auth::user()->name : 'Poppy Putri Sibuea';
        $nisn = '0082341991';
        $kelas = '9-B';
    @endphp

    <main class="flex-grow w-full max-w-3xl mx-auto px-4 pt-2 pb-12 flex flex-col">

        <div class="flex flex-col items-center mt-4 mb-8">
            <div class="relative w-20 h-20 md:w-24 md:h-24 mb-3">
                <div class="w-full h-full rounded-full border-4 border-white shadow-sm overflow-hidden bg-[#e0f2fe] flex items-center justify-center text-3xl text-[#00558f]">
                    <i class="fa-solid fa-user"></i>
                </div>
                <button class="absolute bottom-0 right-0 bg-[#003366] w-7 h-7 rounded-full flex items-center justify-center border-2 border-white text-white hover:bg-[#002244] transition-colors shadow-sm">
                    <i class="fa-solid fa-pencil text-[10px]"></i>
                </button>
            </div>
            <h2 class="text-xl md:text-2xl font-extrabold text-[#003366]">{{ $namaUser }}</h2>
            <p class="text-xs md:text-sm text-gray-500 mt-1">NISN: {{ $nisn }} • Kelas {{ $kelas }}</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-[#003366] text-sm md:text-base">Hasil Tes Terakhir</h3>
                <span class="text-[10px] font-bold text-gray-800">12 Okt 2023</span>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                <div class="w-14 h-14 rounded-full bg-[#e0f2fe] text-[#00558f] flex items-center justify-center text-2xl shrink-0 hidden sm:flex">
                    <i class="fa-solid fa-head-side-gear"></i>
                </div>
                <div class="flex-grow w-full">
                    <p class="text-[11px] text-gray-500 mb-2 font-medium">Kecenderungan Minat Dominan:</p>
                    <div class="flex gap-2">
                        <div class="bg-[#003366] text-white rounded-lg px-2 py-2 flex-1 flex flex-col justify-center items-center shadow-sm">
                            <span class="text-[9px] md:text-[10px] font-medium tracking-wide mb-0.5">Realistic</span>
                            <span class="text-sm md:text-base font-bold">85%</span>
                        </div>
                        <div class="bg-[#71faca] text-[#0f766e] rounded-lg px-2 py-2 flex-1 flex flex-col justify-center items-center shadow-sm">
                            <span class="text-[9px] md:text-[10px] font-medium tracking-wide mb-0.5">Investigative</span>
                            <span class="text-sm md:text-base font-bold">72%</span>
                        </div>
                        <div class="bg-[#92400e] text-white rounded-lg px-2 py-2 flex-1 flex flex-col justify-center items-center shadow-sm">
                            <span class="text-[9px] md:text-[10px] font-medium tracking-wide mb-0.5">Artistic</span>
                            <span class="text-sm md:text-base font-bold">64%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="font-bold text-[#003366] text-sm mb-3 pl-1">Aktivitas Saya</h3>
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm mb-6 flex flex-col overflow-hidden">
            <a href="#" class="flex items-center justify-between p-4 hover:bg-gray-50 transition-colors border-b border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-[#ccfbf1] text-[#0f766e] flex items-center justify-center text-lg">
                        <i class="fa-regular fa-bookmark"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Sekolah Disimpan</h4>
                        <p class="text-xs text-gray-500">12 Sekolah Menengah</p>
                    </div>
                </div>
                <i class="fa-solid fa-chevron-right text-gray-400 text-sm"></i>
            </a>
            <a href="#" class="flex items-center justify-between p-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-[#e0f2fe] text-[#0284c7] flex items-center justify-center text-lg">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Riwayat Tes</h4>
                        <p class="text-xs text-gray-500">3 Tes Terselesaikan</p>
                    </div>
                </div>
                <i class="fa-solid fa-chevron-right text-gray-400 text-sm"></i>
            </a>
        </div>

        <h3 class="font-bold text-[#003366] text-sm mb-3 pl-1">Pengaturan Akun</h3>
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm flex flex-col overflow-hidden mb-6">
            <a href="#" class="flex items-center justify-between p-4 hover:bg-gray-50 transition-colors border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-shield-halved text-gray-400 w-6 text-center text-lg"></i>
                    <span class="font-medium text-gray-800 text-sm">Keamanan</span>
                </div>
                <i class="fa-solid fa-chevron-right text-gray-400 text-sm"></i>
            </a>
            <a href="#" class="flex items-center justify-between p-4 hover:bg-gray-50 transition-colors border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <i class="fa-regular fa-circle-question text-gray-400 w-6 text-center text-lg"></i>
                    <span class="font-medium text-gray-800 text-sm">Pusat Bantuan</span>
                </div>
                <i class="fa-solid fa-chevron-right text-gray-400 text-sm"></i>
            </a>
            <a href="#" class="flex items-center justify-between p-4 hover:bg-red-50 transition-colors">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-arrow-right-from-bracket text-red-500 w-6 text-center text-lg"></i>
                    <span class="font-bold text-red-500 text-sm">Keluar</span>
                </div>
            </a>
        </div>

    </main>

    <div class="fixed bottom-0 w-full bg-white border-t border-gray-200 flex justify-center gap-16 md:gap-32 items-center pt-2 pb-4 px-6 z-50 shadow-[0_-4px_10px_rgba(0,0,0,0.02)]">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-16 text-gray-400 hover:text-gray-600 transition-colors mt-2 md:mt-0">
            <i class="fa-solid fa-house text-xl md:text-2xl mb-1"></i>
            <span class="text-[10px] md:text-xs font-medium">Beranda</span>
        </a>
        
        <a href="{{ route('assessment.index') }}" class="flex flex-col items-center justify-center w-16 text-gray-400 hover:text-gray-600 transition-colors mt-2 md:mt-0">
            <i class="fa-regular fa-clipboard text-xl md:text-2xl mb-1"></i>
            <span class="text-[10px] md:text-xs font-medium">Tes</span>
        </a>
        
        <a href="#" class="flex flex-col items-center justify-center w-16 text-[#0f766e]">
            <div class="bg-[#ccfbf1] w-14 h-14 md:w-16 md:h-16 rounded-full flex flex-col items-center justify-center -mt-6 md:-mt-8 shadow-sm border border-[#a7f3d0]">
                <i class="fa-regular fa-user text-xl md:text-2xl"></i>
            </div>
            <span class="text-[10px] md:text-xs font-bold mt-1">Profil</span>
        </a>
    </div>

</body>
</html>