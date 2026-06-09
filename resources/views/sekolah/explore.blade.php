<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eksplor Sekolah - Pilih Jalanmu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8fafc] font-sans text-gray-800 min-h-screen flex flex-col relative pb-24">

    <div class="w-full flex items-center p-4 md:px-8 bg-white sticky top-0 z-50">
        <a href="{{ route('jurusan.tkj') }}" class="text-[#00558f] hover:text-[#003366] mr-4 transition-colors">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>
        <h1 class="text-[#003366] font-bold text-lg">Eksplor Sekolah</h1>
    </div>

    <main class="flex-grow w-full max-w-3xl mx-auto flex flex-col">
        
        <div class="p-4 bg-white shadow-[0_4px_10px_rgba(0,0,0,0.02)] z-40 relative">
            <div class="flex gap-3">
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                    </div>
                    <input type="text" class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-[#00558f] focus:border-[#00558f] bg-white placeholder-gray-400" placeholder="Cari sekolah atau jurusan...">
                </div>
                <button class="flex-shrink-0 w-11 h-11 border border-gray-200 rounded-xl bg-white flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-colors">
                    <i class="fa-solid fa-filter"></i>
                </button>
            </div>
        </div>

        <div class="px-4 pt-4 pb-8 flex flex-col gap-4">
            
            <div class="relative w-full h-40 md:h-48 bg-gray-200 rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                <img src="{{ asset('images/map-bg.jpg') }}" alt="Peta Lokasi" class="w-full h-full object-cover opacity-90">
                
                <div class="absolute top-1/4 left-1/3 bg-[#00558f] text-white text-[10px] font-bold px-2 py-1 rounded-md shadow-md flex items-center gap-1 -translate-x-1/2">
                    <i class="fa-solid fa-graduation-cap"></i> SMKN 1
                </div>
                <div class="absolute top-1/2 left-2/3 bg-[#0f766e] text-white text-[10px] font-bold px-2 py-1 rounded-md shadow-md flex items-center gap-1 -translate-x-1/2">
                    <i class="fa-solid fa-graduation-cap"></i> SMKN 26
                </div>
                
                <div class="absolute inset-0 bg-gradient-to-t from-white/20 to-transparent pointer-events-none"></div>
            </div>

            <div class="flex justify-between items-end mt-2">
                <h2 class="font-bold text-gray-800 text-base">Sekolah Terdekat</h2>
                <span class="text-[#00558f] text-xs font-bold">32 Ditemukan</span>
            </div>

            <div class="flex flex-col gap-4">
                
                <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                    <div class="flex gap-4">
                        <img src="{{ asset('images/smk1.jpg') }}" alt="SMKN 1" class="w-16 h-16 rounded-xl object-cover border border-gray-100 shrink-0 bg-gray-100">
                        <div class="flex flex-col justify-center">
                            <h3 class="font-bold text-gray-800 text-sm mb-1">SMK Negeri 1 Jakarta</h3>
                            <div class="flex items-center gap-1.5 text-[11px] text-gray-500 mb-2">
                                <i class="fa-regular fa-paper-plane"></i>
                                <span>2.5 km • Gambir, Pusat</span>
                            </div>
                            <span class="bg-[#ccfbf1] text-[#0f766e] text-[9px] font-bold px-2 py-1 rounded w-fit flex items-center gap-1">
                                <i class="fa-solid fa-check-circle"></i> Kecocokan: Tinggi
                            </span>
                        </div>
                    </div>
                    <hr class="my-3 border-gray-100">
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold tracking-widest uppercase mb-1">Jurusan Relevan</p>
                        <p class="text-xs font-bold text-[#003366]">Teknik Komputer & Jaringan</p>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                    <div class="flex gap-4">
                        <img src="{{ asset('images/smk26.jpg') }}" alt="SMKN 26" class="w-16 h-16 rounded-xl object-cover border border-gray-100 shrink-0 bg-gray-100">
                        <div class="flex flex-col justify-center">
                            <h3 class="font-bold text-gray-800 text-sm mb-1">SMK Negeri 26 Jakarta</h3>
                            <div class="flex items-center gap-1.5 text-[11px] text-gray-500 mb-2">
                                <i class="fa-regular fa-paper-plane"></i>
                                <span>4.2 km • Rawamangun</span>
                            </div>
                            <span class="bg-[#92400e] text-white text-[9px] font-bold px-2 py-1 rounded w-fit flex items-center gap-1">
                                <i class="fa-solid fa-star"></i> Jurusan Unggulan
                            </span>
                        </div>
                    </div>
                    <hr class="my-3 border-gray-100">
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold tracking-widest uppercase mb-1">Jurusan Relevan</p>
                        <p class="text-xs font-bold text-[#003366]">Mekatronika</p>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                    <div class="flex gap-4">
                        <img src="{{ asset('images/smk3.jpg') }}" alt="SMKN 3" class="w-16 h-16 rounded-xl object-cover border border-gray-100 shrink-0 bg-gray-100">
                        <div class="flex flex-col justify-center">
                            <h3 class="font-bold text-gray-800 text-sm mb-1">SMK Negeri 3 Jakarta</h3>
                            <div class="flex items-center gap-1.5 text-[11px] text-gray-500 mb-2">
                                <i class="fa-regular fa-paper-plane"></i>
                                <span>5.8 km • Senen</span>
                            </div>
                            <span class="bg-gray-100 text-gray-600 border border-gray-200 text-[9px] font-bold px-2 py-1 rounded w-fit flex items-center gap-1">
                                <i class="fa-solid fa-bus"></i> Akses TransJakarta
                            </span>
                        </div>
                    </div>
                    <hr class="my-3 border-gray-100">
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold tracking-widest uppercase mb-1">Jurusan Relevan</p>
                        <p class="text-xs font-bold text-[#003366]">Multimedia & Desain</p>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <div class="fixed bottom-0 w-full bg-white border-t border-gray-200 flex justify-center gap-16 md:gap-32 items-center pt-2 pb-4 px-6 z-50 shadow-[0_-4px_10px_rgba(0,0,0,0.02)]">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-16 text-gray-400 hover:text-gray-600 transition-colors mt-2 md:mt-0">
            <i class="fa-solid fa-house text-xl md:text-2xl mb-1"></i>
            <span class="text-[10px] md:text-xs font-medium">Beranda</span>
        </a>
        <a href="{{ route('assessment.index') }}" class="flex flex-col items-center justify-center w-16 text-[#0f766e]">
            <div class="bg-[#ccfbf1] w-14 h-14 md:w-16 md:h-16 rounded-full flex flex-col items-center justify-center -mt-6 md:-mt-8 shadow-sm border border-[#a7f3d0]">
                <i class="fa-regular fa-clipboard text-xl md:text-2xl"></i>
            </div>
            <span class="text-[10px] md:text-xs font-bold mt-1">Tes</span>
        </a>
        <a href="#" class="flex flex-col items-center justify-center w-16 text-gray-400 hover:text-gray-600 transition-colors mt-2 md:mt-0">
            <i class="fa-regular fa-user text-xl md:text-2xl mb-1"></i>
            <span class="text-[10px] md:text-xs font-medium">Profil</span>
        </a>
    </div>

</body>
</html>