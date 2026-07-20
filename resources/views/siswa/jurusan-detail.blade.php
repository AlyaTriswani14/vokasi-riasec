<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Jurusan - Bakat Minat</title>
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

        $potensiWarna = [
            'High Demand' => 'bg-[#a7f3d0] text-[#047857]',
            'Growing' => 'bg-[#e0e7ff] text-[#4f46e5]',
            'Specialist' => 'bg-[#ffedd5] text-[#c2410c]',
            'Stabil' => 'bg-[#e0f2fe] text-[#0284c7]',
        ];

        $jurusanData = [
            'teknik-kendaraan-ringan' => [
                'nama' => 'Teknik Kendaraan Ringan', 'icon' => 'fa-car',
                'deskripsi' => 'Mempelajari perawatan, perbaikan, dan diagnosis kerusakan kendaraan roda empat, mulai dari mesin konvensional hingga sistem kendaraan modern berbasis sensor.',
                'kompetensi' => [
                    ['judul' => 'Perawatan Mesin', 'icon' => 'fa-gear', 'desc' => 'Servis berkala, tune-up, dan perawatan sistem mesin kendaraan.'],
                    ['judul' => 'Sistem Kelistrikan', 'icon' => 'fa-bolt', 'desc' => 'Diagnosa dan perbaikan sistem kelistrikan & elektronik kendaraan.'],
                    ['judul' => 'Chassis & Suspensi', 'icon' => 'fa-car-side', 'desc' => 'Perawatan rem, kemudi, dan sistem suspensi kendaraan.'],
                ],
                'karir' => [
                    ['jabatan' => 'Teknisi Otomotif', 'potensi' => 'High Demand'],
                    ['jabatan' => 'Service Advisor', 'potensi' => 'Growing'],
                    ['jabatan' => 'Wirausaha Bengkel', 'potensi' => 'Stabil'],
                ],
            ],
            'teknik-mesin' => [
                'nama' => 'Teknik Mesin', 'icon' => 'fa-cogs',
                'deskripsi' => 'Fokus pada perancangan, pembuatan, dan pemeliharaan komponen mesin industri, termasuk proses pemesinan (CNC), pengelasan, dan fabrikasi logam.',
                'kompetensi' => [
                    ['judul' => 'Pemesinan CNC', 'icon' => 'fa-industry', 'desc' => 'Mengoperasikan mesin bubut & frais berbasis komputer.'],
                    ['judul' => 'Pengelasan', 'icon' => 'fa-fire', 'desc' => 'Teknik las yang aman dan sesuai standar industri.'],
                    ['judul' => 'Gambar Teknik', 'icon' => 'fa-ruler-combined', 'desc' => 'Membaca dan membuat gambar kerja komponen mesin.'],
                ],
                'karir' => [
                    ['jabatan' => 'Operator CNC', 'potensi' => 'High Demand'],
                    ['jabatan' => 'Teknisi Manufaktur', 'potensi' => 'Growing'],
                    ['jabatan' => 'Quality Control', 'potensi' => 'Stabil'],
                ],
            ],
            'teknik-elektronika-industri' => [
                'nama' => 'Teknik Elektronika Industri', 'icon' => 'fa-microchip',
                'deskripsi' => 'Mempelajari instalasi, pemeliharaan, dan perbaikan sistem elektronik dan kontrol otomatis yang digunakan di pabrik dan lini produksi.',
                'kompetensi' => [
                    ['judul' => 'Sistem Kontrol (PLC)', 'icon' => 'fa-sliders', 'desc' => 'Pemrograman dan troubleshooting sistem kendali industri.'],
                    ['judul' => 'Instrumentasi', 'icon' => 'fa-gauge', 'desc' => 'Kalibrasi dan pemeliharaan alat ukur industri.'],
                    ['judul' => 'Elektronika Daya', 'icon' => 'fa-plug', 'desc' => 'Rangkaian elektronik untuk kebutuhan daya industri.'],
                ],
                'karir' => [
                    ['jabatan' => 'Teknisi Instrumentasi', 'potensi' => 'High Demand'],
                    ['jabatan' => 'Maintenance Engineer', 'potensi' => 'Growing'],
                    ['jabatan' => 'Panel Builder', 'potensi' => 'Specialist'],
                ],
            ],
            'rekayasa-perangkat-lunak' => [
                'nama' => 'Rekayasa Perangkat Lunak', 'icon' => 'fa-code',
                'deskripsi' => 'Mempelajari cara merancang, membangun, dan menguji aplikasi/website, mulai dari logika pemrograman dasar hingga pengembangan produk digital siap pakai.',
                'kompetensi' => [
                    ['judul' => 'Pemrograman Web', 'icon' => 'fa-laptop-code', 'desc' => 'Membangun website dan aplikasi berbasis web.'],
                    ['judul' => 'Basis Data', 'icon' => 'fa-database', 'desc' => 'Merancang dan mengelola struktur data aplikasi.'],
                    ['judul' => 'Pengembangan Mobile', 'icon' => 'fa-mobile-screen', 'desc' => 'Membuat aplikasi untuk perangkat Android/iOS.'],
                ],
                'karir' => [
                    ['jabatan' => 'Software Engineer', 'potensi' => 'High Demand'],
                    ['jabatan' => 'Web Developer', 'potensi' => 'High Demand'],
                    ['jabatan' => 'QA Tester', 'potensi' => 'Growing'],
                ],
            ],
            'teknik-komputer-jaringan' => [
                'nama' => 'Teknik Komputer & Jaringan', 'icon' => 'fa-network-wired',
                'deskripsi' => 'Mempelajari cara instalasi jaringan LAN/WAN, keamanan siber, hingga administrasi server, membekali siswa dengan pemahaman arsitektur jaringan modern dan protokol keamanan data.',
                'kompetensi' => [
                    ['judul' => 'Perancangan Jaringan', 'icon' => 'fa-router', 'desc' => 'Arsitektur LAN/WAN, routing, switching, dan optimasi trafik data.'],
                    ['judul' => 'Troubleshooting Hardware', 'icon' => 'fa-screwdriver-wrench', 'desc' => 'Diagnosa kerusakan perangkat keras dan pemeliharaan server.'],
                    ['judul' => 'Administrasi Linux', 'icon' => 'fa-terminal', 'desc' => 'Manajemen sistem operasi server berbasis open-source.'],
                ],
                'karir' => [
                    ['jabatan' => 'Network Engineer', 'potensi' => 'High Demand'],
                    ['jabatan' => 'IT Support', 'potensi' => 'Growing'],
                    ['jabatan' => 'Cybersecurity Analyst', 'potensi' => 'Specialist'],
                ],
            ],
            'farmasi' => [
                'nama' => 'Farmasi', 'icon' => 'fa-pills',
                'deskripsi' => 'Mempelajari cara meracik, mengelola, dan mendistribusikan obat-obatan dengan aman, termasuk dasar-dasar kimia farmasi dan pelayanan kefarmasian.',
                'kompetensi' => [
                    ['judul' => 'Peracikan Obat', 'icon' => 'fa-mortar-pestle', 'desc' => 'Teknik dasar meracik dan mengemas sediaan farmasi.'],
                    ['judul' => 'Kimia Farmasi', 'icon' => 'fa-flask', 'desc' => 'Analisis kandungan dan kualitas bahan obat.'],
                    ['judul' => 'Pelayanan Kefarmasian', 'icon' => 'fa-user-doctor', 'desc' => 'Standar pelayanan obat di apotek dan rumah sakit.'],
                ],
                'karir' => [
                    ['jabatan' => 'Asisten Apoteker', 'potensi' => 'High Demand'],
                    ['jabatan' => 'Staf Gudang Farmasi', 'potensi' => 'Stabil'],
                    ['jabatan' => 'Sales Farmasi', 'potensi' => 'Growing'],
                ],
            ],
            'desain-komunikasi-visual' => [
                'nama' => 'Desain Komunikasi Visual', 'icon' => 'fa-palette',
                'deskripsi' => 'Mempelajari cara menyampaikan pesan lewat visual: logo, poster, kemasan, hingga materi digital, memadukan kreativitas dengan prinsip desain dan software desain profesional.',
                'kompetensi' => [
                    ['judul' => 'Desain Grafis', 'icon' => 'fa-pen-nib', 'desc' => 'Olah visual menggunakan software desain profesional.'],
                    ['judul' => 'Tipografi & Layout', 'icon' => 'fa-font', 'desc' => 'Menyusun tata letak dan huruf yang komunikatif.'],
                    ['judul' => 'Branding', 'icon' => 'fa-swatchbook', 'desc' => 'Membangun identitas visual sebuah merek/produk.'],
                ],
                'karir' => [
                    ['jabatan' => 'Graphic Designer', 'potensi' => 'High Demand'],
                    ['jabatan' => 'Content Creator', 'potensi' => 'High Demand'],
                    ['jabatan' => 'UI/UX Designer', 'potensi' => 'Growing'],
                ],
            ],
            'multimedia' => [
                'nama' => 'Multimedia', 'icon' => 'fa-clapperboard',
                'deskripsi' => 'Mempelajari produksi konten audio-visual: videografi, animasi, dan editing, untuk kebutuhan hiburan, promosi, hingga media digital.',
                'kompetensi' => [
                    ['judul' => 'Videografi', 'icon' => 'fa-video', 'desc' => 'Teknik pengambilan gambar bergerak yang sinematik.'],
                    ['judul' => 'Editing Video', 'icon' => 'fa-film', 'desc' => 'Menyunting footage jadi konten video yang menarik.'],
                    ['judul' => 'Animasi 2D/3D', 'icon' => 'fa-shapes', 'desc' => 'Membuat animasi untuk iklan, film, atau game.'],
                ],
                'karir' => [
                    ['jabatan' => 'Video Editor', 'potensi' => 'High Demand'],
                    ['jabatan' => 'Animator', 'potensi' => 'Growing'],
                    ['jabatan' => 'Motion Graphic Designer', 'potensi' => 'Specialist'],
                ],
            ],
            'tata-busana' => [
                'nama' => 'Tata Busana', 'icon' => 'fa-shirt',
                'deskripsi' => 'Mempelajari proses merancang, membuat pola, hingga menjahit pakaian, memadukan kreativitas mode dengan keterampilan teknis produksi busana.',
                'kompetensi' => [
                    ['judul' => 'Desain Busana', 'icon' => 'fa-pencil', 'desc' => 'Merancang model pakaian sesuai tren dan kebutuhan.'],
                    ['judul' => 'Pembuatan Pola', 'icon' => 'fa-scissors', 'desc' => 'Teknik membuat pola dasar hingga pola siap potong.'],
                    ['judul' => 'Menjahit', 'icon' => 'fa-thread', 'desc' => 'Teknik menjahit busana rapi dan sesuai standar.'],
                ],
                'karir' => [
                    ['jabatan' => 'Fashion Designer', 'potensi' => 'Growing'],
                    ['jabatan' => 'Penjahit Profesional', 'potensi' => 'Stabil'],
                    ['jabatan' => 'Wirausaha Konveksi', 'potensi' => 'Stabil'],
                ],
            ],
            'keperawatan' => [
                'nama' => 'Keperawatan', 'icon' => 'fa-user-nurse',
                'deskripsi' => 'Mempelajari dasar-dasar perawatan pasien, pertolongan pertama, dan prosedur medis dasar untuk membantu tenaga medis dalam pelayanan kesehatan.',
                'kompetensi' => [
                    ['judul' => 'Perawatan Dasar', 'icon' => 'fa-hand-holding-medical', 'desc' => 'Prosedur perawatan pasien sehari-hari.'],
                    ['judul' => 'Pertolongan Pertama', 'icon' => 'fa-kit-medical', 'desc' => 'Penanganan awal kondisi darurat medis.'],
                    ['judul' => 'Komunikasi Terapeutik', 'icon' => 'fa-comments', 'desc' => 'Cara berkomunikasi efektif dengan pasien.'],
                ],
                'karir' => [
                    ['jabatan' => 'Asisten Perawat', 'potensi' => 'High Demand'],
                    ['jabatan' => 'Caregiver', 'potensi' => 'Growing'],
                    ['jabatan' => 'Staf Puskesmas', 'potensi' => 'Stabil'],
                ],
            ],
            'tata-boga' => [
                'nama' => 'Tata Boga', 'icon' => 'fa-utensils',
                'deskripsi' => 'Mempelajari seni mengolah makanan, dari teknik memasak dasar hingga manajemen dapur profesional dan penyajian hidangan.',
                'kompetensi' => [
                    ['judul' => 'Teknik Memasak', 'icon' => 'fa-fire-burner', 'desc' => 'Metode olah pangan dari dasar hingga lanjutan.'],
                    ['judul' => 'Pastry & Bakery', 'icon' => 'fa-cookie', 'desc' => 'Pembuatan roti, kue, dan produk pastry.'],
                    ['judul' => 'Manajemen Dapur', 'icon' => 'fa-clipboard-list', 'desc' => 'Pengelolaan operasional dapur profesional.'],
                ],
                'karir' => [
                    ['jabatan' => 'Chef / Juru Masak', 'potensi' => 'High Demand'],
                    ['jabatan' => 'Baker/Pastry Chef', 'potensi' => 'Growing'],
                    ['jabatan' => 'Wirausaha Kuliner', 'potensi' => 'Stabil'],
                ],
            ],
            'perhotelan' => [
                'nama' => 'Perhotelan', 'icon' => 'fa-bed',
                'deskripsi' => 'Mempelajari standar pelayanan tamu, operasional hotel, dan manajemen akomodasi untuk industri pariwisata dan perhotelan.',
                'kompetensi' => [
                    ['judul' => 'Front Office', 'icon' => 'fa-concierge-bell', 'desc' => 'Standar pelayanan resepsionis dan reservasi tamu.'],
                    ['judul' => 'Housekeeping', 'icon' => 'fa-broom', 'desc' => 'Standar kebersihan dan kerapian kamar hotel.'],
                    ['judul' => 'Food & Beverage Service', 'icon' => 'fa-mug-saucer', 'desc' => 'Pelayanan makanan & minuman untuk tamu.'],
                ],
                'karir' => [
                    ['jabatan' => 'Front Office Staff', 'potensi' => 'High Demand'],
                    ['jabatan' => 'Housekeeping Staff', 'potensi' => 'Stabil'],
                    ['jabatan' => 'Event Coordinator', 'potensi' => 'Growing'],
                ],
            ],
            'bisnis-daring-pemasaran' => [
                'nama' => 'Bisnis Daring & Pemasaran', 'icon' => 'fa-cart-shopping',
                'deskripsi' => 'Mempelajari strategi pemasaran modern termasuk pemasaran digital, pengelolaan toko online, dan analisis perilaku konsumen.',
                'kompetensi' => [
                    ['judul' => 'Digital Marketing', 'icon' => 'fa-bullhorn', 'desc' => 'Strategi promosi produk lewat media digital.'],
                    ['judul' => 'E-Commerce', 'icon' => 'fa-shop', 'desc' => 'Pengelolaan toko online dan transaksi digital.'],
                    ['judul' => 'Riset Pasar', 'icon' => 'fa-chart-line', 'desc' => 'Analisis tren dan perilaku konsumen.'],
                ],
                'karir' => [
                    ['jabatan' => 'Digital Marketer', 'potensi' => 'High Demand'],
                    ['jabatan' => 'Admin Toko Online', 'potensi' => 'High Demand'],
                    ['jabatan' => 'Social Media Specialist', 'potensi' => 'Growing'],
                ],
            ],
            'perbankan' => [
                'nama' => 'Perbankan', 'icon' => 'fa-building-columns',
                'deskripsi' => 'Mempelajari operasional dasar lembaga keuangan/perbankan, termasuk layanan nasabah, transaksi, dan produk-produk perbankan.',
                'kompetensi' => [
                    ['judul' => 'Layanan Nasabah', 'icon' => 'fa-headset', 'desc' => 'Standar pelayanan transaksi & keluhan nasabah.'],
                    ['judul' => 'Transaksi Perbankan', 'icon' => 'fa-money-bill-transfer', 'desc' => 'Prosedur transaksi tunai dan non-tunai.'],
                    ['judul' => 'Produk Keuangan', 'icon' => 'fa-piggy-bank', 'desc' => 'Pemahaman produk tabungan, kredit, dan investasi dasar.'],
                ],
                'karir' => [
                    ['jabatan' => 'Teller Bank', 'potensi' => 'Stabil'],
                    ['jabatan' => 'Customer Service Bank', 'potensi' => 'Growing'],
                    ['jabatan' => 'Staf Administrasi Keuangan', 'potensi' => 'Stabil'],
                ],
            ],
            'akuntansi' => [
                'nama' => 'Akuntansi', 'icon' => 'fa-calculator',
                'deskripsi' => 'Mempelajari pencatatan, pengelolaan, dan pelaporan keuangan suatu usaha atau lembaga secara akurat dan sesuai standar akuntansi.',
                'kompetensi' => [
                    ['judul' => 'Pembukuan', 'icon' => 'fa-book', 'desc' => 'Pencatatan transaksi keuangan secara sistematis.'],
                    ['judul' => 'Laporan Keuangan', 'icon' => 'fa-file-invoice-dollar', 'desc' => 'Penyusunan neraca dan laporan laba rugi.'],
                    ['judul' => 'Software Akuntansi', 'icon' => 'fa-laptop', 'desc' => 'Penggunaan aplikasi akuntansi digital.'],
                ],
                'karir' => [
                    ['jabatan' => 'Staf Akuntansi', 'potensi' => 'High Demand'],
                    ['jabatan' => 'Bookkeeper', 'potensi' => 'Growing'],
                    ['jabatan' => 'Auditor Junior', 'potensi' => 'Specialist'],
                ],
            ],
            'administrasi-perkantoran' => [
                'nama' => 'Administrasi Perkantoran', 'icon' => 'fa-folder-open',
                'deskripsi' => 'Mempelajari pengelolaan administrasi kantor modern, termasuk kearsipan, korespondensi, dan penggunaan aplikasi perkantoran digital.',
                'kompetensi' => [
                    ['judul' => 'Kearsipan Digital', 'icon' => 'fa-folder', 'desc' => 'Pengelolaan dan penyimpanan dokumen secara digital.'],
                    ['judul' => 'Korespondensi', 'icon' => 'fa-envelope', 'desc' => 'Penulisan surat dan komunikasi bisnis formal.'],
                    ['judul' => 'Aplikasi Perkantoran', 'icon' => 'fa-table', 'desc' => 'Penggunaan software pengolah kata & spreadsheet.'],
                ],
                'karir' => [
                    ['jabatan' => 'Staf Administrasi', 'potensi' => 'High Demand'],
                    ['jabatan' => 'Sekretaris', 'potensi' => 'Stabil'],
                    ['jabatan' => 'Admin Kantor', 'potensi' => 'Growing'],
                ],
            ],
        ];

        $j = $jurusanData[$slug] ?? null;
    @endphp

    <div class="w-full flex justify-between items-center p-4 md:px-8 bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-2 text-[#003366] font-bold text-lg">
            <i class="fa-solid fa-graduation-cap"></i> <span>Bakat Minat</span>
        </div>
        <div class="w-8 h-8 rounded-full bg-[#00558f] text-white flex items-center justify-center font-bold text-xs">
            {{ Auth::check() ? strtoupper(substr(Auth::user()->name, 0, 2)) : 'PP' }}
        </div>
    </div>

    <main class="flex-grow w-full max-w-3xl mx-auto px-4 pt-6 pb-12 flex flex-col gap-5">

        <a href="{{ route('eksplorasi.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-gray-700 transition-colors w-fit">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Eksplorasi
        </a>

        @if(!$j)
            <div class="bg-white border {{ $accentBorder }} rounded-3xl p-10 shadow-sm text-center">
                <p class="text-sm text-gray-500">Detail jurusan ini belum tersedia.</p>
            </div>
        @else
            {{-- Hero --}}
            <div class="rounded-3xl p-6 md:p-8 shadow-lg relative overflow-hidden text-white" style="background: linear-gradient(135deg, {{ $gradFrom }}, {{ $gradTo }});">
                <div class="absolute w-32 h-32 bg-white/15 rounded-full -top-10 -right-10"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-white/20 border-2 border-white/40 flex items-center justify-center text-2xl mb-4">
                        <i class="fa-solid {{ $j['icon'] }}"></i>
                    </div>
                    <span class="bg-white/25 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">Jurusan SMK</span>
                    <h1 class="text-2xl md:text-3xl font-extrabold mt-3">{{ $j['nama'] }}</h1>
                </div>
            </div>

            {{-- Tentang --}}
            <div class="bg-white border {{ $accentBorder }} rounded-2xl p-5 md:p-6 shadow-sm">
                <h3 class="font-bold text-gray-800 text-base mb-3">Tentang Jurusan</h3>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $j['deskripsi'] }}</p>
            </div>

            {{-- Kompetensi --}}
            <div>
                <h3 class="font-bold text-gray-800 text-base mb-3 pl-1">Kompetensi Utama</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($j['kompetensi'] as $k)
                        <div class="bg-white border {{ $accentBorder }} rounded-2xl p-5 shadow-sm">
                            <div class="w-10 h-10 rounded-xl {{ $accentBg }} {{ $accentText }} flex items-center justify-center text-lg mb-4">
                                <i class="fa-solid {{ $k['icon'] }}"></i>
                            </div>
                            <h4 class="text-[10px] font-bold {{ $accentText }} tracking-wider mb-2 uppercase">{{ $k['judul'] }}</h4>
                            <p class="text-xs text-gray-600 leading-relaxed">{{ $k['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Prospek karir --}}
            <div>
                <h3 class="font-bold text-gray-800 text-base mb-3 pl-1">Prospek Karir</h3>
                <div class="bg-white rounded-2xl border {{ $accentBorder }} shadow-sm overflow-hidden">
                    <div class="flex justify-between p-4 text-white text-xs font-bold tracking-wide" style="background: linear-gradient(135deg, {{ $gradFrom }}, {{ $gradTo }});">
                        <span>Jabatan</span>
                        <span>Potensi</span>
                    </div>
                    @foreach($j['karir'] as $i => $k)
                        <div class="flex justify-between items-center p-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }} hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-3 text-sm text-gray-800 font-medium">
                                <i class="fa-solid fa-briefcase text-gray-400 w-5 text-center"></i>
                                <span>{{ $k['jabatan'] }}</span>
                            </div>
                            <span class="{{ $potensiWarna[$k['potensi']] ?? 'bg-gray-100 text-gray-500' }} text-[10px] font-bold px-2.5 py-1 rounded">{{ $k['potensi'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </main>

    <div class="fixed bottom-0 w-full bg-white border-t border-gray-200 flex justify-around items-center py-3 px-2 z-50 shadow-[0_-4px_10px_rgba(0,0,0,0.02)]">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center gap-1 text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fa-solid fa-house text-lg"></i>
            <span class="text-[10px] font-medium">Dashboard</span>
        </a>
        <a href="{{ route('assessment.index') }}" class="flex flex-col items-center justify-center gap-1 text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fa-regular fa-clipboard text-lg"></i>
            <span class="text-[10px] font-medium">Assessment</span>
        </a>
        <a href="{{ route('eksplorasi.index') }}" class="flex flex-col items-center justify-center gap-1 {{ $accentText }}">
            <i class="fa-solid fa-compass text-lg"></i>
            <span class="text-[10px] font-bold">Eksplorasi</span>
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