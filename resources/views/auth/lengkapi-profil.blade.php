<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Profil - Bakat Minat</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8fafc] font-sans text-gray-800 min-h-screen flex items-center justify-center relative overflow-x-hidden py-10">

    @php
        $isSmk = (Auth::user()->jenjang ?? 'smp') === 'smk';
        $kelasOptions = $isSmk ? [10, 11, 12, 13] : [7, 8, 9];
    @endphp

    <div class="absolute w-72 h-72 bg-gradient-to-br from-[#7C3AED] to-[#EC4899] opacity-20 rounded-full -top-16 -left-16"></div>
    <div class="absolute w-72 h-72 bg-gradient-to-br from-[#22C1C3] to-[#2F6FED] opacity-20 rounded-full -bottom-16 -right-10"></div>

    <div class="w-full max-w-lg relative z-10 px-4">
        <div class="flex items-center justify-center gap-2 text-[#003366] font-bold text-lg mb-8">
            <i class="fa-solid fa-graduation-cap"></i>
            <span>Bakat Minat</span>
        </div>

        <div class="bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 p-6 md:p-10">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-10 h-1.5 rounded-full bg-gradient-to-r from-[#7C3AED] to-[#EC4899]"></div>
                <div class="w-10 h-1.5 rounded-full bg-gradient-to-r from-[#7C3AED] to-[#EC4899]"></div>
                <div class="w-10 h-1.5 rounded-full bg-gradient-to-r from-[#7C3AED] to-[#EC4899]"></div>
            </div>

            <p class="text-[10px] font-bold uppercase tracking-widest text-white inline-block px-4 py-1.5 rounded-full mb-4 {{ $isSmk ? 'bg-gradient-to-r from-[#2F6FED] to-[#22C1C3]' : 'bg-gradient-to-r from-[#FF7A45] to-[#FFB13D]' }}">Langkah 3 dari 3</p>
            <h1 class="text-xl md:text-2xl font-extrabold text-[#003366] mb-2">Lengkapi profilmu</h1>
            <p class="text-gray-500 text-sm mb-8">Data ini dipakai untuk mencocokkan hasil tesmu dengan sekolah dan rekomendasi jurusan.</p>

            <form method="POST" action="{{ route('lengkapi-profil.submit') }}" class="space-y-4">
                @csrf

                <div class="space-y-1.5">
                    <label for="name" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Nama lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required
                        class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm transition">
                    <p class="text-[10px] text-gray-400 italic">Diambil dari akun Google, sesuaikan jika belum lengkap.</p>
                    @error('name')
                        <p class="text-[11px] text-red-500 mt-0.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Email (dari Google)</label>
                    <input type="text" value="{{ Auth::user()->email }}" disabled
                        class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-sm text-gray-500">
                </div>

                <div class="space-y-1.5">
                    <label for="nisn" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">NISN</label>
                    <input type="text" id="nisn" name="nisn" maxlength="10" placeholder="10 digit Nomor Induk Siswa Nasional" value="{{ old('nisn') }}" required
                        class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm transition">
                    @error('nisn')
                        <p class="text-[11px] text-red-500 mt-0.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="asal_sekolah" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Asal sekolah</label>
                    <input type="text" id="asal_sekolah" name="asal_sekolah" placeholder="Contoh: SMP Negeri 1 Jakarta" value="{{ old('asal_sekolah') }}" required
                        class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm transition">
                    @error('asal_sekolah')
                        <p class="text-[11px] text-red-500 mt-0.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="kelas" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Kelas</label>
                    <select id="kelas" name="kelas" required
                        class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm transition">
                        <option value="" disabled {{ old('kelas') ? '' : 'selected' }}>Pilih kelas</option>
                        @foreach($kelasOptions as $k)
                            <option value="{{ $k }}" {{ old('kelas') == $k ? 'selected' : '' }}>Kelas {{ $k }}</option>
                        @endforeach
                    </select>
                    @error('kelas')
                        <p class="text-[11px] text-red-500 mt-0.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- DOMISILI (untuk rekomendasi SMK terdekat) -->
                <div class="pt-1">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Domisili Saat Ini</label>
                    <p class="text-[10px] text-gray-400 italic mb-3">Dipakai untuk mencocokkan rekomendasi SMK terdekat dari tempat tinggalmu.</p>

                    <div class="space-y-3">
                        <div class="space-y-1.5">
                            <label for="provinsi" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Provinsi</label>
                            <select id="provinsi" name="provinsi" required
                                class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm transition">
                                <option value="" disabled selected>Memuat provinsi...</option>
                            </select>
                            @error('provinsi')
                                <p class="text-[11px] text-red-500 mt-0.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="kabupaten_kota" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Kabupaten/Kota</label>
                            <select id="kabupaten_kota" name="kabupaten_kota" required disabled
                                class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm transition disabled:bg-gray-100 disabled:text-gray-400">
                                <option value="" disabled selected>Pilih provinsi dulu</option>
                            </select>
                            @error('kabupaten_kota')
                                <p class="text-[11px] text-red-500 mt-0.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="kecamatan" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Kecamatan</label>
                            <select id="kecamatan" name="kecamatan" required disabled
                                class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm transition disabled:bg-gray-100 disabled:text-gray-400">
                                <option value="" disabled selected>Pilih kabupaten/kota dulu</option>
                            </select>
                            @error('kecamatan')
                                <p class="text-[11px] text-red-500 mt-0.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="kelurahan" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Kelurahan/Desa</label>
                            <select id="kelurahan" name="kelurahan" required disabled
                                class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm transition disabled:bg-gray-100 disabled:text-gray-400">
                                <option value="" disabled selected>Pilih kecamatan dulu</option>
                            </select>
                            @error('kelurahan')
                                <p class="text-[11px] text-red-500 mt-0.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <label class="flex items-start gap-2 text-xs text-gray-500 pt-2">
                    <input type="checkbox" required class="mt-0.5">
                    Saya menyetujui bahwa data di atas benar dan digunakan untuk keperluan asesmen ini.
                </label>

                <button type="submit"
                    class="w-full bg-[#003E70] hover:bg-[#002B4E] text-white py-3.5 px-6 rounded-full font-bold text-sm flex items-center justify-center gap-2 shadow-lg shadow-blue-900/10 transition duration-200 mt-2">
                    Simpan dan Lanjutkan <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Dropdown wilayah berjenjang (provinsi -> kab/kota -> kecamatan -> kelurahan) -->
    <script>
        (function () {
            const oldValues = {
                provinsi: @json(old('provinsi')),
                kabupaten_kota: @json(old('kabupaten_kota')),
                kecamatan: @json(old('kecamatan')),
                kelurahan: @json(old('kelurahan')),
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
                    fillSelect(selProvinsi, data, 'Pilih Provinsi', oldValues.provinsi);
                    if (oldValues.provinsi) {
                        const kode = getSelectedKode(selProvinsi);
                        if (kode) await loadKabKota(kode, oldValues.kabupaten_kota);
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
                        if (kode) await loadKecamatan(kode, oldValues.kecamatan);
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
                        if (kode) await loadKelurahan(kode, oldValues.kelurahan);
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