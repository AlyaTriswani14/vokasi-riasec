<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Bakat Minat</title>
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
        $badgeLabel = $isSmk ? 'Siswa SMK' : 'Siswa SMP/MTs';

        $tipeLabels = [
            'r' => 'Realistic', 'i' => 'Investigative', 'a' => 'Artistic',
            's' => 'Social', 'e' => 'Enterprising', 'c' => 'Conventional',
        ];
        $tipeDominan = null;
        if ($hasilTes) {
            $skor = [
                'r' => $hasilTes->skor_r, 'i' => $hasilTes->skor_i, 'a' => $hasilTes->skor_a,
                's' => $hasilTes->skor_s, 'e' => $hasilTes->skor_e, 'c' => $hasilTes->skor_c,
            ];
            arsort($skor);
            $tipeDominan = $tipeLabels[array_key_first($skor)];
        }

        // Pengumuman dari Admin Direktorat SMK, sesuai target penerima & jenjang
        $pengumuman = \App\Models\Broadcast::untukUser(Auth::user())->take(5)->get();
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
            <div class="relative z-10 flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-white/20 border-2 border-white/40 flex items-center justify-center text-2xl shrink-0">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div>
                    <p class="text-xs text-white/80 mb-0.5">Halo, semangat terus!</p>
                    <h2 class="font-extrabold text-xl">{{ Auth::user()->name }}</h2>
                    <span class="inline-block bg-white/25 text-[10px] font-bold px-2.5 py-1 rounded-full mt-1.5">{{ $badgeLabel }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white border {{ $accentBorder }} rounded-2xl p-5 shadow-sm">
                <p class="text-[10px] font-bold text-gray-400 tracking-wider uppercase mb-2">Status Tes Minat</p>
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-6 h-6 rounded-full {{ $hasilTes ? 'bg-[#dcfce7] text-[#16a34a]' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center text-sm">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <h3 class="font-bold text-xl {{ $hasilTes ? 'text-[#16a34a]' : 'text-gray-400' }}">
                        {{ $hasilTes ? 'Selesai' : 'Belum Tes' }}
                    </h3>
                </div>
                @if($hasilTes)
                    <p class="text-xs text-gray-500">Tes terakhir: {{ $hasilTes->created_at->format('d M Y') }}</p>
                @else
                    <p class="text-xs text-red-500">Silakan lakukan tes terlebih dahulu.</p>
                @endif
            </div>

            <div class="rounded-2xl p-5 text-white shadow-sm relative overflow-hidden" style="background: linear-gradient(135deg, {{ $gradFrom }}, {{ $gradTo }});">
                <p class="text-[10px] font-bold text-white/80 tracking-wider uppercase mb-3">Hasil Terakhir</p>
                @if($hasilTes)
                    <p class="text-sm">Skor R: {{ $hasilTes->skor_r }}, I: {{ $hasilTes->skor_i }}, A: {{ $hasilTes->skor_a }}</p>
                @else
                    <p class="text-sm">Data belum tersedia.</p>
                @endif
            </div>
        </div>

        {{-- Kartu highlight pembeda SMP / SMK --}}
        <div class="bg-white border {{ $accentBorder }} rounded-2xl p-5 shadow-sm">
            <p class="text-[10px] font-bold text-gray-400 tracking-wider uppercase mb-2">
                {{ $isSmk ? 'Progress Eksplorasi Skill' : 'Rekomendasi Awal' }}
            </p>
            @if($hasilTes)
                <h3 class="font-bold {{ $accentText }} text-lg mb-1">Tipe dominan kamu: {{ $tipeDominan }}</h3>
                <p class="text-xs text-gray-600 mb-4">
                    @if($isSmk)
                        Lihat rekomendasi keahlian tambahan (soft skill & hard skill) di luar jurusanmu.
                    @else
                        Lihat rekomendasi jurusan SMK yang paling cocok buat kamu.
                    @endif
                </p>
            @else
                <h3 class="font-bold text-gray-400 text-lg mb-1">Belum ada data</h3>
                <p class="text-xs text-gray-500 mb-4">Selesaikan tes minat dulu supaya kami bisa kasih rekomendasi.</p>
            @endif
            <a href="{{ route('eksplorasi.index') }}" class="inline-block {{ $accentBtn }} text-white text-xs font-bold py-2 px-4 rounded-lg transition-colors">
                Buka Eksplorasi
            </a>
        </div>

        {{-- Pengumuman dari Kemendikdasmen --}}
        <div class="bg-white border {{ $accentBorder }} rounded-2xl p-5 shadow-sm">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-8 h-8 rounded-lg {{ $accentBg }} {{ $accentText }} flex items-center justify-center">
                    <i class="fa-solid fa-bullhorn text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 tracking-wider uppercase">Pengumuman</p>
                    <h3 class="font-bold text-gray-800 text-sm">Info &amp; Berita Terbaru</h3>
                </div>
            </div>

            @if($pengumuman->isEmpty())
                <div class="text-center py-6">
                    <p class="text-xs text-gray-400">Belum ada pengumuman untuk saat ini.</p>
                </div>
            @else
                <div class="flex flex-col gap-3">
                    @foreach($pengumuman as $p)
                        <div class="border {{ $accentBorder }} rounded-xl p-4">
                            <div class="flex items-start justify-between gap-3">
                                <h4 class="font-bold text-gray-800 text-sm">{{ $p->subjek }}</h4>
                                <span class="text-[10px] text-gray-400 whitespace-nowrap shrink-0">{{ $p->created_at->format('d M Y') }}</span>
                            </div>
                            <p class="text-xs text-gray-600 mt-1.5 whitespace-pre-line">{{ $p->isi }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </main>

    {{-- Bottom Nav — 5 section --}}
    <div class="fixed bottom-0 w-full bg-white border-t border-gray-200 flex justify-around items-center py-3 px-2 z-50 shadow-[0_-4px_10px_rgba(0,0,0,0.02)]">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center gap-1 {{ $accentText }}">
            <i class="fa-solid fa-house text-lg"></i>
            <span class="text-[10px] font-bold">Dashboard</span>
        </a>
        <a href="{{ route('assessment.index') }}" class="flex flex-col items-center justify-center gap-1 text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fa-regular fa-clipboard text-lg"></i>
            <span class="text-[10px] font-medium">Assessment</span>
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