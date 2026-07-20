<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Soal - Bakat Minat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8fafc] font-sans text-gray-800 min-h-screen">

    <div class="w-full flex justify-between items-center p-4 md:px-8 bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-2 text-[#003366] font-bold text-lg">
            <i class="fa-solid fa-graduation-cap"></i> <span>Bakat Minat</span>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right hidden sm:block">
                <p class="text-xs font-bold text-gray-700">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-gray-400">Admin Direktorat SMK</p>
            </div>
            <form action="{{ route('kemendikdasmen.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-9 h-9 rounded-full bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100 transition-colors">
                    <i class="fa-solid fa-arrow-right-from-bracket text-sm"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="w-full bg-[#003366] overflow-x-auto">
        <div class="max-w-6xl mx-auto flex gap-1 px-4">
            <a href="{{ route('kemendikdasmen.dashboard') }}" class="text-white/60 hover:text-white text-xs font-bold px-4 py-3 border-b-2 border-transparent whitespace-nowrap transition-colors">Dashboard</a>
            <a href="{{ route('kemendikdasmen.users') }}" class="text-white/60 hover:text-white text-xs font-bold px-4 py-3 border-b-2 border-transparent whitespace-nowrap transition-colors">Manajemen Sekolah</a>
            <a href="{{ route('kemendikdasmen.questions') }}" class="text-white text-xs font-bold px-4 py-3 border-b-2 border-white whitespace-nowrap">Bank Soal</a>
            <a href="{{ route('kemendikdasmen.settings') }}" class="text-white/60 hover:text-white text-xs font-bold px-4 py-3 border-b-2 border-transparent whitespace-nowrap transition-colors">Pengaturan</a>
            <a href="{{ route('kemendikdasmen.broadcast') }}" class="text-white/60 hover:text-white text-xs font-bold px-4 py-3 border-b-2 border-transparent whitespace-nowrap transition-colors">Broadcast</a>
        </div>
    </div>

    <main class="w-full max-w-6xl mx-auto px-4 py-8 flex flex-col gap-6">

        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
            <div>
                <span class="inline-block bg-[#003366] text-white text-[10px] font-bold px-3 py-1.5 rounded-full mb-2">ADMIN DIREKTORAT SMK</span>
                <h1 class="text-xl font-extrabold text-gray-800">Bank Soal RIASEC</h1>
                <p class="text-sm text-gray-500">Daftar pernyataan/pertanyaan yang digunakan dalam tes RIASEC.</p>
            </div>
            <div class="flex gap-2 shrink-0">
                <button type="button" onclick="document.getElementById('form-import-csv').classList.toggle('hidden')" class="bg-white border border-gray-200 text-gray-600 text-xs font-bold px-4 py-2.5 rounded-xl hover:bg-gray-50 transition-colors inline-flex items-center gap-2">
                    <i class="fa-solid fa-file-csv"></i> Import CSV
                </button>
                <button type="button" onclick="document.getElementById('form-tambah-soal').classList.toggle('hidden')" class="bg-[#003366] text-white text-xs font-bold px-4 py-2.5 rounded-xl hover:bg-[#002855] transition-colors inline-flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Tambah Soal
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-100 text-green-700 text-xs rounded-xl p-3">{{ session('success') }}</div>
        @endif

        {{-- Form import CSV --}}
        <div id="form-import-csv" class="{{ $errors->has('file_csv') ? '' : 'hidden' }} bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
            <h2 class="font-bold text-gray-800 text-sm mb-2">Import Soal dari CSV</h2>
            <p class="text-xs text-gray-500 mb-4">Format: baris pertama adalah header (diabaikan), lalu tiap baris berisi <code>pernyataan,aspek</code>. Aspek harus salah satu dari R, I, A, S, E, C. Contoh baris: <code>Saya suka menggambar,A</code></p>
            @if($errors->has('file_csv'))
                <div class="bg-red-50 border border-red-100 text-red-600 text-xs rounded-xl p-3 mb-4">{{ $errors->first('file_csv') }}</div>
            @endif
            <form method="POST" action="{{ route('kemendikdasmen.questions.import') }}" enctype="multipart/form-data" class="flex flex-col sm:flex-row gap-3 sm:items-end">
                @csrf
                <div class="flex-1">
                    <input type="file" name="file_csv" accept=".csv" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm">
                </div>
                <button type="submit" class="bg-[#003366] text-white text-xs font-bold px-5 py-2.5 rounded-xl hover:bg-[#002855] transition-colors">Upload &amp; Import</button>
                <button type="button" onclick="document.getElementById('form-import-csv').classList.add('hidden')" class="text-xs font-bold text-gray-400 px-5 py-2.5 hover:text-gray-600">Batal</button>
            </form>
        </div>

        {{-- Form tambah soal --}}
        <div id="form-tambah-soal" class="{{ $errors->has('pernyataan') ? '' : 'hidden' }} bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
            <h2 class="font-bold text-gray-800 text-sm mb-4">Tambah Soal Baru</h2>
            @if($errors->any())
                <div class="bg-red-50 border border-red-100 text-red-600 text-xs rounded-xl p-3 mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('kemendikdasmen.questions.store') }}" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Pernyataan</label>
                    <textarea name="pernyataan" rows="2" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">{{ old('pernyataan') }}</textarea>
                </div>
                <div class="max-w-xs">
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Aspek RIASEC</label>
                    <select name="aspek" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">
                        <option value="">-- Pilih Aspek --</option>
                        <option value="R" {{ old('aspek') === 'R' ? 'selected' : '' }}>R - Realistic</option>
                        <option value="I" {{ old('aspek') === 'I' ? 'selected' : '' }}>I - Investigative</option>
                        <option value="A" {{ old('aspek') === 'A' ? 'selected' : '' }}>A - Artistic</option>
                        <option value="S" {{ old('aspek') === 'S' ? 'selected' : '' }}>S - Social</option>
                        <option value="E" {{ old('aspek') === 'E' ? 'selected' : '' }}>E - Enterprising</option>
                        <option value="C" {{ old('aspek') === 'C' ? 'selected' : '' }}>C - Conventional</option>
                    </select>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="bg-[#003366] text-white text-xs font-bold px-5 py-2.5 rounded-xl hover:bg-[#002855] transition-colors">Simpan Soal</button>
                    <button type="button" onclick="document.getElementById('form-tambah-soal').classList.add('hidden')" class="text-xs font-bold text-gray-400 px-5 py-2.5 hover:text-gray-600">Batal</button>
                </div>
            </form>
        </div>

        {{-- Search, filter aspek, per-page --}}
        <form method="GET" action="{{ route('kemendikdasmen.questions') }}" class="bg-white border border-gray-100 rounded-2xl shadow-sm p-4 flex flex-col sm:flex-row gap-3 sm:items-end">
            <div class="flex-1">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Cari Soal</label>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari teks pernyataan..." class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Aspek</label>
                <select name="aspek" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">
                    <option value="" {{ $aspek === '' ? 'selected' : '' }}>Semua</option>
                    <option value="R" {{ $aspek === 'R' ? 'selected' : '' }}>R</option>
                    <option value="I" {{ $aspek === 'I' ? 'selected' : '' }}>I</option>
                    <option value="A" {{ $aspek === 'A' ? 'selected' : '' }}>A</option>
                    <option value="S" {{ $aspek === 'S' ? 'selected' : '' }}>S</option>
                    <option value="E" {{ $aspek === 'E' ? 'selected' : '' }}>E</option>
                    <option value="C" {{ $aspek === 'C' ? 'selected' : '' }}>C</option>
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Tampilkan</label>
                <select name="per_page" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">
                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>
            <button type="submit" class="bg-[#003366] text-white text-xs font-bold px-5 py-2.5 rounded-xl hover:bg-[#002855] transition-colors">Terapkan</button>
            @if($search !== '' || $aspek !== '')
                <a href="{{ route('kemendikdasmen.questions') }}" class="text-xs font-bold text-gray-400 px-3 py-2.5 hover:text-gray-600 text-center">Reset</a>
            @endif
        </form>

        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
            @if($soalPaginated->isEmpty())
                <div class="p-10 text-center">
                    <p class="text-sm text-gray-500">Tidak ada soal yang cocok dengan pencarian/filter ini.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-left">
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Urutan</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pernyataan</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Aspek</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $aspekWarna = [
                                    'R' => 'bg-red-50 text-[#EF4444]',
                                    'I' => 'bg-blue-50 text-[#3B82F6]',
                                    'A' => 'bg-orange-50 text-[#F97316]',
                                    'S' => 'bg-cyan-50 text-[#06B6D4]',
                                    'E' => 'bg-amber-50 text-[#F59E0B]',
                                    'C' => 'bg-green-50 text-[#10B981]',
                                ];
                            @endphp
                            @foreach($soalPaginated as $soal)
                                <tr class="border-t border-gray-50 hover:bg-gray-50 transition-colors">
                                    <td class="px-5 py-3 text-gray-400">{{ $soal->urutan }}</td>
                                    <td class="px-5 py-3 text-gray-700">{{ $soal->pernyataan }}</td>
                                    <td class="px-5 py-3">
                                        <span class="{{ $aspekWarna[$soal->aspek] ?? 'bg-gray-50 text-gray-500' }} text-[10px] font-bold px-2.5 py-1 rounded-full">{{ $soal->aspek }}</span>
                                    </td>
                                    <td class="px-5 py-3">
                                        @if($soal->status === 'aktif')
                                            <span class="bg-green-50 text-green-600 text-[10px] font-bold px-2.5 py-1 rounded-full">Aktif</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-400 text-[10px] font-bold px-2.5 py-1 rounded-full">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('kemendikdasmen.questions.edit', $soal->id) }}" class="text-[#003366] hover:text-[#002855] text-xs font-bold" title="Edit soal ini">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <form method="POST" action="{{ route('kemendikdasmen.questions.destroy', $soal->id) }}" onsubmit="return confirm('Yakin hapus soal ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-bold" title="Hapus soal ini">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($soalPaginated->hasPages())
                    <div class="flex items-center justify-between px-5 py-3 border-t border-gray-100">
                        <p class="text-xs text-gray-400">Menampilkan {{ $soalPaginated->firstItem() }}-{{ $soalPaginated->lastItem() }} dari {{ $soalPaginated->total() }} soal</p>
                        <div class="flex items-center gap-2">
                            @if($soalPaginated->onFirstPage())
                                <span class="text-xs font-bold text-gray-300 px-3 py-1.5">&larr; Sebelumnya</span>
                            @else
                                <a href="{{ $soalPaginated->previousPageUrl() }}" class="text-xs font-bold text-[#003366] px-3 py-1.5 rounded-lg hover:bg-gray-50">&larr; Sebelumnya</a>
                            @endif
                            <span class="text-xs text-gray-500">Hal {{ $soalPaginated->currentPage() }} / {{ $soalPaginated->lastPage() }}</span>
                            @if($soalPaginated->hasMorePages())
                                <a href="{{ $soalPaginated->nextPageUrl() }}" class="text-xs font-bold text-[#003366] px-3 py-1.5 rounded-lg hover:bg-gray-50">Berikutnya &rarr;</a>
                            @else
                                <span class="text-xs font-bold text-gray-300 px-3 py-1.5">Berikutnya &rarr;</span>
                            @endif
                        </div>
                    </div>
                @endif
            @endif
        </div>

        <p class="text-xs text-gray-400 text-center">Catatan: perubahan di sini belum otomatis dipakai pada tes yang dikerjakan siswa. Itu langkah lanjutan setelah bagian ini kamu konfirmasi.</p>

    </main>

</body>
</html>