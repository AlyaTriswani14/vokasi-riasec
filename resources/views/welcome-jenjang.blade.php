<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Jenjang - Pilih Jalanmu</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8fafc] font-sans text-gray-800 min-h-screen flex items-center justify-center p-5 relative overflow-hidden">

    <div class="absolute w-72 h-72 bg-gradient-to-br from-[#7C3AED] to-[#EC4899] opacity-20 rounded-full -top-20 -left-20"></div>
    <div class="absolute w-72 h-72 bg-gradient-to-br from-[#22C1C3] to-[#2F6FED] opacity-20 rounded-full -bottom-24 -right-16"></div>

    <div class="w-full max-w-xl relative z-10">
        <div class="flex items-center justify-center gap-2 text-[#003366] font-bold text-lg mb-8">
            <i class="fa-solid fa-graduation-cap"></i>
            <span>Pilih Jalanmu</span>
        </div>

        <div class="bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 p-6 md:p-10">
            <div class="flex items-center justify-center gap-2 mb-6">
                <div class="w-10 h-1.5 rounded-full bg-gradient-to-r from-[#7C3AED] to-[#EC4899]"></div>
                <div class="w-10 h-1.5 rounded-full bg-gray-200"></div>
                <div class="w-10 h-1.5 rounded-full bg-gray-200"></div>
            </div>

            <div class="text-center mb-8">
                <p class="text-[10px] font-bold uppercase tracking-widest text-[#0f766e] bg-[#ccfbf1] inline-block px-3 py-1 rounded-full mb-3">Langkah 1 dari 3</p>
                <h1 class="text-xl md:text-2xl font-extrabold text-[#003366] mb-2">Kamu siswa dari jenjang apa?</h1>
                <p class="text-gray-500 text-sm">Tampilan dan soal tes akan disesuaikan dengan jenjangmu.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <a href="{{ route('jenjang.pilih', 'smp') }}"
                   class="relative overflow-hidden rounded-[24px] p-6 flex flex-col items-center text-center gap-2 text-white shadow-lg shadow-orange-200 bg-gradient-to-br from-[#FF7A45] to-[#FFB13D] hover:scale-[1.02] transition duration-200">
                    <div class="absolute w-24 h-24 bg-white/15 rounded-full -top-8 -right-8"></div>
                    <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center text-2xl mb-1 relative z-10">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <span class="font-extrabold text-lg relative z-10">SMP / MTs</span>
                    <span class="text-xs text-white/90 relative z-10">Sekolah Menengah Pertama</span>
                </a>
                <a href="{{ route('jenjang.pilih', 'smk') }}"
                   class="relative overflow-hidden rounded-[24px] p-6 flex flex-col items-center text-center gap-2 text-white shadow-lg shadow-blue-200 bg-gradient-to-br from-[#2F6FED] to-[#22C1C3] hover:scale-[1.02] transition duration-200">
                    <div class="absolute w-24 h-24 bg-white/15 rounded-full -top-8 -right-8"></div>
                    <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center text-2xl mb-1 relative z-10">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                    </div>
                    <span class="font-extrabold text-lg relative z-10">SMK</span>
                    <span class="text-xs text-white/90 relative z-10">Sekolah Menengah Kejuruan</span>
                </a>
            </div>

            <a href="{{ route('pilih.admin') }}"
               class="w-full text-center text-gray-400 hover:text-[#003366] text-xs font-bold py-3 flex items-center justify-center gap-2 border border-dashed border-gray-200 rounded-2xl transition">
                <i class="fa-solid fa-shield-halved"></i> Masuk sebagai Admin
            </a>
        </div>
    </div>

</body>
</html>