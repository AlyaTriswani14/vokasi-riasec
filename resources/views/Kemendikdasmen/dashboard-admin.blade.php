<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Bakat Minat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
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
            <a href="{{ route('kemendikdasmen.dashboard') }}" class="text-white text-xs font-bold px-4 py-3 border-b-2 border-white whitespace-nowrap">Dashboard</a>
            <a href="{{ route('kemendikdasmen.users') }}" class="text-white/60 hover:text-white text-xs font-bold px-4 py-3 border-b-2 border-transparent whitespace-nowrap transition-colors">Manajemen Sekolah</a>
            <a href="{{ route('kemendikdasmen.questions') }}" class="text-white/60 hover:text-white text-xs font-bold px-4 py-3 border-b-2 border-transparent whitespace-nowrap transition-colors">Bank Soal</a>
            <a href="{{ route('kemendikdasmen.settings') }}" class="text-white/60 hover:text-white text-xs font-bold px-4 py-3 border-b-2 border-transparent whitespace-nowrap transition-colors">Pengaturan</a>
            <a href="{{ route('kemendikdasmen.broadcast') }}" class="text-white/60 hover:text-white text-xs font-bold px-4 py-3 border-b-2 border-transparent whitespace-nowrap transition-colors">Broadcast</a>
        </div>
    </div>

    <main class="w-full max-w-6xl mx-auto px-4 py-8 flex flex-col gap-6">

        <div>
            <span class="inline-block bg-[#003366] text-white text-[10px] font-bold px-3 py-1.5 rounded-full mb-2">ADMIN DIREKTORAT SMK</span>
            <h1 class="text-xl font-extrabold text-gray-800">Dashboard Analitik Platform</h1>
            <p class="text-sm text-gray-500">Ringkasan data seluruh sekolah &amp; siswa yang terdaftar, dipisah per jenjang.</p>
        </div>

        {{-- Stats: 6 kartu, dipisah SMP (oranye) & SMK (biru) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-orange-50 text-[#c2410c] flex items-center justify-center mb-3">
                    <i class="fa-solid fa-child-reaching"></i>
                </div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Siswa SMP Terdaftar</p>
                <h2 class="text-2xl font-extrabold text-gray-800">{{ number_format($totalSiswaSmp) }}</h2>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#2F6FED] flex items-center justify-center mb-3">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Siswa SMK Terdaftar</p>
                <h2 class="text-2xl font-extrabold text-gray-800">{{ number_format($totalSiswaSmk) }}</h2>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center mb-3">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total Tes Selesai</p>
                <h2 class="text-2xl font-extrabold text-green-600">{{ number_format($totalTesSmp + $totalTesSmk) }}</h2>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-orange-50 text-[#c2410c] flex items-center justify-center mb-3">
                    <i class="fa-solid fa-school"></i>
                </div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">SMP Terdaftar</p>
                <h2 class="text-2xl font-extrabold text-gray-800">{{ number_format($totalSekolahSmp) }}</h2>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#2F6FED] flex items-center justify-center mb-3">
                    <i class="fa-solid fa-building-columns"></i>
                </div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">SMK Terdaftar</p>
                <h2 class="text-2xl font-extrabold text-gray-800">{{ number_format($totalSekolahSmk) }}</h2>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-teal-50 text-[#0f766e] flex items-center justify-center mb-3">
                    <i class="fa-solid fa-chart-simple"></i>
                </div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Tes SMP / SMK Selesai</p>
                <h2 class="text-lg font-extrabold text-gray-800">{{ number_format($totalTesSmp) }} <span class="text-[#c2410c]">SMP</span> &middot; {{ number_format($totalTesSmk) }} <span class="text-[#2F6FED]">SMK</span></h2>
            </div>
        </div>

        {{-- Tren peserta tes --}}
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
            <h2 class="font-bold text-gray-800 text-sm mb-1">Tren Peserta Tes RIASEC</h2>
            <p class="text-xs text-gray-400 mb-4">Jumlah siswa yang menyelesaikan tes per bulan, dipisah jenjang.</p>

            @if(count($trendLabels) === 0)
                <div class="p-10 text-center">
                    <p class="text-sm text-gray-500">Belum ada data tes untuk ditampilkan dalam grafik.</p>
                </div>
            @else
                <div class="relative" style="height: 280px;">
                    <canvas id="trendChart"></canvas>
                </div>
            @endif
        </div>

        {{-- Top sekolah --}}
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                <h2 class="font-bold text-gray-800 text-sm">Top 5 Sekolah (Jumlah Siswa Terdaftar)</h2>
                <a href="{{ route('kemendikdasmen.users') }}" class="text-[10px] font-bold text-[#003366] hover:underline">Lihat semua &rarr;</a>
            </div>

            @if($topSekolah->isEmpty())
                <div class="p-10 text-center">
                    <p class="text-sm text-gray-500">Belum ada sekolah yang mendaftarkan akun Guru BK.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-left">
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Peringkat</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Nama Sekolah</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">NPSN</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Jumlah Siswa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topSekolah as $i => $s)
                                <tr class="border-t border-gray-50">
                                    <td class="px-5 py-3 font-bold text-gray-400">#{{ $i + 1 }}</td>
                                    <td class="px-5 py-3 font-bold text-gray-700">{{ $s['nama'] }}</td>
                                    <td class="px-5 py-3 text-gray-500">{{ $s['npsn'] }}</td>
                                    <td class="px-5 py-3">
                                        <span class="bg-blue-50 text-[#003366] text-[10px] font-bold px-2.5 py-1 rounded-full">{{ $s['jumlah_siswa'] }} siswa</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </main>

    @if(count($trendLabels) > 0)
    <script>
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($trendLabels) !!},
                datasets: [
                    {
                        label: 'SMP',
                        data: {!! json_encode($trendDataSmp) !!},
                        borderColor: '#F97316',
                        backgroundColor: 'rgba(249,115,22,0.1)',
                        tension: 0.3,
                        fill: true,
                    },
                    {
                        label: 'SMK',
                        data: {!! json_encode($trendDataSmk) !!},
                        borderColor: '#2F6FED',
                        backgroundColor: 'rgba(47,111,237,0.1)',
                        tension: 0.3,
                        fill: true,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { font: { size: 11 } } },
                },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } },
                },
            },
        });
    </script>
    @endif

</body>
</html>