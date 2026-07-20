<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar / Masuk - Pilih Jalanmu</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-slate-800 font-sans antialiased min-h-screen flex">

    <div class="hidden md:flex md:w-1/2 bg-[#0F355C] text-white p-12 flex-col justify-between relative overflow-hidden" style="background-image: url('{{ asset('images/bg-kelas.jpg') }}'); background-size: cover; background-blend-mode: overlay; background-color: rgba(15, 53, 92, 0.9);">
        <div class="absolute w-64 h-64 bg-gradient-to-br from-[#EC4899] to-[#7C3AED] opacity-30 rounded-full -top-10 -right-10 blur-2xl"></div>
        <div class="absolute w-64 h-64 bg-gradient-to-br from-[#22C1C3] to-[#2F6FED] opacity-30 rounded-full bottom-10 -left-16 blur-2xl"></div>
        <div class="relative z-10">
           <div class="bg-white text-black p-3 rounded-xl inline-block mb-10">
   <img src="{{ asset('images/logo-vokasi.png') }}" alt="Direktorat Vokasi" class="h-10">
</div>
           <h1 class="text-4xl lg:text-5xl font-extrabold leading-tight mb-6">Pilih Jalanmu, Tentukan Masa Depan Pendidikanmu.</h1>
           <p class="text-slate-300 text-base max-w-md">Platform Interaktif Pemetaan Minat, Bakat, dan Perencanaan Karier bagi Siswa Vokasi di Indonesia.</p>
        </div>
        <div class="relative z-10 text-xs text-slate-400">
            &copy; 2026 Tim Peserta Didik Direktorat SMK.
        </div>
    </div>

    <div class="w-full md:w-1/2 flex items-center justify-center p-8 relative overflow-hidden bg-gradient-to-br from-orange-50 via-white to-blue-50">
        <div class="absolute w-64 h-64 bg-gradient-to-br from-[#7C3AED] to-[#EC4899] opacity-10 rounded-full -top-10 -right-16"></div>
        <div class="absolute w-64 h-64 bg-gradient-to-br from-[#22C1C3] to-[#2F6FED] opacity-10 rounded-full -bottom-16 -left-10"></div>

        <div class="relative z-10 bg-white w-full max-w-[420px] rounded-[30px] shadow-xl p-10 border border-slate-100">

            <div class="flex items-center gap-2 mb-6">
                <div class="w-10 h-1.5 rounded-full bg-gradient-to-r from-[#7C3AED] to-[#EC4899]"></div>
                <div class="w-10 h-1.5 rounded-full bg-gradient-to-r from-[#7C3AED] to-[#EC4899]"></div>
                <div class="w-10 h-1.5 rounded-full bg-gray-200"></div>
            </div>

            <div class="mb-6">
                <span class="inline-block text-[10px] font-bold uppercase tracking-widest text-white px-4 py-1.5 rounded-full {{ session('jenjang') === 'smk' ? 'bg-gradient-to-r from-[#2F6FED] to-[#22C1C3]' : 'bg-gradient-to-r from-[#FF7A45] to-[#FFB13D]' }}">
                    Jenjang {{ strtoupper(session('jenjang', 'smp')) }} · Langkah 2 dari 3
                </span>
            </div>

            <div class="mb-8">
                <h2 class="text-2xl font-extrabold text-[#0F355C] mb-2">Daftar atau Masuk</h2>
                <p class="text-xs text-slate-500">Satu akun Google untuk daftar sekaligus masuk lain waktu, tidak perlu ingat password.</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-600 text-xs rounded-xl p-3">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <a href="{{ route('google.redirect') }}"
               class="w-full bg-white border-2 border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-bold py-3.5 rounded-xl flex items-center justify-center gap-3 transition duration-300">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
                <span>Daftar / Masuk dengan Google</span>
            </a>

            <p class="text-[10px] text-slate-400 text-center leading-relaxed mt-5">
                Dengan melanjutkan, kamu menyetujui data akun Google (nama & email) digunakan untuk keperluan asesmen ini.
            </p>

            <div class="text-center pt-6 mt-6 border-t border-slate-100">
                <a href="{{ route('mulai') }}" class="text-xs font-bold text-[#008073] hover:text-[#005c52] tracking-wider transition">
                    &larr; Ganti jenjang
                </a>
            </div>

        </div>
    </div>
</body>
</html>