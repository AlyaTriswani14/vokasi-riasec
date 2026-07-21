<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekomendasi - Bakat Minat</title>
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

        $tipeLabels = [
            'r' => 'Realistic', 'i' => 'Investigative', 'a' => 'Artistic',
            's' => 'Social', 'e' => 'Enterprising', 'c' => 'Conventional',
        ];

        // Prospek karier per tipe dominan (SMK)
        $prospekKarier = [
            'r' => [
                ['karier' => 'Teknisi Otomotif', 'mapel' => 'Fisika, Praktik Kerja Industri', 'gaji' => 'Rp 3,5jt – 6jt'],
                ['karier' => 'Mekanik Industri', 'mapel' => 'Fisika, Gambar Teknik', 'gaji' => 'Rp 4jt – 7jt'],
            ],
            'i' => [
                ['karier' => 'Software Engineer', 'mapel' => 'Matematika, Informatika', 'gaji' => 'Rp 5jt – 12jt'],
                ['karier' => 'Data Analyst', 'mapel' => 'Matematika, Statistika', 'gaji' => 'Rp 5jt – 10jt'],
            ],
            'a' => [
                ['karier' => 'Graphic Designer', 'mapel' => 'Seni Budaya, Desain', 'gaji' => 'Rp 4jt – 8jt'],
                ['karier' => 'Content Creator', 'mapel' => 'Bahasa, Desain', 'gaji' => 'Rp 3jt – 9jt'],
            ],
            's' => [
                ['karier' => 'Perawat', 'mapel' => 'Biologi, Kimia', 'gaji' => 'Rp 3,5jt – 7jt'],
                ['karier' => 'Guru/Pendidik', 'mapel' => 'Bahasa, Pedagogik', 'gaji' => 'Rp 3,5jt – 6jt'],
            ],
            'e' => [
                ['karier' => 'Marketing Executive', 'mapel' => 'Ekonomi, Kewirausahaan', 'gaji' => 'Rp 4jt – 10jt'],
                ['karier' => 'Wirausaha', 'mapel' => 'Ekonomi, Kewirausahaan', 'gaji' => 'Tidak menentu'],
            ],
            'c' => [
                ['karier' => 'Staff Administrasi', 'mapel' => 'Matematika, Ekonomi', 'gaji' => 'Rp 3,5jt – 6jt'],
                ['karier' => 'Akuntan', 'mapel' => 'Matematika, Ekonomi', 'gaji' => 'Rp 4jt – 8jt'],
            ],
        ];

        $tipeDominan = null;
        if ($hasilTes) {
            $skorArr = [
                'r' => $hasilTes->skor_r, 'i' => $hasilTes->skor_i, 'a' => $hasilTes->skor_a,
                's' => $hasilTes->skor_s, 'e' => $hasilTes->skor_e, 'c' => $hasilTes->skor_c,
            ];
            arsort($skorArr);
            $tipeDominan = array_key_first($skorArr);
        }
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
                <h1 class="font-extrabold text-xl mb-1">Rekomendasi</h1>
                <p class="text-sm text-white/85">
                    @if($isSmk)
                        Prospek karier yang cocok berdasarkan tipe minatmu.
                    @else
                        SMK terdekat yang sesuai minatmu.
                    @endif
                </p>
            </div>
        </div>

        @if(!$hasilTes)
            <div class="bg-white border {{ $accentBorder }} rounded-3xl p-8 shadow-sm flex flex-col items-center text-center gap-3">
                <div class="w-16 h-16 rounded-full flex items-center justify-center text-2xl text-white" style="background: linear-gradient(135deg, {{ $gradFrom }}, {{ $gradTo }});">
                    <i class="fa-solid fa-bullseye"></i>
                </div>
                <h2 class="font-bold {{ $accentText }} text-lg">Belum ada hasil tes</h2>
                <p class="text-sm text-gray-500 max-w-xs">Selesaikan tes minat dulu di menu Assessment supaya kami bisa kasih rekomendasi buat kamu.</p>
                <a href="{{ route('assessment.index') }}" class="inline-block {{ $accentBtn }} text-white text-xs font-bold py-2.5 px-5 rounded-lg transition-colors">
                    Ke Halaman Assessment
                </a>
            </div>
        @elseif($isSmk)
            {{-- ===== SMK: Prospek Karier ===== --}}
            <div>
                <h2 class="text-lg font-bold text-gray-800 mb-1">Prospek Karier</h2>
                <p class="text-xs text-gray-500 mb-4">
                    Berdasarkan tipe dominan kamu: <span class="{{ $accentText }} font-bold">{{ $tipeLabels[$tipeDominan] }}</span>
                </p>
                <div class="flex flex-col gap-3">
                    @foreach($prospekKarier[$tipeDominan] as $k)
                        <div class="bg-white border {{ $accentBorder }} rounded-2xl p-5 shadow-sm">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 shrink-0 rounded-xl flex items-center justify-center text-white" style="background: linear-gradient(135deg, {{ $gradFrom }}, {{ $gradTo }});">
                                    <i class="fa-solid fa-briefcase text-sm"></i>
                                </div>
                                <h3 class="font-bold {{ $accentText }} text-base">{{ $k['karier'] }}</h3>
                            </div>
                            <div class="flex flex-col gap-1.5 text-xs text-gray-600">
                                <p><span class="font-bold text-gray-500">Mata pelajaran relevan:</span> {{ $k['mapel'] }}</p>
                                <p><span class="font-bold text-gray-500">Kisaran gaji:</span> {{ $k['gaji'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <p class="text-[10px] text-gray-400 mt-3">*Kisaran gaji bersifat umum sebagai gambaran awal, bisa berbeda tergantung pengalaman, lokasi, dan perusahaan.</p>
            </div>
        @else
            {{-- ===== SMP: SMK Terdekat ===== --}}
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-lg font-bold text-gray-800">SMK Terdekat</h2>
                </div>

                @if(empty($user->provinsi) || empty($user->kabupaten_kota) || empty($user->kecamatan) || empty($user->kelurahan))
                    <div class="bg-white border {{ $accentBorder }} rounded-2xl p-5 shadow-sm flex flex-col items-center text-center gap-2">
                        <i class="fa-solid fa-location-dot text-xl {{ $accentText }}"></i>
                        <p class="text-sm text-gray-600">Lengkapi data domisili di halaman <a href="{{ route('profil') }}" class="font-bold {{ $accentText }} underline">Profil</a> supaya kami bisa cari SMK terdekat dari tempat tinggalmu.</p>
                    </div>
                @elseif($sekolahTerdekat->isEmpty())
                    <div class="bg-white border {{ $accentBorder }} rounded-2xl p-5 shadow-sm flex flex-col items-center text-center gap-2">
                        <i class="fa-solid fa-school-circle-xmark text-xl {{ $accentText }}"></i>
                        <p class="text-sm text-gray-600">Belum ada data SMK yang cocok dengan wilayahmu saat ini.</p>
                    </div>
                @else
                    <div class="flex flex-col gap-3">
                        @foreach($sekolahTerdekat as $item)
                            <div class="bg-white border {{ $accentBorder }} rounded-2xl p-4 shadow-sm flex items-center gap-3">
                                <div class="w-10 h-10 shrink-0 rounded-xl {{ $accentBg }} flex items-center justify-center {{ $accentText }}">
                                    <i class="fa-solid fa-school text-sm"></i>
                                </div>
                                <div class="flex-grow">
                                    <h3 class="font-bold text-gray-800 text-sm">{{ $item['sekolah']->nama_sekolah }}</h3>
                                    <p class="text-xs text-gray-500">{{ $item['sekolah']->kecamatan }}, {{ $item['sekolah']->kabupaten_kota }}</p>
                                </div>
                                <span class="text-[10px] font-bold {{ $accentText }} {{ $accentBg }} px-2 py-1 rounded-full shrink-0">{{ $item['tingkat_kecocokan'] }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
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
        <a href="{{ route('eksplorasi.index') }}" class="flex flex-col items-center justify-center gap-1 text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fa-solid fa-compass text-lg"></i>
            <span class="text-[10px] font-medium">Eksplorasi</span>
        </a>
        <a href="{{ route('rekomendasi.index') }}" class="flex flex-col items-center justify-center gap-1 {{ $accentText }}">
            <i class="fa-solid fa-bullseye text-lg"></i>
            <span class="text-[10px] font-bold">Rekomendasi</span>
        </a>
        <a href="{{ route('profil') }}" class="flex flex-col items-center justify-center gap-1 text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fa-regular fa-user text-lg"></i>
            <span class="text-[10px] font-medium">Profil</span>
        </a>
    </div>

</body>
</html>