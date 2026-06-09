<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Jalanmu - Masuk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-b from-[#e8f6fa] to-[#f4f7f9] min-h-screen flex flex-col items-center justify-center p-4 font-sans text-gray-800 relative">

    <div class="text-center mb-6 mt-8 z-10">
        <div class="bg-[#0b1320] inline-block p-4 rounded-lg mb-4 shadow-md">
            <img src="{{ asset('images/garuda.png') }}" alt="Logo Garuda" class="w-12 h-12 object-contain mx-auto">
        </div>
        <h1 class="text-2xl font-bold text-[#003366] mb-2">Pilih Jalanmu</h1>
        <p class="text-gray-600 text-sm max-w-sm mx-auto">Tentukan masa depan pendidikanmu dengan langkah yang tepat.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.05)] w-full max-w-md p-6 sm:p-8 border border-gray-100 z-10">
        
        <div class="mb-6">
            <label class="block text-sm font-bold text-gray-700 mb-3">Pilih Peran</label>
            <div class="grid grid-cols-3 gap-3">
                <button type="button" class="flex flex-col items-center justify-center py-3 px-2 rounded-xl border-2 border-[#4fe0b5] bg-[#ccfbf1] text-[#0f766e] transition-all">
                    <i class="fa-solid fa-graduation-cap text-lg mb-1"></i>
                    <span class="text-xs font-bold">Siswa</span>
                </button>
                <button type="button" class="flex flex-col items-center justify-center py-3 px-2 rounded-xl border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 transition-all">
                    <i class="fa-regular fa-building text-lg mb-1"></i>
                    <span class="text-xs font-semibold">Sekolah</span>
                </button>
                <button type="button" class="flex flex-col items-center justify-center py-3 px-2 rounded-xl border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 transition-all">
                    <i class="fa-solid fa-shield-halved text-lg mb-1"></i>
                    <span class="text-xs font-semibold">Admin</span>
                </button>
            </div>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-5 relative">
                <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Email atau NISN</label>
                <div class="relative">
                    <input type="text" id="email" name="email" placeholder="Masukkan Email atau NISN" 
                        class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#003366] focus:border-transparent transition-all">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-regular fa-user"></i>
                    </div>
                </div>
            </div>

            <div class="mb-6 relative">
                <div class="flex justify-between items-center mb-1">
                    <label for="password" class="block text-sm font-bold text-gray-700">Kata Sandi</label>
                    <a href="#" class="text-xs font-bold text-[#003366] hover:underline">Lupa Sandi?</a>
                </div>
                <div class="relative">
                    <input type="password" id="password" name="password" placeholder="••••••••" 
                        class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#003366] focus:border-transparent transition-all">
                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-[#004080] hover:bg-[#003366] text-white font-bold py-3 px-4 rounded-lg flex items-center justify-center gap-2 transition-colors">
                Masuk
                <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>

        <hr class="my-6 border-gray-200">

        <div class="text-center">
            <p class="text-sm text-gray-600 mb-3">Belum memiliki akun?</p>
            <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 px-6 py-2 border border-[#0f766e] text-[#0f766e] font-semibold rounded-full hover:bg-[#0f766e] hover:text-white transition-colors">
                Daftar Akun Baru
                <i class="fa-solid fa-user-plus text-sm"></i>
            </a>
        </div>
    </div>

    <div class="mt-8 text-center pb-8 z-10">
        <p class="text-[11px] font-bold tracking-widest text-gray-400 uppercase">
            Pusat Data dan Informasi Kemendikdasmen
        </p>
    </div>

</body>
</html>