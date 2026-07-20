<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Soal - Bakat Minat</title>
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

    <main class="w-full max-w-3xl mx-auto px-4 py-8 flex flex-col gap-6">

        <div>
            <a href="{{ route('kemendikdasmen.questions') }}" class="text-xs font-bold text-[#003366] hover:underline">&larr; Kembali ke Bank Soal</a>
            <h1 class="text-xl font-extrabold text-gray-800 mt-2">Edit Soal</h1>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-100 text-red-600 text-xs rounded-xl p-3">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
            <form method="POST" action="{{ route('kemendikdasmen.questions.update', $soal->id) }}" class="flex flex-col gap-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Pernyataan</label>
                    <textarea name="pernyataan" rows="3" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">{{ old('pernyataan', $soal->pernyataan) }}</textarea>
                </div>
                <div class="max-w-xs">
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Aspek RIASEC</label>
                    <select name="aspek" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">
                        @foreach(['R' => 'Realistic', 'I' => 'Investigative', 'A' => 'Artistic', 'S' => 'Social', 'E' => 'Enterprising', 'C' => 'Conventional'] as $kode => $label)
                            <option value="{{ $kode }}" {{ old('aspek', $soal->aspek) === $kode ? 'selected' : '' }}>{{ $kode }} - {{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="max-w-xs">
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Status</label>
                    <select name="status" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#003366]/20">
                        <option value="aktif" {{ old('status', $soal->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $soal->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    <p class="text-[10px] text-gray-400 mt-1">Soal berstatus nonaktif tidak akan ditampilkan ke siswa saat mengerjakan tes.</p>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="bg-[#003366] text-white text-xs font-bold px-5 py-2.5 rounded-xl hover:bg-[#002855] transition-colors">Simpan Perubahan</button>
                    <a href="{{ route('kemendikdasmen.questions') }}" class="text-xs font-bold text-gray-400 px-5 py-2.5 hover:text-gray-600">Batal</a>
                </div>
            </form>
        </div>

    </main>

</body>
</html>