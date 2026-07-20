<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk sebagai Admin - Bakat Minat</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8fafc] font-sans text-gray-800 min-h-screen flex items-center justify-center relative overflow-x-hidden py-10">

    <div class="absolute w-72 h-72 bg-[#0f766e]/10 rounded-full -top-16 -left-16"></div>
    <div class="absolute w-64 h-64 bg-[#003366]/10 rounded-full -bottom-10 -right-10"></div>

    <div class="w-full max-w-xl relative z-10 px-4">
        <div class="flex items-center justify-center gap-2 text-[#003366] font-bold text-xl mb-8">
            <i class="fa-solid fa-graduation-cap"></i> <span>Bakat Minat</span>
        </div>

        <div class="bg-white rounded-3xl shadow-lg p-8 text-center">
            <span class="inline-block bg-[#003366] text-white text-[10px] font-bold px-3 py-1.5 rounded-full mb-4">MASUK SEBAGAI ADMIN</span>
            <h1 class="text-xl font-extrabold text-gray-800 mb-2">Kamu masuk sebagai apa?</h1>
            <p class="text-sm text-gray-500 mb-8">Pilih salah satu sesuai peranmu.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('guru-bk.login') }}" class="group rounded-2xl p-6 text-white text-left shadow-md hover:scale-[1.02] transition-transform" style="background: linear-gradient(135deg, #0f766e, #14b8a6);">
                    <i class="fa-solid fa-school text-2xl mb-3"></i>
                    <h3 class="font-bold text-base mb-1">Admin Sekolah</h3>
                    <p class="text-xs text-white/85">Guru BK, pantau siswa bina di sekolahmu.</p>
                </a>
                <a href="{{ route('kemendikdasmen.login') }}" class="group rounded-2xl p-6 text-white text-left shadow-md hover:scale-[1.02] transition-transform" style="background: linear-gradient(135deg, #003366, #0d3f70);">
                    <i class="fa-solid fa-building-columns text-2xl mb-3"></i>
                    <h3 class="font-bold text-base mb-1">Admin Direktorat SMK</h3>
                    <p class="text-xs text-white/85">Kelola platform secara keseluruhan.</p>
                </a>
            </div>

            <a href="{{ route('mulai') }}" class="inline-block text-xs font-bold text-gray-400 hover:text-gray-600 mt-8">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>
    </div>

</body>
</html>