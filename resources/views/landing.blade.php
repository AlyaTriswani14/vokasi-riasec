<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Jalanmu - Asesmen Holland RIASEC</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="font-sans min-h-screen flex items-center justify-center p-6 relative overflow-hidden" style="background: linear-gradient(160deg, #6C4CF1 0%, #A34CF1 45%, #F1533D 100%);">

    <div class="absolute w-72 h-72 bg-white/10 rounded-full -top-16 -right-10"></div>
    <div class="absolute w-56 h-56 bg-white/10 rounded-full top-1/3 -left-16"></div>
    <div class="absolute w-40 h-40 bg-white/10 rounded-full bottom-10 right-1/4"></div>

    <div class="relative z-10 w-full max-w-md text-center text-white">
        <div class="bg-white/15 backdrop-blur w-16 h-16 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-8">
            🎓
        </div>

        <p class="text-xs font-bold uppercase tracking-widest text-white/80 mb-4">Asesmen Holland RIASEC</p>
        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-5">Yuk, temukan<br>jalan serumu!</h1>
        <p class="text-white/85 text-sm md:text-base leading-relaxed mb-10 max-w-sm mx-auto">
            Kenali minat & bakatmu lewat tes seru, dapatkan rekomendasi jurusan yang paling cocok buat masa depanmu.
        </p>

        <div class="flex items-center justify-center -space-x-3 mb-6">
            <div class="w-10 h-10 rounded-full bg-[#FFD166] border-2 border-white flex items-center justify-center text-base">🧑</div>
            <div class="w-10 h-10 rounded-full bg-[#4CD9C0] border-2 border-white flex items-center justify-center text-base">👩</div>
            <div class="w-10 h-10 rounded-full bg-[#FF7A9E] border-2 border-white flex items-center justify-center text-base">🧑‍🎤</div>
            <div class="w-10 h-10 rounded-full bg-white/20 border-2 border-white flex items-center justify-center text-[11px] font-bold">12K+</div>
        </div>

        <a href="{{ route('mulai') }}"
           class="inline-flex items-center justify-center gap-2 bg-white text-[#6C4CF1] font-bold text-sm py-4 px-10 rounded-2xl shadow-lg hover:shadow-xl transition">
            Mulai Sekarang <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

</body>
</html>