<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Tes Minat RIASEC - Bakat Minat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8fafc] font-sans text-gray-800 min-h-screen flex flex-col relative pb-24">

    @php
        $isSmk = (Auth::user()->jenjang ?? 'smp') === 'smk';
        $gradFrom = $isSmk ? '#2F6FED' : '#FF7A45';
        $gradTo = $isSmk ? '#22C1C3' : '#FFB13D';
        $accentText = $isSmk ? 'text-[#2F6FED]' : 'text-[#c2410c]';
        $accentBg = $isSmk ? 'bg-blue-50' : 'bg-orange-50';
        $accentBorder = $isSmk ? 'border-blue-100' : 'border-orange-100';
        $accentBtn = $isSmk ? 'bg-[#2F6FED] hover:bg-[#255bc4]' : 'bg-[#FF7A45] hover:bg-[#e8672f]';

        // Palet warna disamakan dengan yang dipakai di halaman Eksplorasi (donut chart)
        $riasecData = [
            'R' => [
                'nama' => 'Realistic', 'label' => 'Praktis',
                'warna' => 'bg-[#EF4444]', 'teks_warna' => 'text-[#EF4444]', 'bg_warna' => 'bg-red-50',
                'icon' => 'fa-solid fa-screwdriver-wrench',
                'deskripsi' => 'Kamu suka bekerja dengan alat, mesin, atau aktivitas fisik yang memberikan hasil nyata dan terukur.',
                'rekomendasi' => 'Teknik Mesin, Teknik Ketenagalistrikan, Konstruksi & Properti, Otomotif, Pertanian.'
            ],
            'I' => [
                'nama' => 'Investigative', 'label' => 'Pemikir',
                'warna' => 'bg-[#3B82F6]', 'teks_warna' => 'text-[#3B82F6]', 'bg_warna' => 'bg-blue-50',
                'icon' => 'fa-solid fa-microscope',
                'deskripsi' => 'Kamu gemar mengamati, belajar, dan menganalisis masalah kompleks untuk menemukan solusi logis.',
                'rekomendasi' => 'Teknik Komputer & Jaringan, Kimia Analisis, Farmasi, Rekayasa Perangkat Lunak.'
            ],
            'A' => [
                'nama' => 'Artistic', 'label' => 'Kreatif',
                'warna' => 'bg-[#F97316]', 'teks_warna' => 'text-[#F97316]', 'bg_warna' => 'bg-orange-50',
                'icon' => 'fa-solid fa-palette',
                'deskripsi' => 'Kamu memiliki jiwa ekspresif, orisinal, dan menyukai kebebasan dalam berkreasi dan berekspresi.',
                'rekomendasi' => 'DKV (Desain Komunikasi Visual), Multimedia, Seni Lukis, Animasi, Tata Busana.'
            ],
            'S' => [
                'nama' => 'Social', 'label' => 'Penolong',
                'warna' => 'bg-[#06B6D4]', 'teks_warna' => 'text-[#06B6D4]', 'bg_warna' => 'bg-cyan-50',
                'icon' => 'fa-solid fa-hand-holding-heart',
                'deskripsi' => 'Kamu merasa puas saat bisa berinteraksi, membantu, mendidik, atau melayani orang lain.',
                'rekomendasi' => 'Keperawatan, Pekerjaan Sosial, Pariwisata, Perhotelan, Tata Boga.'
            ],
            'E' => [
                'nama' => 'Enterprising', 'label' => 'Pemimpin',
                'warna' => 'bg-[#F59E0B]', 'teks_warna' => 'text-[#F59E0B]', 'bg_warna' => 'bg-amber-50',
                'icon' => 'fa-solid fa-bullhorn',
                'deskripsi' => 'Kamu memengaruhi orang lain, berani mengambil keputusan, dan mengejar target bisnis atau organisasi.',
                'rekomendasi' => 'Bisnis Daring dan Pemasaran, Manajemen Perkantoran, Usaha Perjalanan Wisata.'
            ],
            'C' => [
                'nama' => 'Conventional', 'label' => 'Teratur',
                'warna' => 'bg-[#10B981]', 'teks_warna' => 'text-[#10B981]', 'bg_warna' => 'bg-emerald-50',
                'icon' => 'fa-solid fa-file-invoice',
                'deskripsi' => 'Kamu senang dengan pekerjaan yang rapi, terstruktur, detail, dan bekerja dengan data atau aturan yang jelas.',
                'rekomendasi' => 'Akuntansi dan Keuangan Lembaga, Otomatisasi Tata Kelola Perkantoran, Perbankan.'
            ],
        ];

        $top3 = $hasil['top3'];
        $namaUser = Auth::check() ? Auth::user()->name : 'Siswa';
    @endphp

    <div class="w-full flex justify-between items-center p-4 md:px-8 bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
        <div class="flex items-center gap-2 text-[#003366] font-bold text-lg">
            <i class="fa-solid fa-graduation-cap"></i>
            <span>Bakat Minat</span>
        </div>
        <button class="text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-share-nodes text-xl"></i>
        </button>
    </div>

    <main class="flex-grow w-full max-w-3xl mx-auto px-4 pt-6 pb-12 flex flex-col gap-5">

        {{-- Hero selamat --}}
        <div class="rounded-3xl p-6 md:p-8 shadow-lg relative overflow-hidden text-white text-center" style="background: linear-gradient(135deg, {{ $gradFrom }}, {{ $gradTo }});">
            <div class="absolute w-32 h-32 bg-white/15 rounded-full -top-10 -right-10"></div>
            <div class="absolute w-24 h-24 bg-white/10 rounded-full -bottom-8 -left-8"></div>
            <div class="relative z-10 flex flex-col items-center">
                <div class="bg-white/20 border-2 border-white/40 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-solid fa-certificate text-2xl"></i>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold mb-3">Selamat, {{ explode(' ', $namaUser)[0] }}!</h1>
                <p class="text-white/85 text-sm md:text-base max-w-lg mx-auto">Hasil tesmu telah selesai. Cek tipe minat dominanmu dan rekomendasi jurusan yang cocok di bawah ini.</p>
            </div>
        </div>

        {{-- Profil minat dominan --}}
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border {{ $accentBorder }}">
            <h2 class="text-center {{ $accentText }} font-bold text-lg mb-8">Profil Minat Dominan</h2>

            <div class="flex justify-center items-end gap-4 md:gap-8 h-48">
                @foreach($top3 as $kode => $skor)
                @php
                    $persen = round(($skor / 7) * 100);
                    $data = $riasecData[$kode];
                @endphp
                <div class="flex flex-col items-center w-20 md:w-24">
                    <div class="w-full bg-gray-100 rounded-t-lg h-32 relative overflow-hidden flex items-end">
                        <div class="w-full {{ $data['warna'] }} flex items-center justify-center text-white font-bold text-xl md:text-2xl transition-all duration-1000 ease-out" style="height: {{ $persen }}%;">
                            {{ $kode }}
                        </div>
                    </div>
                    <p class="font-bold {{ $data['teks_warna'] }} mt-3 text-sm md:text-base">{{ $persen }}%</p>
                    <p class="text-xs md:text-sm text-gray-800 font-medium">{{ $data['nama'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Detail minat --}}
        <div>
            <h2 class="text-lg font-bold text-gray-800 mb-3">Detail Minat Kamu</h2>

            <div class="flex flex-col gap-4">
                @foreach($top3 as $kode => $skor)
                @php $data = $riasecData[$kode]; @endphp
                <div class="bg-white border {{ $accentBorder }} rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex gap-4">
                        <div class="w-12 h-12 rounded-xl {{ $data['bg_warna'] }} {{ $data['teks_warna'] }} flex items-center justify-center text-2xl shrink-0">
                            <i class="{{ $data['icon'] }}"></i>
                        </div>
                        <div>
                            <h3 class="font-bold {{ $data['teks_warna'] }} text-lg">{{ $data['nama'] }} ({{ $data['label'] }})</h3>
                            <p class="text-gray-600 text-sm mt-1 leading-relaxed">{{ $data['deskripsi'] }}</p>
                        </div>
                    </div>
                    <div class="mt-4 {{ $accentBg }} rounded-xl p-4">
                        <p class="text-[11px] font-bold {{ $accentText }} tracking-widest mb-1.5">REKOMENDASI SMK:</p>
                        <p class="text-sm font-medium text-gray-800">{{ $data['rekomendasi'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
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