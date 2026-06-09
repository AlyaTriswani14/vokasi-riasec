<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skoring Detail RIASEC - Pilih Jalanmu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8fafc] font-sans text-gray-800 min-h-screen flex flex-col relative pb-24">

    <div class="w-full flex justify-between items-center p-4 md:px-8 bg-[#f8fafc] border-b border-gray-100">
        <div class="flex items-center gap-2 text-[#003366] font-bold text-lg">
            <i class="fa-solid fa-graduation-cap"></i>
            <span>Pilih Jalanmu</span>
        </div>
        <div class="flex items-center gap-4">
            <button class="text-gray-500 hover:text-gray-700">
                <i class="fa-regular fa-bell text-xl"></i>
            </button>
            <div class="w-8 h-8 rounded-full bg-[#00558f] text-white flex items-center justify-center font-bold text-xs">
                {{ Auth::check() ? strtoupper(substr(Auth::user()->name, 0, 2)) : 'PP' }}
            </div>
        </div>
    </div>

    @php
        $skor = $hasil['skor_lengkap'];
        $dominanKode = array_key_first($hasil['top3']);
        $totalYa = array_sum($skor);
        $maxSkor = max($skor);

        $scoringData = [
            'R' => ['nama' => 'Realistic (R)', 'warna' => 'bg-[#3b82f6]', 'nomor' => '1, 7, 14, 22, 30, 32, 37'],
            'I' => ['nama' => 'Investigative (I)', 'warna' => 'bg-[#8b5cf6]', 'nomor' => '2, 11, 18, 21, 26, 33, 39'],
            'A' => ['nama' => 'Artistic (A)', 'warna' => 'bg-[#f59e0b]', 'nomor' => '3, 8, 17, 23, 27, 31, 41'],
            'S' => ['nama' => 'Social (S)', 'warna' => 'bg-[#10b981]', 'nomor' => '4, 12, 13, 20, 28, 34, 40'],
            'E' => ['nama' => 'Enterprising (E)', 'warna' => 'bg-[#ef4444]', 'nomor' => '5, 10, 16, 19, 29, 36, 42'],
            'C' => ['nama' => 'Conventional (C)', 'warna' => 'bg-[#64748b]', 'nomor' => '6, 9, 15, 24, 25, 35, 38'],
        ];

        $deskripsiDominan = [
            'R' => 'Anda menikmati pekerjaan yang melibatkan praktik langsung, penggunaan alat, atau aktivitas di luar ruangan.',
            'I' => 'Anda gemar menganalisis data, memecahkan masalah kompleks, dan mengeksplorasi ilmu pengetahuan.',
            'A' => 'Anda menikmati tugas-tugas kreatif yang melibatkan imajinasi, ekspresi diri, dan lingkungan kerja yang tidak terlalu kaku.',
            'S' => 'Anda merasa paling termotivasi saat membantu, mendidik, atau berinteraksi dengan orang lain.',
            'E' => 'Anda memiliki jiwa kepemimpinan yang kuat, menyukai tantangan bisnis, dan pandai memengaruhi orang lain.',
            'C' => 'Anda sangat teliti, menyukai keteraturan, dan unggul dalam mengelola data serta prosedur yang terstruktur.'
        ];

        $saranKarier = [
            'R' => [
                ['judul' => 'Teknik & Mesin', 'ikon' => 'fa-solid fa-gear', 'bg' => 'bg-[#e0f2fe]', 'text' => 'text-[#0284c7]', 'list' => ['Teknik Mesin', 'Otomotif', 'Operator Alat Berat']],
                ['judul' => 'Konstruksi & Lapangan', 'ikon' => 'fa-solid fa-helmet-safety', 'bg' => 'bg-[#ffedd5]', 'text' => 'text-[#ea580c]', 'list' => ['Arsitektur', 'Pertanian', 'Logistik']]
            ],
            'I' => [
                ['judul' => 'Sains & Riset', 'ikon' => 'fa-solid fa-flask', 'bg' => 'bg-[#dcfce7]', 'text' => 'text-[#16a34a]', 'list' => ['Peneliti Sains', 'Kimia Analisis', 'Ahli Biologi']],
                ['judul' => 'Teknologi & Data', 'ikon' => 'fa-solid fa-laptop-code', 'bg' => 'bg-[#f3e8ff]', 'text' => 'text-[#9333ea]', 'list' => ['Programmer', 'Data Analyst', 'Ahli Farmasi']]
            ],
            'A' => [
                ['judul' => 'Desain & Seni Kreatif', 'ikon' => 'fa-solid fa-palette', 'bg' => 'bg-[#ecfdf5]', 'text' => 'text-[#059669]', 'list' => ['Desainer Grafis', 'Arsitek Lanskap', 'Pengembang Game']],
                ['judul' => 'Komunikasi & Media', 'ikon' => 'fa-solid fa-pen-nib', 'bg' => 'bg-[#f5ebe0]', 'text' => 'text-[#92400e]', 'list' => ['Penulis Konten', 'Jurnalis', 'Spesialis Humas']]
            ],
            'S' => [
                ['judul' => 'Pendidikan & Pelatihan', 'ikon' => 'fa-solid fa-chalkboard-user', 'bg' => 'bg-[#e0e7ff]', 'text' => 'text-[#4f46e5]', 'list' => ['Guru/Pengajar', 'Dosen', 'Instruktur Pelatihan']],
                ['judul' => 'Kesehatan & Sosial', 'ikon' => 'fa-solid fa-heart-pulse', 'bg' => 'bg-[#ffe4e6]', 'text' => 'text-[#e11d48]', 'list' => ['Perawat', 'Psikolog', 'Pekerja Sosial']]
            ],
            'E' => [
                ['judul' => 'Bisnis & Pemasaran', 'ikon' => 'fa-solid fa-chart-line', 'bg' => 'bg-[#fef9c3]', 'text' => 'text-[#ca8a04]', 'list' => ['Manajer Pemasaran', 'Wirausahawan', 'Sales/Penjualan']],
                ['judul' => 'Manajemen & Hukum', 'ikon' => 'fa-solid fa-scale-balanced', 'bg' => 'bg-[#e2e8f0]', 'text' => 'text-[#475569]', 'list' => ['Manajer Proyek', 'Pengacara', 'Politikus']]
            ],
            'C' => [
                ['judul' => 'Keuangan & Akuntansi', 'ikon' => 'fa-solid fa-calculator', 'bg' => 'bg-[#d1fae5]', 'text' => 'text-[#059669]', 'list' => ['Akuntan', 'Auditor Keuangan', 'Teller Bank']],
                ['judul' => 'Administrasi & Data', 'ikon' => 'fa-solid fa-folder-open', 'bg' => 'bg-[#e0f2fe]', 'text' => 'text-[#0284c7]', 'list' => ['Staf Administrasi', 'Data Entry', 'Sekretaris']]
            ]
        ];
    @endphp

    <main class="flex-grow w-full max-w-4xl mx-auto px-4 pt-6 pb-12 flex flex-col gap-6">

        <div class="bg-[#00558f] rounded-2xl p-6 md:p-8 text-white relative overflow-hidden shadow-md">
            <div class="relative z-10 w-full md:w-3/4">
                <h1 class="text-xl md:text-2xl font-semibold mb-2">Hasil Skoring Otomatis</h1>
                <p class="text-sm md:text-base text-blue-100 leading-relaxed">
                    Analisis minat bakat berdasarkan model RIASEC. Skor dihitung secara otomatis oleh sistem berdasarkan setiap jawaban <span class="font-bold">"Ya"</span> yang Anda berikan.
                </p>
            </div>
            <div class="absolute -bottom-4 -right-4 opacity-10">
                <i class="fa-solid fa-chart-column text-9xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-table-columns text-[#0f766e] text-lg"></i>
                    <h2 class="font-bold text-[#003366] text-lg">Ringkasan Skor RIASEC</h2>
                </div>
                <span class="bg-[#a7f3d0] text-[#047857] text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">Tervalidasi</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#003366] text-white text-xs uppercase tracking-wider">
                            <th class="py-3 px-6 font-semibold w-1/3">Tipe Minat</th>
                            <th class="py-3 px-6 font-semibold w-1/2">Daftar Nomor</th>
                            <th class="py-3 px-6 font-semibold text-center w-1/6">Skor</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach(['R', 'I', 'A', 'S', 'E', 'C'] as $kode)
                            <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                <td class="py-3.5 px-6 flex items-center gap-3">
                                    <div class="w-1.5 h-5 rounded-full {{ $scoringData[$kode]['warna'] }}"></div>
                                    <span class="font-bold text-[#003366]">{{ $scoringData[$kode]['nama'] }}</span>
                                </td>
                                <td class="py-3.5 px-6 text-gray-500 font-medium">
                                    {{ $scoringData[$kode]['nomor'] }}
                                </td>
                                <td class="py-3.5 px-6 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full font-bold shadow-sm 
                                        {{ $skor[$kode] == $maxSkor ? 'bg-[#00558f] text-white' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $skor[$kode] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 border border-gray-200 rounded-2xl p-6 bg-white shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <i class="fa-regular fa-lightbulb text-[#0f766e] text-xl"></i>
                        <h3 class="font-bold text-[#003366] text-lg">Hasil Dominan: {{ explode(' ', $scoringData[$dominanKode]['nama'])[0] }}</h3>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed mb-6">
                        Berdasarkan skoring otomatis, Anda memiliki kecenderungan tinggi pada tipe <span class="font-bold text-gray-800">{{ explode(' ', $scoringData[$dominanKode]['nama'])[0] }}</span>. {{ $deskripsiDominan[$dominanKode] }}
                    </p>
                </div>
                <a href="{{ route('assessment.result') }}" class="text-[#00558f] font-semibold text-sm hover:underline flex items-center gap-2 w-fit">
                    Lihat Detail Karir <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="bg-[#003366] rounded-2xl p-6 text-white relative overflow-hidden shadow-sm flex flex-col justify-center">
                <div class="relative z-10">
                    <p class="text-blue-200 text-xs font-bold tracking-widest uppercase mb-1">Total Pertanyaan</p>
                    <h2 class="text-5xl font-extrabold mb-3">42</h2>
                    <p class="text-sm text-blue-100">Terjawab 'Ya' pada <span class="font-bold text-white">{{ $totalYa }}</span> pertanyaan.</p>
                </div>
                <div class="absolute top-4 right-4 opacity-10 bg-white/20 w-16 h-16 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-check text-4xl"></i>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="flex items-center gap-2 mb-4 px-1">
                <i class="fa-regular fa-compass text-[#003366] text-xl"></i>
                <h3 class="font-bold text-[#003366] text-lg">Saran Jalur Karir</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($saranKarier[$dominanKode] as $karir)
                    <div class="border border-gray-100 rounded-xl p-5 bg-[#f8fafc] shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-lg {{ $karir['bg'] }} {{ $karir['text'] }} flex items-center justify-center text-lg">
                                <i class="{{ $karir['ikon'] }}"></i>
                            </div>
                            <h4 class="font-bold text-[#00558f]">{{ $karir['judul'] }}</h4>
                        </div>
                        <ul class="space-y-2.5">
                            @foreach($karir['list'] as $item)
                                <li class="flex items-start gap-2 text-sm text-gray-700 font-medium">
                                    <span class="text-[#0f766e] mt-1 text-[10px]"><i class="fa-solid fa-circle"></i></span>
                                    {{ $item }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-gray-50 border border-gray-200 border-dashed rounded-xl p-4 flex gap-3 text-sm text-gray-600 mt-2">
            <i class="fa-solid fa-circle-info mt-0.5 text-gray-400"></i>
            <p>Halaman ini bersifat referensi untuk Admin dan Siswa. Data skoring ini bersifat final setelah proses tes diselesaikan oleh sistem. Konsultasikan hasil ini dengan guru BK Anda untuk perencanaan karir yang lebih mendalam.</p>
        </div>

    </main>

    <div class="fixed bottom-0 w-full bg-white border-t border-gray-200 flex justify-center gap-16 md:gap-32 items-center pt-2 pb-4 px-6 z-50 shadow-[0_-4px_10px_rgba(0,0,0,0.02)]">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-16 text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fa-solid fa-house text-xl md:text-2xl mb-1"></i>
            <span class="text-[10px] md:text-xs font-medium">Beranda</span>
        </a>
        <a href="#" class="flex flex-col items-center justify-center w-16 text-[#0f766e]">
            <div class="bg-[#ccfbf1] w-14 h-14 md:w-16 md:h-16 rounded-full flex flex-col items-center justify-center -mt-6 md:-mt-8 shadow-sm border border-[#a7f3d0]">
                <i class="fa-solid fa-chart-pie text-xl md:text-2xl"></i>
            </div>
            <span class="text-[10px] md:text-xs font-bold mt-1">Skoring</span>
        </a>
        <a href="#" class="flex flex-col items-center justify-center w-16 text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fa-regular fa-user text-xl md:text-2xl mb-1"></i>
            <span class="text-[10px] md:text-xs font-medium">Profil</span>
        </a>
    </div>

</body>
</html>