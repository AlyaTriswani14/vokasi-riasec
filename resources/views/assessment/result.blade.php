<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Tes Minat RIASEC - Pilih Jalanmu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8fafc] font-sans text-gray-800 min-h-screen flex flex-col relative pb-24">

    <div class="w-full flex justify-between items-center p-4 md:px-8 bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
        <div class="flex items-center gap-2 text-[#003366] font-bold text-lg">
            <i class="fa-solid fa-graduation-cap"></i>
            <span>Pilih Jalanmu</span>
        </div>
        <button class="text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-share-nodes text-xl"></i>
        </button>
    </div>

    @php
        $riasecData = [
            'R' => [
                'nama' => 'Realistic',
                'label' => 'Praktis',
                'warna' => 'bg-[#003366]',
                'teks_warna' => 'text-[#003366]',
                'bg_warna' => 'bg-[#e6f0fa]',
                'icon' => 'fa-solid fa-screwdriver-wrench',
                'deskripsi' => 'Kamu suka bekerja dengan alat, mesin, atau aktivitas fisik yang memberikan hasil nyata dan terukur.',
                'rekomendasi' => 'Teknik Mesin, Teknik Ketenagalistrikan, Konstruksi & Properti, Otomotif, Pertanian.'
            ],
            'I' => [
                'nama' => 'Investigative',
                'label' => 'Pemikir',
                'warna' => 'bg-[#0f766e]',
                'teks_warna' => 'text-[#0f766e]',
                'bg_warna' => 'bg-[#ccfbf1]',
                'icon' => 'fa-solid fa-microscope',
                'deskripsi' => 'Kamu gemar mengamati, belajar, dan menganalisis masalah kompleks untuk menemukan solusi logis.',
                'rekomendasi' => 'Teknik Komputer & Jaringan, Kimia Analisis, Farmasi, Rekayasa Perangkat Lunak.'
            ],
            'A' => [
                'nama' => 'Artistic',
                'label' => 'Kreatif',
                'warna' => 'bg-[#92400e]',
                'teks_warna' => 'text-[#92400e]',
                'bg_warna' => 'bg-[#fef3c7]',
                'icon' => 'fa-solid fa-palette',
                'deskripsi' => 'Kamu memiliki jiwa ekspresif, orisinal, dan menyukai kebebasan dalam berkreasi dan berekspresi.',
                'rekomendasi' => 'DKV (Desain Komunikasi Visual), Multimedia, Seni Lukis, Animasi, Tata Busana.'
            ],
            'S' => [
                'nama' => 'Social',
                'label' => 'Penolong',
                'warna' => 'bg-[#0369a1]',
                'teks_warna' => 'text-[#0369a1]',
                'bg_warna' => 'bg-[#e0f2fe]',
                'icon' => 'fa-solid fa-hand-holding-heart',
                'deskripsi' => 'Kamu merasa puas saat bisa berinteraksi, membantu, mendidik, atau melayani orang lain.',
                'rekomendasi' => 'Keperawatan, Pekerjaan Sosial, Pariwisata, Perhotelan, Tata Boga.'
            ],
            'E' => [
                'nama' => 'Enterprising',
                'label' => 'Pemimpin',
                'warna' => 'bg-[#b91c1c]',
                'teks_warna' => 'text-[#b91c1c]',
                'bg_warna' => 'bg-[#fee2e2]',
                'icon' => 'fa-solid fa-bullhorn',
                'deskripsi' => 'Kamu memengaruhi orang lain, berani mengambil keputusan, dan mengejar target bisnis atau organisasi.',
                'rekomendasi' => 'Bisnis Daring dan Pemasaran, Manajemen Perkantoran, Usaha Perjalanan Wisata.'
            ],
            'C' => [
                'nama' => 'Conventional',
                'label' => 'Teratur',
                'warna' => 'bg-[#4d7c0f]',
                'teks_warna' => 'text-[#4d7c0f]',
                'bg_warna' => 'bg-[#ecfccb]',
                'icon' => 'fa-solid fa-file-invoice',
                'deskripsi' => 'Kamu senang dengan pekerjaan yang rapi, terstruktur, detail, dan bekerja dengan data atau aturan yang jelas.',
                'rekomendasi' => 'Akuntansi dan Keuangan Lembaga, Otomatisasi Tata Kelola Perkantoran, Perbankan.'
            ],
        ];

        $top3 = $hasil['top3'];
        $namaUser = Auth::check() ? Auth::user()->name : 'Siswa';
    @endphp

    <main class="flex-grow w-full max-w-3xl mx-auto px-4 pt-8 pb-12 flex flex-col">

        <div class="text-center mb-8 flex flex-col items-center">
            <div class="bg-[#a7f3d0] w-16 h-16 rounded-full flex items-center justify-center mb-4 shadow-sm">
                <i class="fa-solid fa-certificate text-[#047857] text-3xl"></i>
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-[#003366] mb-3">Selamat, {{ explode(' ', $namaUser)[0] }}!</h1>
            <p class="text-gray-600 text-sm md:text-base max-w-lg mx-auto">Hasil tesmu telah selesai. Kamu memiliki potensi luar biasa di bidang yang membutuhkan kecerdasan teknis dan eksplorasi minatmu.</p>
        </div>

        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-gray-100 mb-10">
            <h2 class="text-center text-[#003366] font-bold text-lg mb-8">Profil Minat Dominan</h2>
            
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

        <div class="border-l-4 border-[#003366] pl-3 mb-6 mt-4">
            <h2 class="text-xl font-bold text-gray-800">Detail Minat Kamu</h2>
        </div>

        <div class="space-y-4 mb-8">
            @foreach($top3 as $kode => $skor)
            @php $data = $riasecData[$kode]; @endphp
            <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex gap-4">
                    <div class="w-12 h-12 rounded-xl {{ $data['bg_warna'] }} {{ $data['teks_warna'] }} flex items-center justify-center text-2xl shrink-0">
                        <i class="{{ $data['icon'] }}"></i>
                    </div>
                    <div>
                        <h3 class="font-bold {{ $data['teks_warna'] }} text-lg">{{ $data['nama'] }} ({{ $data['label'] }})</h3>
                        <p class="text-gray-600 text-sm mt-1 leading-relaxed">{{ $data['deskripsi'] }}</p>
                    </div>
                </div>
                <div class="mt-4 bg-[#f8fafc] border border-gray-100 rounded-xl p-4">
                    <p class="text-[11px] font-bold text-[#003366] tracking-widest mb-1.5">REKOMENDASI SMK:</p>
                    <p class="text-sm font-medium text-gray-800">{{ $data['rekomendasi'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="relative rounded-2xl overflow-hidden shadow-sm h-40 md:h-48 mb-8">
            <img src="{{ asset('images/banner-smk.png') }}" alt="Banner Siswa" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
            <div class="absolute inset-0 p-6 flex flex-col justify-end">
                <h3 class="text-white font-bold text-lg md:text-xl mb-1">Mulai Langkahmu di SMK Impian</h3>
                <p class="text-gray-200 text-sm">Temukan ribuan sekolah yang cocok dengan minatmu sekarang.</p>
            </div>
        </div>

        <div class="flex flex-col gap-3">
            <a href="{{ route('sekolah.explore') }}" class="w-full bg-[#004080] hover:bg-[#003366] text-white font-bold py-3.5 px-4 rounded-xl transition-colors shadow-md text-sm md:text-base flex justify-center items-center gap-2 text-center">
                <i class="fa-solid fa-compass"></i> Eksplorasi Jurusan SMK
            </a>
            
            <a href="{{ route('assessment.scoring') }}" class="w-full bg-[#0f766e] hover:bg-[#115e59] text-white font-bold py-3.5 px-4 rounded-xl transition-colors shadow-md text-sm md:text-base flex justify-center items-center gap-2 text-center">
                <i class="fa-solid fa-chart-pie"></i> Lihat Analisis & Ringkasan Skor
            </a>

            <button class="w-full bg-white border border-[#004080] text-[#004080] hover:bg-gray-50 font-bold py-3.5 px-4 rounded-xl transition-colors text-sm md:text-base flex justify-center items-center gap-2">
                <i class="fa-regular fa-file-pdf"></i> Unduh Hasil (PDF)
            </button>
        </div>

    </main>

    <div class="fixed bottom-0 w-full bg-white border-t border-gray-200 flex justify-center gap-16 md:gap-32 items-center pt-2 pb-4 px-6 z-50 shadow-[0_-4px_10px_rgba(0,0,0,0.02)]">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-16 text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fa-solid fa-house text-xl md:text-2xl mb-1"></i>
            <span class="text-[10px] md:text-xs font-medium">Beranda</span>
        </a>
        
        <a href="#" class="flex flex-col items-center justify-center w-16 text-[#0f766e]">
            <div class="bg-[#ccfbf1] w-14 h-14 md:w-16 md:h-16 rounded-full flex flex-col items-center justify-center -mt-6 md:-mt-8 shadow-sm border border-[#a7f3d0]">
                <i class="fa-regular fa-clipboard text-xl md:text-2xl"></i>
            </div>
            <span class="text-[10px] md:text-xs font-bold mt-1">Tes</span>
        </a>
        
        <a href="#" class="flex flex-col items-center justify-center w-16 text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fa-regular fa-user text-xl md:text-2xl mb-1"></i>
            <span class="text-[10px] md:text-xs font-medium">Profil</span>
        </a>
    </div>

</body>
</html>