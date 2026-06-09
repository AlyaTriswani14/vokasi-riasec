<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Jurusan - Teknik Komputer & Jaringan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8fafc] font-sans text-gray-800 min-h-screen flex flex-col relative pb-24">

    <div class="w-full flex items-center p-4 md:px-8 bg-[#f8fafc] sticky top-0 z-50">
        <a href="{{ route('dashboard') }}" class="text-[#003366] hover:text-[#00558f] mr-4 transition-colors">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>
        <h1 class="text-[#003366] font-bold text-lg">Detail Jurusan</h1>
    </div>

    <main class="flex-grow w-full max-w-4xl mx-auto flex flex-col">

        <div class="relative w-full h-64 md:h-80 bg-gray-900 overflow-hidden">
            <img src="{{ asset('images/server-room.jpg') }}" alt="Ruang Server TKJ" class="w-full h-full object-cover opacity-80 mix-blend-overlay">
            
            <div class="absolute inset-0 bg-gradient-to-t from-[#f8fafc] via-[#f8fafc]/60 to-transparent"></div>
            
            <div class="absolute bottom-0 left-0 p-4 md:p-8 w-full">
                <span class="bg-[#0f766e] text-white text-[10px] font-bold px-3 py-1.5 rounded-full mb-3 inline-block tracking-wider uppercase">SMK Unggulan</span>
                <h2 class="text-2xl md:text-4xl font-extrabold text-[#003366]">Teknik Komputer & Jaringan</h2>
            </div>
        </div>

        <div class="px-4 md:px-8 flex flex-col gap-6 -mt-2 relative z-10">
            
            <div class="bg-white rounded-2xl p-5 md:p-6 border border-gray-200 shadow-sm">
                <h3 class="font-bold text-[#003366] text-base mb-3">Tentang Jurusan</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Mempelajari cara instalasi jaringan LAN, WAN, keamanan siber, hingga administrasi server. Kurikulum kami dirancang untuk membekali siswa dengan pemahaman mendalam tentang arsitektur jaringan modern dan protokol keamanan data.
                </p>
            </div>

            <div>
                <h3 class="font-bold text-[#003366] text-base mb-3 pl-1">Kompetensi Utama</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm hover:border-[#0284c7] transition-colors">
                        <div class="w-10 h-10 rounded-xl bg-[#e0f2fe] text-[#0284c7] flex items-center justify-center text-lg mb-4">
                            <i class="fa-solid fa-router"></i>
                        </div>
                        <h4 class="text-[10px] font-bold text-[#003366] tracking-wider mb-2 uppercase">Perancangan Jaringan</h4>
                        <p class="text-xs text-gray-600 leading-relaxed">Arsitektur LAN/WAN, routing, switching, dan optimasi trafik data.</p>
                    </div>

                    <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm hover:border-[#0f766e] transition-colors">
                        <div class="w-10 h-10 rounded-xl bg-[#ccfbf1] text-[#0f766e] flex items-center justify-center text-lg mb-4">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                        </div>
                        <h4 class="text-[10px] font-bold text-[#0f766e] tracking-wider mb-2 uppercase">Troubleshooting Hardware</h4>
                        <p class="text-xs text-gray-600 leading-relaxed">Diagnosa kerusakan perangkat keras, perakitan PC, dan pemeliharaan server.</p>
                    </div>

                    <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm hover:border-[#92400e] transition-colors">
                        <div class="w-10 h-10 rounded-xl bg-[#ffedd5] text-[#92400e] flex items-center justify-center text-lg mb-4">
                            <i class="fa-solid fa-terminal"></i>
                        </div>
                        <h4 class="text-[10px] font-bold text-[#92400e] tracking-wider mb-2 uppercase">Administrasi Linux</h4>
                        <p class="text-xs text-gray-600 leading-relaxed">Manajemen sistem operasi server berbasis open-source dan scripting CLI.</p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="font-bold text-[#003366] text-base mb-3 pl-1">Prospek Karir</h3>
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="bg-[#003366] flex justify-between p-4 text-white text-xs font-bold tracking-wide">
                        <span>Jabatan</span>
                        <span>Potensi</span>
                    </div>
                    
                    <div class="flex justify-between items-center p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3 text-sm text-gray-800 font-medium">
                            <i class="fa-solid fa-network-wired text-gray-400 w-5 text-center"></i>
                            <span>Network Engineer</span>
                        </div>
                        <span class="bg-[#a7f3d0] text-[#047857] text-[10px] font-bold px-2.5 py-1 rounded">High Demand</span>
                    </div>
                    
                    <div class="flex justify-between items-center p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3 text-sm text-gray-800 font-medium">
                            <i class="fa-solid fa-headset text-gray-400 w-5 text-center"></i>
                            <span>IT Support</span>
                        </div>
                        <span class="bg-[#e0e7ff] text-[#4f46e5] text-[10px] font-bold px-2.5 py-1 rounded">Global Entry</span>
                    </div>
                    
                    <div class="flex justify-between items-center p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3 text-sm text-gray-800 font-medium">
                            <i class="fa-solid fa-shield-halved text-gray-400 w-5 text-center"></i>
                            <span>Cybersecurity Analyst</span>
                        </div>
                        <span class="bg-[#ffedd5] text-[#c2410c] text-[10px] font-bold px-2.5 py-1 rounded">Specialist</span>
                    </div>
                </div>
            </div>

            <div class="mt-2 mb-8">
                <a href="{{ route('sekolah.explore') }}" class="w-full bg-[#003366] hover:bg-[#002244] text-white font-bold py-4 px-4 rounded-xl transition-colors shadow-md text-sm md:text-base flex justify-center items-center gap-2">
                    <i class="fa-solid fa-map-location-dot text-lg"></i> Eksplor Sekolah Terdekat
                </a>
            </div>

        </div>
    </main>

    <div class="fixed bottom-0 w-full bg-white border-t border-gray-200 flex justify-center gap-16 md:gap-32 items-center pt-2 pb-4 px-6 z-50 shadow-[0_-4px_10px_rgba(0,0,0,0.02)]">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-16 text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fa-solid fa-house text-xl md:text-2xl mb-1"></i>
            <span class="text-[10px] md:text-xs font-medium">Beranda</span>
        </a>
        <a href="{{ route('assessment.index') }}" class="flex flex-col items-center justify-center w-16 text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fa-regular fa-clipboard text-xl md:text-2xl mb-1"></i>
            <span class="text-[10px] md:text-xs font-medium">Tes</span>
        </a>
        <a href="#" class="flex flex-col items-center justify-center w-16 text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fa-regular fa-user text-xl md:text-2xl mb-1"></i>
            <span class="text-[10px] md:text-xs font-medium">Profil</span>
        </a>
    </div>

</body>
</html>