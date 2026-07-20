<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Bakat Minat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8fafc] font-sans text-gray-800 min-h-screen">

    <div class="w-full flex justify-between items-center p-4 md:px-8 bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-2 text-[#003366] font-bold text-lg">
            <i class="fa-solid fa-graduation-cap"></i> <span>Bakat Minat</span>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right hidden sm:block">
                <p class="text-xs font-bold text-gray-700">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-gray-400">Admin Direktorat SMK</p>
            </div>
            <form action="{{ route('kemendikdasmen.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-9 h-9 rounded-full bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100 transition-colors">
                    <i class="fa-solid fa-arrow-right-from-bracket text-sm"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="w-full bg-[#003366] overflow-x-auto">
        <div class="max-w-6xl mx-auto flex gap-1 px-4">
            <a href="{{ route('kemendikdasmen.dashboard') }}" class="text-white/60 hover:text-white text-xs font-bold px-4 py-3 border-b-2 border-transparent whitespace-nowrap transition-colors">Dashboard</a>
            <a href="{{ route('kemendikdasmen.users') }}" class="text-white/60 hover:text-white text-xs font-bold px-4 py-3 border-b-2 border-transparent whitespace-nowrap transition-colors">Manajemen Sekolah</a>
            <a href="{{ route('kemendikdasmen.questions') }}" class="text-white/60 hover:text-white text-xs font-bold px-4 py-3 border-b-2 border-transparent whitespace-nowrap transition-colors">Bank Soal</a>
            <a href="{{ route('kemendikdasmen.settings') }}" class="text-white text-xs font-bold px-4 py-3 border-b-2 border-white whitespace-nowrap">Pengaturan</a>
            <a href="{{ route('kemendikdasmen.broadcast') }}" class="text-white/60 hover:text-white text-xs font-bold px-4 py-3 border-b-2 border-transparent whitespace-nowrap transition-colors">Broadcast</a>
        </div>
    </div>

    <main class="w-full max-w-3xl mx-auto px-4 py-8 flex flex-col gap-6">

        <div>
            <span class="inline-block bg-[#003366] text-white text-[10px] font-bold px-3 py-1.5 rounded-full mb-2">ADMIN DIREKTORAT SMK</span>
            <h1 class="text-xl font-extrabold text-gray-800">Pengaturan Sistem</h1>
            <p class="text-sm text-gray-500">Konfigurasi umum platform Bakat Minat.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-100 text-green-700 text-xs rounded-xl p-3">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-100 text-red-600 text-xs rounded-xl p-3">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('kemendikdasmen.settings.update') }}" class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 flex flex-col gap-5">
            @csrf

            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1.5">
                    <i class="fa-solid fa-clock text-[#2F6FED] mr-1"></i> Durasi Tes (menit)
                </label>
                <input type="number" name="durasi_tes_menit" min="1" max="180" value="{{ old('durasi_tes_menit', $settings['durasi_tes_menit']) }}" required class="w-full max-w-xs border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">
                <p class="text-[10px] text-gray-400 mt-1">Perubahan langsung berlaku untuk siswa yang memulai tes setelah ini disimpan.</p>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1.5">
                    <i class="fa-solid fa-bullseye text-[#c2410c] mr-1"></i> Target Kuota Nasional (siswa)
                </label>
                <input type="number" name="target_kuota_nasional" min="0" value="{{ old('target_kuota_nasional', $settings['target_kuota_nasional']) }}" required class="w-full max-w-xs border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1.5">
                    <i class="fa-solid fa-calendar-days text-[#0f766e] mr-1"></i> Tahun Ajaran
                </label>
                <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', $settings['tahun_ajaran']) }}" required placeholder="2026/2027" class="w-full max-w-xs border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1.5">
                    <i class="fa-solid fa-server text-green-600 mr-1"></i> Status Sistem
                </label>
                <select name="status_sistem" required class="w-full max-w-xs border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">
                    <option value="Aktif" {{ old('status_sistem', $settings['status_sistem']) === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Maintenance" {{ old('status_sistem', $settings['status_sistem']) === 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
            </div>

            <div class="pt-2">
                <button type="submit" class="bg-[#003366] text-white text-xs font-bold px-6 py-2.5 rounded-xl hover:bg-[#002855] transition-colors">Simpan Pengaturan</button>
            </div>
        </form>

    </main>

</body>
</html>