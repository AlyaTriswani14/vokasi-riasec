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
            <i class="fa-solid fa-graduation-cap"></i> <span>Pilih Jalanmu</span>
        </div>
        <div class="w-8 h-8 rounded-full bg-[#00558f] text-white flex items-center justify-center font-bold text-xs">
            {{ Auth::check() ? strtoupper(substr(Auth::user()->name, 0, 2)) : 'PP' }}
        </div>
    </div>

    <main class="flex-grow w-full max-w-4xl mx-auto px-4 pt-6 pb-12 flex flex-col gap-5">
        
        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm flex items-center gap-4">
            <div class="relative w-14 h-14 shrink-0">
                <div class="w-full h-full rounded-full bg-gray-200 overflow-hidden border-2 border-gray-100 flex items-center justify-center text-gray-400 text-2xl">
                    <i class="fa-solid fa-user"></i>
                </div>
            </div>
            <div>
                <h2 class="font-bold text-lg text-gray-800">{{ Auth::user()->name }}</h2>
                <p class="text-xs text-gray-500 mb-1.5">Siswa Aktif</p>
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
                    <h3 class="font-bold text-xl {{ $hasilTes ? 'text-[#16a34a]' : 'text-gray-400' }}">
                        {{ $hasilTes ? 'Selesai' : 'Belum Tes' }}
                    </h3>
                </div>
                @if($hasilTes)
                    <p class="text-xs text-gray-500">Tes terakhir: {{ $hasilTes->created_at->format('d M Y') }}</p>
                @else
                    <p class="text-xs text-red-500">Silakan lakukan tes terlebih dahulu.</p>
                @endif
            </div>

            <div class="bg-[#00558f] rounded-2xl p-5 text-white shadow-sm relative overflow-hidden">
                <p class="text-[10px] font-bold text-blue-200 tracking-wider uppercase mb-3">Hasil Terakhir</p>
                @if($hasilTes)
                    <p class="text-sm">Skor R: {{ $hasilTes->skor_r }}, I: {{ $hasilTes->skor_i }}, A: {{ $hasilTes->skor_a }}</p>
                @else
                    <p class="text-sm">Data belum tersedia.</p>
                @endif
            </div>
        </div>

        <div class="mt-2">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Rekomendasi Jurusan SMK</h2>
            <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm flex flex-col md:flex-row gap-4">
                <div class="w-full md:w-1/3 h-32 bg-gray-200 rounded-xl flex items-center justify-center">
                    <span class="text-gray-400 text-xs">Ilustrasi Jurusan</span>
                </div>
                <div class="flex-grow">
                    <h3 class="font-bold text-[#00558f] text-lg">Teknik Komputer & Jaringan</h3>
                    <p class="text-xs text-gray-600 mt-2">Fokus pada infrastruktur TI dan jaringan.</p>
                    <a href="{{ route('jurusan.tkj') }}" class="inline-block mt-4 bg-[#004080] text-white text-xs font-bold py-2 px-4 rounded-lg">Detail Jurusan</a>
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