<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Pilih Jalanmu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8fafc] font-sans text-gray-800 min-h-screen flex flex-col relative pb-24">

    <div class="w-full flex justify-between items-center p-4 md:px-8 bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-2 text-[#003366] font-bold text-lg">
            <i class="fa-solid fa-graduation-cap"></i>
            <span>Pilih Jalanmu</span>
        </div>
        <div class="flex items-center gap-4">
            <button class="text-gray-500 hover:text-gray-700 relative">
                <i class="fa-regular fa-bell text-xl"></i>
                <span class="absolute -top-1 -right-1 flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500 border-2 border-white"></span>
                </span>
            </button>
            <div class="w-8 h-8 rounded-full bg-[#00558f] text-white flex items-center justify-center font-bold text-xs">
                {{ Auth::check() ? strtoupper(substr(Auth::user()->name, 0, 2)) : 'PP' }}
            </div>
        </div>
    </div>

    @php
        $namaUser = Auth::check() ? Auth::user()->name : 'Budi Darmawan';
        $asalSekolah = 'SMP Negeri 01';
    @endphp

    <main class="flex-grow w-full max-w-4xl mx-auto px-4 pt-6 pb-12 flex flex-col gap-5">

        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm flex items-center gap-4">
            <div class="relative w-14 h-14 shrink-0">
                <div class="w-full h-full rounded-full bg-gray-200 overflow-hidden border-2 border-gray-100 flex items-center justify-center text-gray-400 text-2xl">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="absolute bottom-0 right-0 bg-[#4fe0b5] w-4 h-4 rounded-full border-2 border-white flex items-center justify-center">
                    <i class="fa-solid fa-check text-white text-[8px]"></i>
                </div>
            </div>
            <div>
                <h2 class="font-bold text-lg text-gray-800">{{ $namaUser }}</h2>
                <p class="text-xs text-gray-500 mb-1.5">Kelas 9 - {{ $asalSekolah }}</p>
                <span class="bg-[#ccfbf1] text-[#0f766e] text-[10px] font-bold px-2.5 py-1 rounded-full">Siswa Aktif</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
                <p class="text-[10px] font-bold text-gray-400 tracking-wider uppercase mb-2">Status Tes Minat</p>
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-6 h-6 rounded-full bg-[#dcfce7] text-[#16a34a] flex items-center justify-center text-sm">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <h3 class="font-bold text-xl text-[#16a34a]">Selesai</h3>
                </div>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Tes terakhir dilakukan pada <span class="font-medium text-gray-700">12 Okt 2023</span>. Kamu bisa mengulang tes 6 bulan lagi.
                </p>
            </div>

            <div class="bg-[#00558f] rounded-2xl p-5 text-white shadow-sm relative overflow-hidden">
                <p class="text-[10px] font-bold text-blue-200 tracking-wider uppercase mb-3 relative z-10">3 Minat Teratas</p>
                <div class="flex flex-wrap gap-2 relative z-10">
                    <span class="bg-white/20 border border-white/10 px-3 py-1.5 rounded-full text-xs font-medium flex items-center gap-1.5">
                        <i class="fa-solid fa-screwdriver-wrench text-blue-200"></i> Realistik
                    </span>
                    <span class="bg-white/20 border border-white/10 px-3 py-1.5 rounded-full text-xs font-medium flex items-center gap-1.5">
                        <i class="fa-solid fa-microscope text-blue-200"></i> Investigatif
                    </span>
                    <span class="bg-white/20 border border-white/10 px-3 py-1.5 rounded-full text-xs font-medium flex items-center gap-1.5">
                        <i class="fa-solid fa-palette text-blue-200"></i> Artistik
                    </span>
                </div>
                <i class="fa-solid fa-ranking-star absolute -bottom-4 -right-4 text-6xl text-white/5"></i>
            </div>
        </div>

        <div class="mt-4">
            <div class="flex justify-between items-end mb-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Rekomendasi Jurusan SMK</h2>
                    <p class="text-xs text-gray-500">Berdasarkan skor RIASEC kamu</p>
                </div>
                <a href="#" class="text-[#00558f] text-xs font-bold hover:underline">Lihat Semua</a>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm flex flex-col md:flex-row mb-4 hover:shadow-md transition-shadow">
                <div class="w-full md:w-2/5 h-40 md:h-auto bg-gray-200 relative">
                    <img src="{{ asset('images/tkj-banner.jpg') }}" alt="Ilustrasi TKJ" class="w-full h-full object-cover">
                </div>
                <div class="p-5 w-full md:w-3/5 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-bold text-[#00558f] text-lg">Teknik Komputer & Jaringan</h3>
                            <span class="bg-[#a7f3d0] text-[#047857] text-[10px] font-bold px-2 py-1 rounded flex items-center gap-1 shrink-0">
                                <i class="fa-solid fa-star"></i> 98% Cocok
                            </span>
                        </div>
                        <p class="text-xs text-gray-600 leading-relaxed mb-4">
                            Fokus pada infrastruktur TI, perakitan komputer, dan sistem jaringan. Sangat cocok dengan tipe Investigatif-mu.
                        </p>
                    </div>
                    <a href="{{ route('jurusan.tkj') }}" class="w-full bg-[#004080] hover:bg-[#003366] text-white text-xs font-bold py-2.5 rounded-lg transition-colors flex justify-center items-center text-center">
                        Detail Jurusan
                    </a>
                </div>
            </div>
        </div>
    </main>

    <div class="fixed bottom-0 w-full bg-white border-t border-gray-200 flex justify-center gap-16 md:gap-32 items-center pt-2 pb-4 px-6 z-50 shadow-[0_-4px_10px_rgba(0,0,0,0.02)]">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-16 text-[#0f766e]">
            <div class="bg-[#ccfbf1] w-14 h-14 md:w-16 md:h-16 rounded-full flex flex-col items-center justify-center -mt-6 md:-mt-8 shadow-sm border border-[#a7f3d0]">
                <i class="fa-solid fa-house text-xl md:text-2xl"></i>
            </div>
            <span class="text-[10px] md:text-xs font-bold mt-1">Beranda</span>
        </a>
        
        <a href="{{ route('assessment.index') }}" class="flex flex-col items-center justify-center w-16 text-gray-400 hover:text-gray-600 transition-colors mt-2 md:mt-0">
            <i class="fa-regular fa-clipboard text-xl md:text-2xl mb-1"></i>
            <span class="text-[10px] md:text-xs font-medium">Tes</span>
        </a>
        
        <a href="{{ route('profil') }}" class="flex flex-col items-center justify-center w-16 text-gray-400 hover:text-gray-600 transition-colors mt-2 md:mt-0">
            <i class="fa-regular fa-user text-xl md:text-2xl mb-1"></i>
            <span class="text-[10px] md:text-xs font-medium">Profil</span>
        </a>
    </div>

</body>
</html>