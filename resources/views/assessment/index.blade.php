<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tes Minat RIASEC - Pilih Jalanmu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8fafc] font-sans text-gray-800 min-h-screen flex flex-col relative pb-24">

    <div class="w-full flex justify-between items-center p-4 md:px-8 bg-[#f8fafc] border-b border-gray-100">
        <div class="flex items-center gap-2 text-[#003366] font-bold text-lg">
            <i class="fa-solid fa-graduation-cap"></i>
            <span>Pilih Jalanmu</span>
        </div>
        <button class="text-gray-500 hover:text-gray-700">
            <i class="fa-regular fa-circle-question text-xl"></i>
        </button>
    </div>

    <main class="flex-grow w-full max-w-3xl mx-auto px-4 pt-8 pb-12 flex flex-col items-center">

        <div class="relative w-56 h-56 md:w-64 md:h-64 mb-6">
            <img src="{{ asset('images/riasec-hero.png') }}" alt="Ilustrasi Siswa" class="w-full h-full object-cover rounded-full border-[6px] border-white shadow-sm">
            
            <div class="absolute bottom-2 right-0 md:bottom-4 md:right-2 bg-[#4fe0b5] w-14 h-14 md:w-16 md:h-16 rounded-2xl flex items-center justify-center shadow-lg border-2 border-white transform rotate-[-5deg]">
                <i class="fa-solid fa-head-side-gear text-white text-2xl md:text-3xl"></i>
            </div>
        </div>

        <div class="text-center mb-8">
            <h1 class="text-2xl md:text-3xl font-extrabold text-[#003366] mb-2">Tes Minat RIASEC</h1>
            <p class="text-gray-600 text-sm md:text-base">Temukan potensi karier yang paling sesuai dengan kepribadian dan minatmu.</p>
        </div>

        <div class="w-full bg-white rounded-2xl p-6 md:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.04)] border border-gray-100 mb-8">
            <div class="flex items-center gap-3 mb-6">
                <i class="fa-solid fa-clipboard-list text-[#0f766e] text-xl"></i>
                <h2 class="font-bold text-gray-800 text-lg md:text-xl">Petunjuk Pengisian</h2>
            </div>

            <div class="space-y-5">
                <div class="flex gap-4">
                    <div class="w-8 h-8 rounded-full bg-[#dbeafe] text-[#1e3a8a] flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">1</div>
                    <p class="text-sm md:text-base text-gray-600 leading-relaxed"><span class="font-bold text-gray-800">Baca saksama</span> setiap pernyataan yang muncul di layar mengenai aktivitas atau pekerjaan tertentu.</p>
                </div>
                <div class="flex gap-4">
                    <div class="w-8 h-8 rounded-full bg-[#dbeafe] text-[#1e3a8a] flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">2</div>
                    <p class="text-sm md:text-base text-gray-600 leading-relaxed">Berikan <i class="fa-regular fa-circle-check text-green-600"></i> <span class="font-bold text-[#0f766e]">tanda centang (Ya)</span> jika kamu menyukai atau tertarik melakukan aktivitas tersebut.</p>
                </div>
                <div class="flex gap-4">
                    <div class="w-8 h-8 rounded-full bg-[#dbeafe] text-[#1e3a8a] flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">3</div>
                    <p class="text-sm md:text-base text-gray-600 leading-relaxed">Berikan <i class="fa-regular fa-circle-xmark text-red-500"></i> <span class="font-bold text-red-600">tanda silang (Kosongkan)</span> jika kamu tidak menyukai atau tidak tertarik.</p>
                </div>
                <div class="flex gap-4">
                    <div class="w-8 h-8 rounded-full bg-[#dbeafe] text-[#1e3a8a] flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">4</div>
                    <p class="text-sm md:text-base text-gray-600 leading-relaxed">Setelah selesai, sistem akan secara otomatis <span class="font-bold text-gray-800">menghitung skor</span> berdasarkan kategori RIASEC.</p>
                </div>
                <div class="flex gap-4">
                    <div class="w-8 h-8 rounded-full bg-[#dbeafe] text-[#1e3a8a] flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">5</div>
                    <p class="text-sm md:text-base text-gray-600 leading-relaxed">Kamu dapat <span class="font-bold text-gray-800">melihat 3 teratas</span> tipe kepribadian yang paling dominan dalam dirimu dan saran karier terkait.</p>
                </div>
            </div>
        </div>

        <div class="w-full max-w-xl mx-auto">
            <form action="{{ route('assessment.start') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-[#004080] hover:bg-[#003366] text-white font-bold py-3.5 px-4 rounded-xl flex items-center justify-center gap-2 transition-colors shadow-md text-base">
                    Mulai Tes Sekarang
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>
            <p class="text-center text-xs md:text-sm text-gray-500 mt-3">Estimasi waktu pengerjaan: 5 - 10 menit</p>
        </div>

    </main>

    <div class="fixed bottom-0 w-full bg-white border-t border-gray-200 flex justify-center gap-16 md:gap-32 items-center pt-2 pb-4 px-6 z-50 shadow-[0_-4px_10px_rgba(0,0,0,0.02)]">
        <a href="#" class="flex flex-col items-center justify-center w-16 text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fa-solid fa-house text-xl md:text-2xl mb-1"></i>
            <span class="text-[10px] md:text-xs font-medium">Beranda</span>
        </a>
        
        <a href="#" class="flex flex-col items-center justify-center w-16 text-[#0f766e]">
            <div class="bg-[#ccfbf1] w-14 h-14 md:w-16 md:h-16 rounded-full flex flex-col items-center justify-center -mt-6 md:-mt-8 shadow-sm border border-[#a7f3d0]">
                <i class="fa-regular fa-clipboard text-xl md:text-2xl"></i>
            </div>
            <span class="text-[10px] md:text-xs font-bold mt-1">Tes</span>
        </a>
        
        <a href="#" class="flex flex-col items-center justify-center w-16 text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fa-regular fa-user text-xl md:text-2xl mb-1"></i>
            <span class="text-[10px] md:text-xs font-medium">Profil</span>
        </a>
    </div>

</body>
</html>