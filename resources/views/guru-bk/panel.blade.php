<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Guru BK - Bakat Minat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8fafc] font-sans text-gray-800 min-h-screen">

    @php
        $tipeLabels = [
            'R' => 'Realistic', 'I' => 'Investigative', 'A' => 'Artistic',
            'S' => 'Social', 'E' => 'Enterprising', 'C' => 'Conventional',
        ];

        // Pengumuman dari Admin Direktorat SMK, sesuai target penerima & jenjang
        $pengumuman = \App\Models\Broadcast::untukUser($guru)->take(5)->get();
    @endphp

    <div class="w-full flex justify-between items-center p-4 md:px-8 bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-2 text-[#003366] font-bold text-lg">
            <i class="fa-solid fa-graduation-cap"></i> <span>Bakat Minat</span>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right hidden sm:block">
                <p class="text-xs font-bold text-gray-700">{{ $guru->name }}</p>
                <p class="text-[10px] text-gray-400">{{ $guru->nama_sekolah }}</p>
            </div>
            <form action="{{ route('guru-bk.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-9 h-9 rounded-full bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100 transition-colors">
                    <i class="fa-solid fa-arrow-right-from-bracket text-sm"></i>
                </button>
            </form>
        </div>
    </div>

    <main class="w-full max-w-5xl mx-auto px-4 py-8 flex flex-col gap-6">

        <div>
            <span class="inline-block bg-[#003366] text-white text-[10px] font-bold px-3 py-1.5 rounded-full mb-2">PANEL GURU BK</span>
            <h1 class="text-xl font-extrabold text-gray-800">Pemantauan Siswa Bina</h1>
            <p class="text-sm text-gray-500">{{ $guru->nama_sekolah }} &bull; NPSN {{ $guru->npsn }}</p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#003366] flex items-center justify-center mb-3">
                    <i class="fa-solid fa-users"></i>
                </div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total Siswa Bina</p>
                <h2 class="text-2xl font-extrabold text-gray-800">{{ $totalSiswa }}</h2>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center mb-3">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Sudah Tes</p>
                <h2 class="text-2xl font-extrabold text-green-600">{{ $sudahTes }}</h2>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-3">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Belum Tes</p>
                <h2 class="text-2xl font-extrabold text-amber-600">{{ $belumTes }}</h2>
            </div>
        </div>

        {{-- Pengumuman dari Kemendikdasmen --}}
        @if($pengumuman->isNotEmpty())
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-[#003366] flex items-center justify-center">
                    <i class="fa-solid fa-bullhorn text-sm"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 tracking-wider uppercase">Pengumuman</p>
                    <h3 class="font-bold text-gray-800 text-sm">Info dari Direktorat SMK</h3>
                </div>
            </div>
            <div class="flex flex-col gap-3">
                @foreach($pengumuman as $p)
                    <div class="border border-gray-100 rounded-xl p-4">
                        <div class="flex items-start justify-between gap-3">
                            <h4 class="font-bold text-gray-800 text-sm">{{ $p->subjek }}</h4>
                            <span class="text-[10px] text-gray-400 whitespace-nowrap shrink-0">{{ $p->created_at->format('d M Y') }}</span>
                        </div>
                        <p class="text-xs text-gray-600 mt-1.5 whitespace-pre-line">{{ $p->isi }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Tabel siswa --}}
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 p-5 border-b border-gray-100">
                <h2 class="font-bold text-gray-800 text-sm">Daftar Siswa</h2>

                <form action="{{ route('guru-bk.panel') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama siswa..."
                        class="border border-gray-200 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-[#0f766e] w-full sm:w-48">
                    <select name="status" class="border border-gray-200 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-[#0f766e]">
                        <option value="" {{ $status === '' ? 'selected' : '' }}>Semua Status</option>
                        <option value="sudah" {{ $status === 'sudah' ? 'selected' : '' }}>Sudah Tes</option>
                        <option value="belum" {{ $status === 'belum' ? 'selected' : '' }}>Belum Tes</option>
                    </select>
                    <button type="submit" class="bg-[#003366] hover:bg-[#002244] text-white text-xs font-bold px-4 py-2 rounded-lg transition-colors">
                        Cari
                    </button>
                    <a href="{{ route('guru-bk.export') }}" class="bg-[#0f766e] hover:bg-[#115e59] text-white text-xs font-bold px-4 py-2 rounded-lg transition-colors flex items-center justify-center gap-2 whitespace-nowrap">
                        <i class="fa-solid fa-file-export"></i> Export
                    </a>
                </form>
            </div>

            @if($siswaList->isEmpty())
                <div class="p-10 text-center">
                    @if($totalSiswa === 0)
                        <p class="text-sm text-gray-500">Belum ada siswa dengan asal sekolah "{{ $guru->nama_sekolah }}".</p>
                        <p class="text-xs text-gray-400 mt-1">Siswa akan otomatis muncul di sini kalau asal sekolah yang mereka isi cocok persis dengan nama sekolah akun ini.</p>
                    @else
                        <p class="text-sm text-gray-500">Tidak ada siswa yang cocok dengan pencarian/filter ini.</p>
                    @endif
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-left">
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Nama Siswa</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kelas</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">NISN</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status Tes</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tanggal Tes</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">RIASEC Dominan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswaList as $siswa)
                                <tr class="border-t border-gray-50 hover:bg-gray-50 transition-colors cursor-pointer"
                                    onclick="window.location='{{ route('guru-bk.siswa.detail', $siswa->id) }}'">
                                    <td class="px-5 py-3 font-bold text-[#0f766e]">{{ $siswa->name }}</td>
                                    <td class="px-5 py-3 text-gray-500">{{ $siswa->kelas ?: '-' }}</td>
                                    <td class="px-5 py-3 text-gray-500">{{ $siswa->nisn ?: '-' }}</td>
                                    <td class="px-5 py-3">
                                        @if($siswa->hasil_tes)
                                            <span class="bg-green-50 text-green-600 text-[10px] font-bold px-2.5 py-1 rounded-full">Selesai</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-400 text-[10px] font-bold px-2.5 py-1 rounded-full">Belum Tes</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3 text-gray-500">
                                        {{ $siswa->hasil_tes ? $siswa->hasil_tes->created_at->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-5 py-3">
                                        @if($siswa->tipe_dominan)
                                            <span class="bg-blue-50 text-[#003366] text-[10px] font-bold px-2.5 py-1 rounded-full">
                                                {{ $tipeLabels[$siswa->tipe_dominan] }} ({{ $siswa->tipe_dominan }})
                                            </span>
                                        @else
                                            <span class="text-gray-300 text-xs">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </main>

</body>
</html>