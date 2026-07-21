<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Bakat Minat</title>
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
        $kelasOptions = $isSmk ? [10, 11, 12, 13] : [7, 8, 9];

        $tipeLabels = [
            'r' => 'Realistic', 'i' => 'Investigative', 'a' => 'Artistic',
            's' => 'Social', 'e' => 'Enterprising', 'c' => 'Conventional',
        ];
        $top3 = [];
        if ($hasilTes) {
            $skorArr = [
                'r' => $hasilTes->skor_r, 'i' => $hasilTes->skor_i, 'a' => $hasilTes->skor_a,
                's' => $hasilTes->skor_s, 'e' => $hasilTes->skor_e, 'c' => $hasilTes->skor_c,
            ];
            $persenArr = [];
            foreach ($skorArr as $kode => $skor) {
                $persenArr[$kode] = round(($skor / 7) * 100);
            }
            arsort($persenArr);
            $top3 = array_slice($persenArr, 0, 3, true);
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

    <main class="flex-grow w-full max-w-3xl mx-auto px-4 pt-6 pb-12 flex flex-col gap-5">

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 text-xs font-bold rounded-xl p-3">
                {{ session('success') }}
            </div>
        @endif

        {{-- Ringkasan profil --}}
        <div class="flex flex-col items-center text-center">
            <div class="w-20 h-20 rounded-full flex items-center justify-center text-2xl text-white font-bold shadow-sm mb-3" style="background: linear-gradient(135deg, {{ $gradFrom }}, {{ $gradTo }});">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>
            <h2 class="text-xl font-extrabold text-gray-800">{{ Auth::user()->name }}</h2>
            <span class="inline-block {{ $accentBg }} {{ $accentText }} text-[10px] font-bold px-2.5 py-1 rounded-full mt-1.5">{{ $badgeLabel }}</span>
            <p class="text-xs text-gray-500 mt-2">
                NISN: {{ Auth::user()->nisn ?: '-' }} &bull; {{ Auth::user()->asal_sekolah ?: '-' }}
            </p>
        </div>

        {{-- Hasil tes terakhir --}}
        <div class="bg-white border {{ $accentBorder }} rounded-2xl p-5 shadow-sm">
            <div class="flex justify-between items-center mb-3">
                <p class="text-[10px] font-bold text-gray-400 tracking-wider uppercase">Hasil Tes Terakhir</p>
                <span class="text-[10px] text-gray-400 font-medium">
                    {{ $hasilTes ? $hasilTes->created_at->format('d M Y') : '-' }}
                </span>
            </div>
            @if($hasilTes)
                <div class="grid grid-cols-3 gap-2">
                    @foreach($top3 as $kode => $persen)
                        <div class="rounded-xl {{ $accentBg }} p-3 text-center">
                            <p class="text-[10px] font-bold text-gray-400 mb-0.5">#{{ $loop->iteration }}</p>
                            <p class="font-extrabold {{ $accentText }} text-base">{{ strtoupper($kode) }}</p>
                            <p class="text-[10px] font-medium text-gray-500 mb-1">{{ $tipeLabels[$kode] }}</p>
                            <p class="text-xs font-bold text-gray-700">{{ $persen }}%</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-2">Belum ada hasil tes yang tersimpan.</p>
            @endif
        </div>

        {{-- Data diri --}}
        <div class="bg-white border {{ $accentBorder }} rounded-2xl p-5 shadow-sm">
            <p class="text-[10px] font-bold text-gray-400 tracking-wider uppercase mb-4">Data Diri</p>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 text-xs rounded-xl p-3 mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profil.update') }}" method="POST" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-offset-1"
                        style="--tw-ring-color: {{ $gradFrom }};">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1.5">Email</label>
                    <input type="email" value="{{ Auth::user()->email }}" disabled
                        class="w-full border border-gray-200 bg-gray-50 text-gray-400 rounded-xl px-4 py-2.5 text-sm">
                    <p class="text-[10px] text-gray-400 mt-1 italic">Terhubung dari akun Google, tidak bisa diubah.</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1.5">NISN</label>
                    <input type="text" name="nisn" maxlength="10" value="{{ old('nisn', Auth::user()->nisn) }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-offset-1"
                        style="--tw-ring-color: {{ $gradFrom }};">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1.5">Asal Sekolah</label>
                    <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah', Auth::user()->asal_sekolah) }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-offset-1"
                        style="--tw-ring-color: {{ $gradFrom }};">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1.5">Kelas</label>
                    <select name="kelas"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-offset-1"
                        style="--tw-ring-color: {{ $gradFrom }};">
                        <option value="" disabled {{ Auth::user()->kelas ? '' : 'selected' }}>Pilih kelas</option>
                        @foreach($kelasOptions as $k)
                            <option value="{{ $k }}" {{ old('kelas', Auth::user()->kelas) == $k ? 'selected' : '' }}>Kelas {{ $k }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="pt-1">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Domisili Saat Ini</label>
                    <p class="text-[10px] text-gray-400 italic mb-3">Dipakai untuk mencocokkan rekomendasi SMK terdekat dari tempat tinggalmu.</p>

                    <div class="flex flex-col gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1.5">Provinsi</label>
                            <select id="provinsi" name="provinsi"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-offset-1"
                                style="--tw-ring-color: {{ $gradFrom }};">
                                <option value="" disabled selected>Memuat provinsi...</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1.5">Kabupaten/Kota</label>
                            <select id="kabupaten_kota" name="kabupaten_kota" disabled
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-offset-1 disabled:bg-gray-100 disabled:text-gray-400"
                                style="--tw-ring-color: {{ $gradFrom }};">
                                <option value="" disabled selected>Pilih provinsi dulu</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1.5">Kecamatan</label>
                            <select id="kecamatan" name="kecamatan" disabled
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-offset-1 disabled:bg-gray-100 disabled:text-gray-400"
                                style="--tw-ring-color: {{ $gradFrom }};">
                                <option value="" disabled selected>Pilih kabupaten/kota dulu</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1.5">Kelurahan/Desa</label>
                            <select id="kelurahan" name="kelurahan" disabled
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-offset-1 disabled:bg-gray-100 disabled:text-gray-400"
                                style="--tw-ring-color: {{ $gradFrom }};">
                                <option value="" disabled selected>Pilih kecamatan dulu</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="{{ $accentBtn }} text-white font-bold text-sm py-3 rounded-xl transition-colors mt-1">
                    Simpan Perubahan
                </button>
            </form>
        </div>

        {{-- Pengaturan akun --}}
        <div class="bg-white border {{ $accentBorder }} rounded-2xl shadow-sm flex flex-col overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <i class="fa-brands fa-google text-gray-400 w-6 text-center text-lg"></i>
                    <div>
                        <span class="font-medium text-gray-800 text-sm block">Login pakai Akun Google</span>
                        <span class="text-[10px] text-gray-400">Tidak ada password terpisah untuk diubah</span>
                    </div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-between p-4 hover:bg-red-50 transition-colors text-left">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-arrow-right-from-bracket text-red-500 w-6 text-center text-lg"></i>
                        <span class="font-bold text-red-500 text-sm">Keluar</span>
                    </div>
                </button>
            </form>
        </div>

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
        <a href="{{ route('rekomendasi.index') }}" class="flex flex-col items-center justify-center gap-1 text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fa-solid fa-bullseye text-lg"></i>
            <span class="text-[10px] font-medium">Rekomendasi</span>
        </a>
        <a href="{{ route('profil') }}" class="flex flex-col items-center justify-center gap-1 {{ $accentText }}">
            <i class="fa-regular fa-user text-lg"></i>
            <span class="text-[10px] font-bold">Profil</span>
        </a>
    </div>

    <!-- Dropdown wilayah berjenjang (provinsi -> kab/kota -> kecamatan -> kelurahan) -->
    <script>
        (function () {
            const savedValues = {
                provinsi: @json(old('provinsi', Auth::user()->provinsi)),
                kabupaten_kota: @json(old('kabupaten_kota', Auth::user()->kabupaten_kota)),
                kecamatan: @json(old('kecamatan', Auth::user()->kecamatan)),
                kelurahan: @json(old('kelurahan', Auth::user()->kelurahan)),
            };

            const selProvinsi = document.getElementById('provinsi');
            const selKabKota = document.getElementById('kabupaten_kota');
            const selKecamatan = document.getElementById('kecamatan');
            const selKelurahan = document.getElementById('kelurahan');

            function resetSelect(select, placeholder) {
                select.innerHTML = `<option value="" disabled selected>${placeholder}</option>`;
                select.disabled = true;
            }

            function fillSelect(select, items, placeholder, selectedName) {
                select.innerHTML = `<option value="" disabled ${selectedName ? '' : 'selected'}>${placeholder}</option>`;
                items.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item.nama;
                    opt.dataset.kode = item.kode;
                    opt.textContent = item.nama;
                    if (selectedName && item.nama === selectedName) {
                        opt.selected = true;
                    }
                    select.appendChild(opt);
                });
                select.disabled = false;
            }

            function getSelectedKode(select) {
                const opt = select.options[select.selectedIndex];
                return opt ? opt.dataset.kode : null;
            }

            async function loadProvinsi() {
                try {
                    const res = await fetch('{{ route('wilayah.provinsi') }}');
                    const data = await res.json();
                    fillSelect(selProvinsi, data, 'Pilih Provinsi', savedValues.provinsi);
                    if (savedValues.provinsi) {
                        const kode = getSelectedKode(selProvinsi);
                        if (kode) await loadKabKota(kode, savedValues.kabupaten_kota);
                    }
                } catch (e) {
                    selProvinsi.innerHTML = '<option value="" disabled selected>Gagal memuat provinsi</option>';
                }
            }

            async function loadKabKota(kodeProvinsi, selectedName) {
                resetSelect(selKabKota, 'Memuat...');
                resetSelect(selKecamatan, 'Pilih kabupaten/kota dulu');
                resetSelect(selKelurahan, 'Pilih kecamatan dulu');
                try {
                    const res = await fetch(`{{ url('/api/wilayah/kabupaten-kota') }}/${kodeProvinsi}`);
                    const data = await res.json();
                    fillSelect(selKabKota, data, 'Pilih Kabupaten/Kota', selectedName);
                    if (selectedName) {
                        const kode = getSelectedKode(selKabKota);
                        if (kode) await loadKecamatan(kode, savedValues.kecamatan);
                    }
                } catch (e) {
                    selKabKota.innerHTML = '<option value="" disabled selected>Gagal memuat data</option>';
                }
            }

            async function loadKecamatan(kodeKabKota, selectedName) {
                resetSelect(selKecamatan, 'Memuat...');
                resetSelect(selKelurahan, 'Pilih kecamatan dulu');
                try {
                    const res = await fetch(`{{ url('/api/wilayah/kecamatan') }}/${kodeKabKota}`);
                    const data = await res.json();
                    fillSelect(selKecamatan, data, 'Pilih Kecamatan', selectedName);
                    if (selectedName) {
                        const kode = getSelectedKode(selKecamatan);
                        if (kode) await loadKelurahan(kode, savedValues.kelurahan);
                    }
                } catch (e) {
                    selKecamatan.innerHTML = '<option value="" disabled selected>Gagal memuat data</option>';
                }
            }

            async function loadKelurahan(kodeKecamatan, selectedName) {
                resetSelect(selKelurahan, 'Memuat...');
                try {
                    const res = await fetch(`{{ url('/api/wilayah/kelurahan') }}/${kodeKecamatan}`);
                    const data = await res.json();
                    fillSelect(selKelurahan, data, 'Pilih Kelurahan/Desa', selectedName);
                } catch (e) {
                    selKelurahan.innerHTML = '<option value="" disabled selected>Gagal memuat data</option>';
                }
            }

            selProvinsi.addEventListener('change', function () {
                const kode = getSelectedKode(this);
                if (kode) loadKabKota(kode, null);
            });

            selKabKota.addEventListener('change', function () {
                const kode = getSelectedKode(this);
                if (kode) loadKecamatan(kode, null);
            });

            selKecamatan.addEventListener('change', function () {
                const kode = getSelectedKode(this);
                if (kode) loadKelurahan(kode, null);
            });

            loadProvinsi();
        })();
    </script>

</body>
</html>