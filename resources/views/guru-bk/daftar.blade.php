<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Guru BK - Bakat Minat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8fafc] font-sans text-gray-800 min-h-screen flex items-center justify-center relative overflow-x-hidden py-10">

    <div class="absolute w-72 h-72 bg-[#0f766e]/10 rounded-full -top-16 -left-16"></div>
    <div class="absolute w-64 h-64 bg-[#003366]/10 rounded-full -bottom-10 -right-10"></div>

    <div class="w-full max-w-lg relative z-10 px-4">
        <div class="flex items-center justify-center gap-2 text-[#003366] font-bold text-xl mb-6">
            <i class="fa-solid fa-graduation-cap"></i> <span>Bakat Minat</span>
        </div>

        <div class="bg-white rounded-3xl shadow-lg p-8">
            <span class="inline-block bg-[#003366] text-white text-[10px] font-bold px-3 py-1.5 rounded-full mb-4">PORTAL GURU BK</span>
            <h1 class="text-xl font-extrabold text-gray-800 mb-1">Daftar Akun Sekolah</h1>
            <p class="text-xs text-gray-500 mb-6">Satu sekolah hanya bisa punya satu akun, terdaftar lewat NPSN.</p>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 text-xs rounded-xl p-3 mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('guru-bk.daftar.submit') }}" method="POST" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1.5">Nama Sekolah</label>
                    <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah') }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0f766e]" placeholder="Contoh: SMKN 1 Contoh Kota">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1.5">NPSN</label>
                    <input type="text" name="npsn" value="{{ old('npsn') }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0f766e]" placeholder="Nomor Pokok Sekolah Nasional">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Jenjang Sekolah</label>
                    <select name="jenjang" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">
                        <option value="">-- Pilih Jenjang --</option>
                        <option value="smp" {{ old('jenjang') === 'smp' ? 'selected' : '' }}>SMP</option>
                        <option value="smk" {{ old('jenjang') === 'smk' ? 'selected' : '' }}>SMK</option>
                    </select>
                    @error('jenjang')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1.5">Nama Guru BK (Penanggung Jawab)</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0f766e]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0f766e]">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1.5">Password</label>
                        <input type="password" name="password" minlength="8"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0f766e]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1.5">Ulangi Password</label>
                        <input type="password" name="password_confirmation" minlength="8"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0f766e]">
                    </div>
                </div>

                <button type="submit" class="bg-[#003366] hover:bg-[#002244] text-white font-bold text-sm py-3.5 rounded-xl transition-colors mt-2">
                    Daftar Sekarang
                </button>
            </form>

            <p class="text-center text-xs text-gray-500 mt-5">
                Sudah punya akun? <a href="{{ route('guru-bk.login') }}" class="font-bold text-[#0f766e]">Masuk di sini</a>
            </p>
        </div>
    </div>

</body>
</html>