<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eksplorasi - Bakat Minat</title>
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

        // Rekomendasi jurusan SMK (dipakai kalau siswa SMP)
        $rekomJurusan = [
            'r' => ['Teknik Kendaraan Ringan', 'Teknik Mesin', 'Teknik Elektronika Industri'],
            'i' => ['Rekayasa Perangkat Lunak', 'Teknik Komputer & Jaringan', 'Farmasi'],
            'a' => ['Desain Komunikasi Visual', 'Multimedia', 'Tata Busana'],
            's' => ['Keperawatan', 'Tata Boga', 'Perhotelan'],
            'e' => ['Bisnis Daring & Pemasaran', 'Perbankan', 'Akuntansi'],
            'c' => ['Akuntansi', 'Administrasi Perkantoran', 'Perbankan'],
        ];

        // Rekomendasi skill tambahan di luar jurusan (dipakai kalau siswa SMK)
        $rekomSkill = [
            'r' => ['K3 (Keselamatan & Kesehatan Kerja)', 'Problem solving lapangan', 'Public speaking dasar'],
            'i' => ['Analisis data', 'Riset & penulisan laporan', 'Berpikir kritis'],
            'a' => ['Desain grafis', 'Videografi & editing', 'Personal branding'],
            's' => ['Komunikasi & kerja tim', 'Customer service', 'Public speaking'],
            'e' => ['Kewirausahaan', 'Negosiasi', 'Digital marketing'],
            'c' => ['Manajemen waktu', 'Administrasi digital', 'Ketelitian & akurasi data'],
        ];

        $skorArr = [];
        $persenArr = [];
        $tipeDominan = null;
        $top3 = [];
        if ($hasilTes) {
            $skorArr = [
                'r' => $hasilTes->skor_r, 'i' => $hasilTes->skor_i, 'a' => $hasilTes->skor_a,
                's' => $hasilTes->skor_s, 'e' => $hasilTes->skor_e, 'c' => $hasilTes->skor_c,
            ];
            foreach ($skorArr as $kode => $skor) {
                $persenArr[$kode] = round(($skor / 7) * 100);
            }
            $sorted = $persenArr;
            arsort($sorted);
            $tipeDominan = array_key_first($sorted);
            $top3 = array_slice($sorted, 0, 3, true);
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
                <h1 class="font-extrabold text-xl mb-1">Eksplorasi</h1>
                <p class="text-sm text-white/85">
                    @if($isSmk)
                        Lihat hasil minatmu dan rekomendasi keahlian tambahan di luar jurusanmu.
                    @else
                        Lihat hasil minatmu dan rekomendasi jurusan SMK yang paling cocok.
                    @endif
                </p>
            </div>
        </div>

        @if(!$hasilTes)
            <div class="bg-white border {{ $accentBorder }} rounded-3xl p-8 shadow-sm flex flex-col items-center text-center gap-3">
                <div class="w-16 h-16 rounded-full flex items-center justify-center text-2xl text-white" style="background: linear-gradient(135deg, {{ $gradFrom }}, {{ $gradTo }});">
                    <i class="fa-solid fa-compass"></i>
                </div>
                <h2 class="font-bold {{ $accentText }} text-lg">Belum ada hasil tes</h2>
                <p class="text-sm text-gray-500 max-w-xs">Selesaikan tes minat dulu di menu Assessment supaya kami bisa kasih rekomendasi buat kamu.</p>
                <a href="{{ route('assessment.index') }}" class="inline-block {{ $accentBtn }} text-white text-xs font-bold py-2.5 px-5 rounded-lg transition-colors">
                    Ke Halaman Assessment
                </a>
            </div>
        @else
            {{-- Chart hasil: donut wheel + radar, tinggi dibatasi biar ga membesar --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white border {{ $accentBorder }} rounded-2xl p-5 shadow-sm">
                    <p class="text-[10px] font-bold text-gray-400 tracking-wider uppercase mb-3">Sebaran RIASEC</p>
                    <div class="relative" style="height: 240px;">
                        <canvas id="riasecDonut"></canvas>
                    </div>
                </div>
                <div class="bg-white border {{ $accentBorder }} rounded-2xl p-5 shadow-sm">
                    <p class="text-[10px] font-bold text-gray-400 tracking-wider uppercase mb-3">Bentuk Minat</p>
                    <div class="relative" style="height: 240px;">
                        <canvas id="riasecRadar"></canvas>
                    </div>
                </div>
            </div>

            {{-- 3 Tipe dominan --}}
            <div class="rounded-2xl p-5 text-white shadow-sm relative overflow-hidden" style="background: linear-gradient(135deg, {{ $gradFrom }}, {{ $gradTo }});">
                <p class="text-[10px] font-bold text-white/80 tracking-wider uppercase mb-3 text-center">3 Tipe Dominan Kamu</p>
                <div class="grid grid-cols-3 gap-2">
                    @foreach($top3 as $kode => $persen)
                        <div class="bg-white/15 rounded-xl p-3 text-center">
                            <p class="text-[10px] font-bold text-white/70 mb-1">#{{ $loop->iteration }}</p>
                            <p class="font-extrabold text-lg">{{ strtoupper($kode) }}</p>
                            <p class="text-[10px] font-medium text-white/90 mb-1">{{ $tipeLabels[$kode] }}</p>
                            <p class="text-xs font-bold">{{ $persen }}%</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Rincian semua skor --}}
            <div class="bg-white border {{ $accentBorder }} rounded-2xl p-5 shadow-sm">
                <p class="text-[10px] font-bold text-gray-400 tracking-wider uppercase mb-3">Rincian Skor</p>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($persenArr as $kode => $persen)
                        <div class="rounded-xl {{ $accentBg }} p-3 text-center">
                            <p class="text-lg font-extrabold {{ $accentText }}">{{ $persen }}%</p>
                            <p class="text-[10px] font-bold text-gray-500">{{ $tipeLabels[$kode] }} [{{ strtoupper($kode) }}]</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Rekomendasi --}}
            <div>
                <h2 class="text-lg font-bold text-gray-800 mb-3">
                    {{ $isSmk ? 'Rekomendasi Keahlian Tambahan' : 'Rekomendasi Jurusan SMK' }}
                </h2>
                <p class="text-xs text-gray-500 mb-4">
                    Berdasarkan tipe dominan kamu: <span class="{{ $accentText }} font-bold">{{ $tipeLabels[$tipeDominan] }}</span>
                </p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    @foreach(($isSmk ? $rekomSkill[$tipeDominan] : $rekomJurusan[$tipeDominan]) as $item)
                        @if($isSmk)
                            <div class="bg-white border {{ $accentBorder }} rounded-2xl p-4 shadow-sm flex items-center gap-3">
                                <div class="w-9 h-9 shrink-0 rounded-lg {{ $accentBg }} flex items-center justify-center {{ $accentText }}">
                                    <i class="fa-solid fa-star text-sm"></i>
                                </div>
                                <p class="text-xs font-bold text-gray-700">{{ $item }}</p>
                            </div>
                        @else
                            <a href="{{ route('jurusan.detail', \Illuminate\Support\Str::slug($item)) }}" class="bg-white border {{ $accentBorder }} rounded-2xl p-4 shadow-sm flex items-center gap-3 hover:shadow-md transition-shadow">
                                <div class="w-9 h-9 shrink-0 rounded-lg {{ $accentBg }} flex items-center justify-center {{ $accentText }}">
                                    <i class="fa-solid fa-graduation-cap text-sm"></i>
                                </div>
                                <p class="text-xs font-bold text-gray-700 flex-grow">{{ $item }}</p>
                                <i class="fa-solid fa-chevron-right text-gray-300 text-xs"></i>
                            </a>
                        @endif
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

    @if($hasilTes)
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <script>
        const persenData = [
            {{ $persenArr['r'] }}, {{ $persenArr['i'] }}, {{ $persenArr['a'] }},
            {{ $persenArr['s'] }}, {{ $persenArr['e'] }}, {{ $persenArr['c'] }}
        ];
        const labelData = ['Realistic', 'Investigative', 'Artistic', 'Social', 'Enterprising', 'Conventional'];

        new Chart(document.getElementById('riasecDonut'), {
            type: 'doughnut',
            data: {
                labels: labelData,
                datasets: [{
                    data: persenData,
                    backgroundColor: ['#EF4444', '#3B82F6', '#F97316', '#06B6D4', '#F59E0B', '#10B981'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10 } } },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `${ctx.label}: ${ctx.raw}%`
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('riasecRadar'), {
            type: 'radar',
            data: {
                labels: labelData,
                datasets: [{
                    label: 'Skor Kamu',
                    data: persenData,
                    backgroundColor: 'rgba(255, 122, 69, 0.2)',
                    borderColor: '{{ $gradFrom }}',
                    borderWidth: 2,
                    pointBackgroundColor: '{{ $gradFrom }}',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        min: 0,
                        max: 100,
                        ticks: { stepSize: 20, font: { size: 9 }, callback: (v) => v + '%' },
                        pointLabels: { font: { size: 9 } }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `${ctx.label}: ${ctx.raw}%`
                        }
                    }
                }
            }
        });
    </script>
    @endif

</body>
</html>