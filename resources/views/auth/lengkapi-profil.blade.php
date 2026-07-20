<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Profil - Bakat Minat</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8fafc] font-sans text-gray-800 min-h-screen flex items-center justify-center relative overflow-x-hidden py-10">

    @php
        $isSmk = (Auth::user()->jenjang ?? 'smp') === 'smk';
        $kelasOptions = $isSmk ? [10, 11, 12, 13] : [7, 8, 9];
    @endphp

    <div class="absolute w-72 h-72 bg-gradient-to-br from-[#7C3AED] to-[#EC4899] opacity-20 rounded-full -top-16 -left-16"></div>
    <div class="absolute w-72 h-72 bg-gradient-to-br from-[#22C1C3] to-[#2F6FED] opacity-20 rounded-full -bottom-16 -right-10"></div>

    <div class="w-full max-w-lg relative z-10 px-4">
        <div class="flex items-center justify-center gap-2 text-[#003366] font-bold text-lg mb-8">
            <i class="fa-solid fa-graduation-cap"></i>
            <span>Bakat Minat</span>
        </div>

        <div class="bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 p-6 md:p-10">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-10 h-1.5 rounded-full bg-gradient-to-r from-[#7C3AED] to-[#EC4899]"></div>
                <div class="w-10 h-1.5 rounded-full bg-gradient-to-r from-[#7C3AED] to-[#EC4899]"></div>
                <div class="w-10 h-1.5 rounded-full bg-gradient-to-r from-[#7C3AED] to-[#EC4899]"></div>
            </div>

            <p class="text-[10px] font-bold uppercase tracking-widest text-white inline-block px-4 py-1.5 rounded-full mb-4 {{ $isSmk ? 'bg-gradient-to-r from-[#2F6FED] to-[#22C1C3]' : 'bg-gradient-to-r from-[#FF7A45] to-[#FFB13D]' }}">Langkah 3 dari 3</p>
            <h1 class="text-xl md:text-2xl font-extrabold text-[#003366] mb-2">Lengkapi profilmu</h1>
            <p class="text-gray-500 text-sm mb-8">Data ini dipakai untuk mencocokkan hasil tesmu dengan sekolah dan rekomendasi jurusan.</p>

            <form method="POST" action="{{ route('lengkapi-profil.submit') }}" class="space-y-4">
                @csrf

                <div class="space-y-1.5">
                    <label for="name" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Nama lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required
                        class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm transition">
                    <p class="text-[10px] text-gray-400 italic">Diambil dari akun Google, sesuaikan jika belum lengkap.</p>
                    @error('name')
                        <p class="text-[11px] text-red-500 mt-0.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Email (dari Google)</label>
                    <input type="text" value="{{ Auth::user()->email }}" disabled
                        class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-sm text-gray-500">
                </div>

                <div class="space-y-1.5">
                    <label for="nisn" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">NISN</label>
                    <input type="text" id="nisn" name="nisn" maxlength="10" placeholder="10 digit Nomor Induk Siswa Nasional" value="{{ old('nisn') }}" required
                        class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm transition">
                    @error('nisn')
                        <p class="text-[11px] text-red-500 mt-0.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="asal_sekolah" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Asal sekolah</label>
                    <input type="text" id="asal_sekolah" name="asal_sekolah" placeholder="Contoh: SMP Negeri 1 Jakarta" value="{{ old('asal_sekolah') }}" required
                        class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm transition">
                    @error('asal_sekolah')
                        <p class="text-[11px] text-red-500 mt-0.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="kelas" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Kelas</label>
                    <select id="kelas" name="kelas" required
                        class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm transition">
                        <option value="" disabled {{ old('kelas') ? '' : 'selected' }}>Pilih kelas</option>
                        @foreach($kelasOptions as $k)
                            <option value="{{ $k }}" {{ old('kelas') == $k ? 'selected' : '' }}>Kelas {{ $k }}</option>
                        @endforeach
                    </select>
                    @error('kelas')
                        <p class="text-[11px] text-red-500 mt-0.5">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-start gap-2 text-xs text-gray-500 pt-2">
                    <input type="checkbox" required class="mt-0.5">
                    Saya menyetujui bahwa data di atas benar dan digunakan untuk keperluan asesmen ini.
                </label>

                <button type="submit"
                    class="w-full bg-[#003E70] hover:bg-[#002B4E] text-white py-3.5 px-6 rounded-full font-bold text-sm flex items-center justify-center gap-2 shadow-lg shadow-blue-900/10 transition duration-200 mt-2">
                    Simpan dan Lanjutkan <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>

</body>
</html>