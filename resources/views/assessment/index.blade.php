<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assessment - Bakat Minat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8fafc] font-sans text-gray-800 min-h-screen flex flex-col relative pb-24">

    @php
        $isSmk = (Auth::user()->jenjang ?? 'smp') === 'smk';
        $gradFrom = $isSmk ? '#2F6FED' : '#FF7A45';
        $gradTo = $isSmk ? '#22C1C3' : '#FFB13D';
        $accentText = $isSmk ? 'text-[#2F6FED]' : 'text-[#c2410c]';
        $accentBorder = $isSmk ? 'border-blue-100' : 'border-orange-100';
        $accentBtn = $isSmk ? 'bg-[#2F6FED] hover:bg-[#255bc4]' : 'bg-[#FF7A45] hover:bg-[#e8672f]';

        $tipeRiasec = [
            ['kode' => 'R', 'nama' => 'Realistic', 'icon' => 'fa-wrench', 'desc' => 'Suka kerja praktis: menggunakan alat, mesin, atau aktivitas fisik langsung.'],
            ['kode' => 'I', 'nama' => 'Investigative', 'icon' => 'fa-magnifying-glass', 'desc' => 'Suka meneliti, menganalisis data, dan memecahkan masalah secara logis.'],
            ['kode' => 'A', 'nama' => 'Artistic', 'icon' => 'fa-palette', 'desc' => 'Suka berekspresi kreatif lewat seni, musik, desain, atau tulisan.'],
            ['kode' => 'S', 'nama' => 'Social', 'icon' => 'fa-people-group', 'desc' => 'Suka membantu, mengajar, dan berinteraksi langsung dengan orang lain.'],
            ['kode' => 'E', 'nama' => 'Enterprising', 'icon' => 'fa-briefcase', 'desc' => 'Suka memimpin, meyakinkan orang lain, dan mengambil inisiatif/risiko.'],
            ['kode' => 'C', 'nama' => 'Conventional', 'icon' => 'fa-clipboard-list', 'desc' => 'Suka kerja terstruktur, rapi, detail, dan mengikuti prosedur yang jelas.'],
        ];
    @endphp

    <div class="w-full flex justify-between items-center p-4 md:px-8 bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-2 text-[#003366] font-bold text-lg">
            <i class="fa-solid fa-graduation-cap"></i> <span>Bakat Minat</span>
        </div>
        <div class="w-8 h-8 rounded-full bg-[#00558f] text-white flex items-center justify-center font-bold text-xs">
            {{ Auth::check() ? strtoupper(substr(Auth::user()->name, 0, 2)) : 'PP' }}
        </div>
    </div>

    <main class="flex-grow w-full max-w-4xl mx-auto px-4 pt-6 pb-12 flex flex-col gap-5">

        <div class="rounded-3xl p-6 shadow-lg relative overflow-hidden text-white" style="background: linear-gradient(135deg, {{ $gradFrom }}, {{ $gradTo }});">
            <div class="absolute w-32 h-32 bg-white/15 rounded-full -top-10 -right-10"></div>
            <div class="relative z-10">
                <h1 class="font-extrabold text-xl mb-1">Assessment RIASEC</h1>
                <p class="text-sm text-white/85">
                    Sebelum mulai, kenalan dulu yuk sama 6 tipe minat RIASEC di bawah ini.
                    Nanti hasil tes kamu akan dicocokkan ke salah satu (atau kombinasi) tipe ini.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($tipeRiasec as $t)
                <div class="bg-white border {{ $accentBorder }} rounded-2xl p-5 shadow-sm flex gap-4 items-start">
                    <div class="w-12 h-12 shrink-0 rounded-xl flex items-center justify-center text-lg text-white" style="background: linear-gradient(135deg, {{ $gradFrom }}, {{ $gradTo }});">
                        <i class="fa-solid {{ $t['icon'] }}"></i>
                    </div>
                    <div>
                        <h3 class="font-bold {{ $accentText }} text-base">{{ $t['nama'] }} <span class="text-gray-400 text-xs font-normal">({{ $t['kode'] }})</span></h3>
                        <p class="text-xs text-gray-600 mt-1">{{ $t['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="bg-white border {{ $accentBorder }} rounded-2xl p-6 shadow-sm flex flex-col items-center text-center gap-3 mt-2">
            <h2 class="font-bold text-lg text-gray-800">
                {{ $sudahTes ? 'Mau ulangi tes?' : 'Siap untuk mulai?' }}
            </h2>
            <p class="text-sm text-gray-500 max-w-sm">
                @if($sudahTes)
                    Kamu sudah pernah menyelesaikan tes ini. Kamu bisa mengulang kapan saja kalau minatmu berubah — hasil terbaru akan menggantikan yang lama di Dashboard.
                @else
                    Tes ini terdiri dari 42 pertanyaan Ya/Tidak dan bisa diselesaikan dalam waktu sekitar 10 menit.
                    Jawab sejujur-jujurnya sesuai apa yang kamu rasakan, bukan yang menurutmu "benar".
                @endif
            </p>
            <form action="{{ route('assessment.start') }}" method="POST">
                @csrf
                <button type="submit" class="{{ $accentBtn }} text-white font-bold text-sm py-3 px-8 rounded-xl transition-colors">
                    {{ $sudahTes ? 'Ulangi Tes' : 'Mulai Tes' }}
                </button>
            </form>
        </div>
    </main>

    <div class="fixed bottom-0 w-full bg-white border-t border-gray-200 flex justify-around items-center py-3 px-2 z-50 shadow-[0_-4px_10px_rgba(0,0,0,0.02)]">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center gap-1 text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fa-solid fa-house text-lg"></i>
            <span class="text-[10px] font-medium">Dashboard</span>
        </a>
        <a href="{{ route('assessment.index') }}" class="flex flex-col items-center justify-center gap-1 {{ $accentText }}">
            <i class="fa-regular fa-clipboard text-lg"></i>
            <span class="text-[10px] font-bold">Assessment</span>
        </a>
        <a href="{{ route('eksplorasi.index') }}" class="flex flex-col items-center justify-center gap-1 text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fa-solid fa-compass text-lg"></i>
            <span class="text-[10px] font-medium">Eksplorasi</span>
        </a>
        <a href="{{ route('rekomendasi.index') }}" class="flex flex-col items-center justify-center gap-1 text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fa-solid fa-bullseye text-lg"></i>
            <span class="text-[10px] font-medium">Rekomendasi</span>
        </a>
        <a href="{{ route('profil') }}" class="flex flex-col items-center justify-center gap-1 text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fa-regular fa-user text-lg"></i>
            <span class="text-[10px] font-medium">Profil</span>
        </a>
    </div>

</body>
</html>