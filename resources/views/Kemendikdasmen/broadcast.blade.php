<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Broadcast - Bakat Minat</title>
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
            <a href="{{ route('kemendikdasmen.questions') }}" class="text-white/60 hover:text-white text-xs font-bold px-4 py-3 border-b-2 border-transparent whitespace-nowrap transition-colors">Bank Soal</a>
            <a href="{{ route('kemendikdasmen.settings') }}" class="text-white/60 hover:text-white text-xs font-bold px-4 py-3 border-b-2 border-transparent whitespace-nowrap transition-colors">Pengaturan</a>
            <a href="{{ route('kemendikdasmen.broadcast') }}" class="text-white text-xs font-bold px-4 py-3 border-b-2 border-white whitespace-nowrap">Broadcast</a>
        </div>
    </div>

    <main class="w-full max-w-6xl mx-auto px-4 py-8 flex flex-col gap-6">

        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
            <div>
                <span class="inline-block bg-[#003366] text-white text-[10px] font-bold px-3 py-1.5 rounded-full mb-2">ADMIN DIREKTORAT SMK</span>
                <h1 class="text-xl font-extrabold text-gray-800">Broadcast &amp; Announcement Center</h1>
                <p class="text-sm text-gray-500">Kirim pengumuman ke siswa dan/atau Guru BK, bisa dipisah per jenjang.</p>
            </div>
            <button type="button" onclick="document.getElementById('form-broadcast').classList.toggle('hidden')" class="bg-[#003366] text-white text-xs font-bold px-4 py-2.5 rounded-xl hover:bg-[#002855] transition-colors inline-flex items-center gap-2 shrink-0">
                <i class="fa-solid fa-paper-plane"></i> Buat Broadcast
            </button>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-100 text-green-700 text-xs rounded-xl p-3">{{ session('success') }}</div>
        @endif

        {{-- Form buat broadcast --}}
        <div id="form-broadcast" class="{{ $errors->any() ? '' : 'hidden' }} bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
            <h2 class="font-bold text-gray-800 text-sm mb-4">Buat Broadcast Baru</h2>

            @if($errors->any())
                <div class="bg-red-50 border border-red-100 text-red-600 text-xs rounded-xl p-3 mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('kemendikdasmen.broadcast.store') }}" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Subjek</label>
                    <input type="text" name="subjek" value="{{ old('subjek') }}" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Isi Pengumuman</label>
                    <textarea name="isi" rows="4" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">{{ old('isi') }}</textarea>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1.5">Target Penerima</label>
                        <select name="target_penerima" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">
                            <option value="semua" {{ old('target_penerima') === 'semua' ? 'selected' : '' }}>Semua (Siswa &amp; Guru BK)</option>
                            <option value="siswa" {{ old('target_penerima') === 'siswa' ? 'selected' : '' }}>Khusus Siswa</option>
                            <option value="guru_bk" {{ old('target_penerima') === 'guru_bk' ? 'selected' : '' }}>Khusus Guru BK</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1.5">Target Jenjang</label>
                        <select name="target_jenjang" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">
                            <option value="semua" {{ old('target_jenjang') === 'semua' ? 'selected' : '' }}>Semua (SMP &amp; SMK)</option>
                            <option value="smp" {{ old('target_jenjang') === 'smp' ? 'selected' : '' }}>Khusus SMP</option>
                            <option value="smk" {{ old('target_jenjang') === 'smk' ? 'selected' : '' }}>Khusus SMK</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="bg-[#003366] text-white text-xs font-bold px-5 py-2.5 rounded-xl hover:bg-[#002855] transition-colors">Kirim Broadcast</button>
                    <button type="button" onclick="document.getElementById('form-broadcast').classList.add('hidden')" class="text-xs font-bold text-gray-400 px-5 py-2.5 hover:text-gray-600">Batal</button>
                </div>
            </form>
        </div>

        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
            @if($historyBroadcast->isEmpty())
                <div class="p-10 text-center">
                    <p class="text-sm text-gray-500">Belum ada broadcast yang dikirim.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-left">
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Subjek</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Penerima</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Jenjang</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tanggal</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $labelPenerima = ['siswa' => 'Siswa', 'guru_bk' => 'Guru BK', 'semua' => 'Semua'];
                                $labelJenjang = ['smp' => 'SMP', 'smk' => 'SMK', 'semua' => 'Semua'];
                            @endphp
                            @foreach($historyBroadcast as $b)
                                <tr class="border-t border-gray-50 hover:bg-gray-50 transition-colors align-top">
                                    <td class="px-5 py-3">
                                        <p class="font-bold text-gray-700">{{ $b->subjek }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5 line-clamp-2">{{ $b->isi }}</p>
                                    </td>
                                    <td class="px-5 py-3">
                                        <span class="bg-blue-50 text-[#003366] text-[10px] font-bold px-2.5 py-1 rounded-full">{{ $labelPenerima[$b->target_penerima] ?? $b->target_penerima }}</span>
                                    </td>
                                    <td class="px-5 py-3">
                                        @if($b->target_jenjang === 'smp')
                                            <span class="bg-orange-50 text-[#c2410c] text-[10px] font-bold px-2.5 py-1 rounded-full">SMP</span>
                                        @elseif($b->target_jenjang === 'smk')
                                            <span class="bg-blue-50 text-[#2F6FED] text-[10px] font-bold px-2.5 py-1 rounded-full">SMK</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-500 text-[10px] font-bold px-2.5 py-1 rounded-full">Semua</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3 text-gray-500 whitespace-nowrap">{{ $b->created_at->format('d M Y') }}</td>
                                    <td class="px-5 py-3">
                                        <form method="POST" action="{{ route('kemendikdasmen.broadcast.destroy', $b->id) }}" onsubmit="return confirm('Yakin hapus broadcast ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-bold" title="Hapus broadcast ini">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
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