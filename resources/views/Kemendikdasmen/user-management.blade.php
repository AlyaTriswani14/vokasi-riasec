<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Sekolah - Bakat Minat</title>
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
            <a href="{{ route('kemendikdasmen.users') }}" class="text-white text-xs font-bold px-4 py-3 border-b-2 border-white whitespace-nowrap">Manajemen Sekolah</a>
            <a href="{{ route('kemendikdasmen.questions') }}" class="text-white/60 hover:text-white text-xs font-bold px-4 py-3 border-b-2 border-transparent whitespace-nowrap transition-colors">Bank Soal</a>
            <a href="{{ route('kemendikdasmen.settings') }}" class="text-white/60 hover:text-white text-xs font-bold px-4 py-3 border-b-2 border-transparent whitespace-nowrap transition-colors">Pengaturan</a>
            <a href="{{ route('kemendikdasmen.broadcast') }}" class="text-white/60 hover:text-white text-xs font-bold px-4 py-3 border-b-2 border-transparent whitespace-nowrap transition-colors">Broadcast</a>
        </div>
    </div>

    <main class="w-full max-w-6xl mx-auto px-4 py-8 flex flex-col gap-6">

        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
            <div>
                <span class="inline-block bg-[#003366] text-white text-[10px] font-bold px-3 py-1.5 rounded-full mb-2">ADMIN DIREKTORAT SMK</span>
                <h1 class="text-xl font-extrabold text-gray-800">Manajemen Sekolah</h1>
                <p class="text-sm text-gray-500">Daftar sekolah yang sudah mendaftarkan akun Guru BK, beserta jumlah siswa terdaftar.</p>
            </div>
            <button type="button" onclick="document.getElementById('form-tambah-sekolah').classList.toggle('hidden')" class="bg-[#003366] text-white text-xs font-bold px-4 py-2.5 rounded-xl hover:bg-[#002855] transition-colors inline-flex items-center gap-2 shrink-0">
                <i class="fa-solid fa-plus"></i> Tambah Sekolah
            </button>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-100 text-green-700 text-xs rounded-xl p-3">{{ session('success') }}</div>
        @endif

        {{-- Form tambah sekolah --}}
        <div id="form-tambah-sekolah" class="{{ $errors->any() ? '' : 'hidden' }} bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
            <h2 class="font-bold text-gray-800 text-sm mb-4">Tambah Sekolah Baru</h2>

            @if($errors->any())
                <div class="bg-red-50 border border-red-100 text-red-600 text-xs rounded-xl p-3 mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('kemendikdasmen.users.store') }}" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Nama Sekolah</label>
                    <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah') }}" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">NPSN</label>
                    <input type="text" name="npsn" value="{{ old('npsn') }}" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Jenjang</label>
                    <select name="jenjang" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">
                        <option value="">-- Pilih Jenjang --</option>
                        <option value="smp" {{ old('jenjang') === 'smp' ? 'selected' : '' }}>SMP</option>
                        <option value="smk" {{ old('jenjang') === 'smk' ? 'selected' : '' }}>SMK</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Nama Penanggung Jawab (Guru BK)</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Password</label>
                    <input type="password" name="password" required minlength="8" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">
                </div>
                <div class="sm:col-span-2 flex gap-3 pt-2">
                    <button type="submit" class="bg-[#003366] text-white text-xs font-bold px-5 py-2.5 rounded-xl hover:bg-[#002855] transition-colors">Simpan Sekolah</button>
                    <button type="button" onclick="document.getElementById('form-tambah-sekolah').classList.add('hidden')" class="text-xs font-bold text-gray-400 px-5 py-2.5 hover:text-gray-600">Batal</button>
                </div>
            </form>
        </div>

        {{-- Search, filter jenjang, per-page --}}
        <form method="GET" action="{{ route('kemendikdasmen.users') }}" class="bg-white border border-gray-100 rounded-2xl shadow-sm p-4 flex flex-col sm:flex-row gap-3 sm:items-end">
            <div class="flex-1">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Cari Sekolah</label>
                <input type="text" name="search" value="{{ $search }}" placeholder="Nama sekolah, NPSN, penanggung jawab, atau email..." class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Jenjang</label>
                <select name="jenjang" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">
                    <option value="" {{ $jenjang === '' ? 'selected' : '' }}>Semua</option>
                    <option value="smp" {{ $jenjang === 'smp' ? 'selected' : '' }}>SMP</option>
                    <option value="smk" {{ $jenjang === 'smk' ? 'selected' : '' }}>SMK</option>
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
            @if($search !== '' || $jenjang !== '')
                <a href="{{ route('kemendikdasmen.users') }}" class="text-xs font-bold text-gray-400 px-3 py-2.5 hover:text-gray-600 text-center">Reset</a>
            @endif
        </form>

        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
            @if($instansiPaginated->isEmpty())
                <div class="p-10 text-center">
                    <p class="text-sm text-gray-500">Tidak ada sekolah yang cocok dengan pencarian/filter ini.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-left">
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Nama Sekolah</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Jenjang</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">NPSN</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Penanggung Jawab</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Email</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Jumlah Siswa</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Terdaftar Sejak</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($instansiPaginated as $i)
                                <tr class="border-t border-gray-50 hover:bg-gray-50 transition-colors">
                                    <td class="px-5 py-3 font-bold text-gray-700">{{ $i->nama_sekolah }}</td>
                                    <td class="px-5 py-3">
                                        @if($i->jenjang === 'smp')
                                            <span class="bg-orange-50 text-[#c2410c] text-[10px] font-bold px-2.5 py-1 rounded-full">SMP</span>
                                        @elseif($i->jenjang === 'smk')
                                            <span class="bg-blue-50 text-[#2F6FED] text-[10px] font-bold px-2.5 py-1 rounded-full">SMK</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-400 text-[10px] font-bold px-2.5 py-1 rounded-full">-</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3 text-gray-500">{{ $i->npsn }}</td>
                                    <td class="px-5 py-3 text-gray-500">{{ $i->name }}</td>
                                    <td class="px-5 py-3 text-gray-500">{{ $i->email }}</td>
                                    <td class="px-5 py-3">
                                        <span class="bg-blue-50 text-[#003366] text-[10px] font-bold px-2.5 py-1 rounded-full">{{ $i->jumlah_siswa }} siswa</span>
                                    </td>
                                    <td class="px-5 py-3 text-gray-500">{{ $i->created_at->format('d M Y') }}</td>
                                    <td class="px-5 py-3">
                                        <form method="POST" action="{{ route('kemendikdasmen.users.destroy', $i->id) }}" onsubmit="return confirm('Yakin hapus akun sekolah {{ addslashes($i->nama_sekolah) }}? Data siswa yang sudah terdaftar di sekolah ini TIDAK ikut terhapus.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-bold" title="Hapus sekolah ini">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($instansiPaginated->hasPages())
                    <div class="flex items-center justify-between px-5 py-3 border-t border-gray-100">
                        <p class="text-xs text-gray-400">Menampilkan {{ $instansiPaginated->firstItem() }}-{{ $instansiPaginated->lastItem() }} dari {{ $instansiPaginated->total() }} sekolah</p>
                        <div class="flex items-center gap-2">
                            @if($instansiPaginated->onFirstPage())
                                <span class="text-xs font-bold text-gray-300 px-3 py-1.5">&larr; Sebelumnya</span>
                            @else
                                <a href="{{ $instansiPaginated->previousPageUrl() }}" class="text-xs font-bold text-[#003366] px-3 py-1.5 rounded-lg hover:bg-gray-50">&larr; Sebelumnya</a>
                            @endif
                            <span class="text-xs text-gray-500">Hal {{ $instansiPaginated->currentPage() }} / {{ $instansiPaginated->lastPage() }}</span>
                            @if($instansiPaginated->hasMorePages())
                                <a href="{{ $instansiPaginated->nextPageUrl() }}" class="text-xs font-bold text-[#003366] px-3 py-1.5 rounded-lg hover:bg-gray-50">Berikutnya &rarr;</a>
                            @else
                                <span class="text-xs font-bold text-gray-300 px-3 py-1.5">Berikutnya &rarr;</span>
                            @endif
                        </div>
                    </div>
                @endif
            @endif
        </div>

    </main>

</body>
</html>