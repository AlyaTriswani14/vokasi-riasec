<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Siswa - Bakat Minat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8fafc] font-sans text-gray-800 min-h-screen">

    @php
        $tipeLabels = [
            'R' => 'Realistic', 'I' => 'Investigative', 'A' => 'Artistic',
            'S' => 'Social', 'E' => 'Enterprising', 'C' => 'Conventional',
        ];
        $tipeDominan = null;
        if (!empty($persenArr)) {
            $sorted = $persenArr;
            arsort($sorted);
            $tipeDominan = array_key_first($sorted);
        }
    @endphp

    <div class="w-full flex justify-between items-center p-4 md:px-8 bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-2 text-[#003366] font-bold text-lg">
            <i class="fa-solid fa-graduation-cap"></i> <span>Bakat Minat</span>
        </div>
        <div class="text-right hidden sm:block">
            <p class="text-xs font-bold text-gray-700">{{ $guru->name }}</p>
            <p class="text-[10px] text-gray-400">{{ $guru->nama_sekolah }}</p>
        </div>
    </div>

    <main class="w-full max-w-3xl mx-auto px-4 py-8 flex flex-col gap-5">

        <a href="{{ route('guru-bk.panel') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-[#003366] transition-colors w-fit">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Panel
        </a>

        {{-- Info siswa --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-[#003366] text-white flex items-center justify-center font-bold text-lg shrink-0">
                {{ strtoupper(substr($siswa->name, 0, 2)) }}
            </div>
            <div>
                <h1 class="text-lg font-extrabold text-gray-800">{{ $siswa->name }}</h1>
                <p class="text-xs text-gray-500">
                    Kelas {{ $siswa->kelas ?: '-' }} &bull; NISN {{ $siswa->nisn ?: '-' }} &bull; {{ $siswa->email }}
                </p>
            </div>
        </div>

        @if(!$hasil)
            <div class="bg-white border border-gray-100 rounded-2xl p-10 shadow-sm text-center">
                <div class="w-14 h-14 mx-auto rounded-full bg-gray-100 text-gray-400 flex items-center justify-center text-xl mb-3">
                    <i class="fa-solid fa-clipboard"></i>
                </div>
                <p class="text-sm font-bold text-gray-600">Siswa ini belum menyelesaikan tes minat.</p>
                <p class="text-xs text-gray-400 mt-1">Hasil akan muncul di sini setelah siswa menyelesaikan Assessment RIASEC.</p>
            </div>
        @else
            {{-- Tipe dominan --}}
            <div class="rounded-2xl p-5 text-white shadow-sm text-center" style="background: linear-gradient(135deg, #003366, #0f766e);">
                <p class="text-[10px] font-bold text-white/80 tracking-wider uppercase mb-1">Tanggal Tes: {{ $hasil->created_at->format('d M Y') }}</p>
                <h2 class="font-extrabold text-xl">Tipe Dominan: {{ $tipeLabels[$tipeDominan] }} ({{ $tipeDominan }})</h2>
            </div>

            {{-- Rincian skor --}}
            <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                <p class="text-[10px] font-bold text-gray-400 tracking-wider uppercase mb-4">Rincian Skor RIASEC</p>
                <div class="flex flex-col gap-3">
                    @foreach($persenArr as $kode => $persen)
                        <div>
                            <div class="flex justify-between text-xs font-bold mb-1">
                                <span class="text-gray-700">{{ $tipeLabels[$kode] }} ({{ $kode }})</span>
                                <span class="text-gray-500">{{ $persen }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2.5">
                                <div class="h-2.5 rounded-full bg-[#003366]" style="width: {{ $persen }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </main>

</body>
</html>