<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Broadcast Center - Admin Pusat</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Material+Symbols+Outlined" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: { extend: { colors: { "primary": "#003e6f", "secondary-container": "#7ef7e5", "on-secondary-container": "#007166", "surface-container-low": "#f2f4f6", "outline-variant": "#c1c7d2", "on-surface": "#191c1e", "on-surface-variant": "#414750" } } }
        }
    </script>
</head>
<body class="flex overflow-hidden h-screen bg-[#f7f9fb]">

<aside class="h-screen w-64 fixed left-0 top-0 bg-surface-container-low flex flex-col p-4 gap-2 border-r border-outline-variant z-50">
    <div class="flex items-center gap-3 px-2 mb-8">
        <span class="material-symbols-outlined text-primary text-3xl">admin_panel_settings</span>
        <div class="flex flex-col">
            <span class="font-bold text-primary leading-tight text-sm">Admin Central</span>
            <span class="text-[10px] text-on-surface-variant uppercase tracking-wider font-bold">Kemendikdasmen</span>
        </div>
    </div>
    <nav class="flex-1 space-y-1">
        <a class="text-on-surface-variant hover:bg-outline-variant/30 rounded-lg flex items-center px-4 py-3 transition text-xs font-bold" href="{{ route('kemendikdasmen.dashboard') }}"><span class="material-symbols-outlined mr-3">dashboard</span>Dashboard</a>
        <a class="text-on-surface-variant hover:bg-outline-variant/30 rounded-lg flex items-center px-4 py-3 transition text-xs font-bold" href="{{ route('kemendikdasmen.users') }}"><span class="material-symbols-outlined mr-3">group</span>User Management</a>
        <a class="text-on-surface-variant hover:bg-outline-variant/30 rounded-lg flex items-center px-4 py-3 transition text-xs font-bold" 
   href="{{ route('kemendikdasmen.questions') }}">
    <span class="material-symbols-outlined mr-3">quiz</span>Manajemen Soal
</a>
        <a class="text-on-surface-variant hover:bg-outline-variant/30 rounded-lg flex items-center px-4 py-3 transition text-xs font-bold" href="{{ route('kemendikdasmen.settings') }}"><span class="material-symbols-outlined mr-3">settings</span>System Settings</a>
        <a class="bg-secondary-container text-on-secondary-container font-bold rounded-lg flex items-center px-4 py-3 transition text-xs" href="{{ route('kemendikdasmen.broadcast') }}"><span class="material-symbols-outlined mr-3">campaign</span>Broadcast Center</a>
    </nav>
    <div class="pt-4 border-t border-outline-variant">
        <form action="{{ route('kemendikdasmen.logout') }}" method="POST">@csrf
            <button type="submit" class="w-full text-red-600 hover:bg-red-50 rounded-lg flex items-center px-4 py-3 transition font-bold text-xs"><span class="material-symbols-outlined mr-3">logout</span>Keluar</button>
        </form>
    </div>
</aside>

<main class="flex-1 pl-64 h-screen overflow-y-auto">
    <div class="p-8 space-y-6 max-w-[1100px] mx-auto">
        <div>
            <h1 class="text-2xl font-bold text-primary">Broadcast & Announcement Center</h1>
            <p class="text-xs text-on-surface-variant uppercase font-bold tracking-wider">Kirim Pengumuman Massal Langsung ke Dashboard Instansi & Guru</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-outline-variant shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-primary uppercase tracking-wide">Buat Pesan Pengumuman Baru</h3>
                <div>
                    <label class="block text-[11px] font-bold mb-1.5 text-on-surface-variant">SUBJEK PENGUMUMAN</label>
                    <input type="text" class="w-full rounded-xl border-outline-variant text-sm" placeholder="Contoh: Jadwal Sinkronisasi Gelombang 2">
                </div>
                <div>
                    <label class="block text-[11px] font-bold mb-1.5 text-on-surface-variant">TARGET AKTOR</label>
                    <select class="w-full rounded-xl border-outline-variant text-sm">
                        <option>Semua Sekolah (SMP & SMK)</option>
                        <option>Khusus Admin SMK</option>
                        <option>Khusus Guru BK SMP</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold mb-1.5 text-on-surface-variant">ISI NOTIFIKASI PENGUMUMAN</label>
                    <textarea rows="4" class="w-full rounded-xl border-outline-variant text-sm" placeholder="Tuliskan detail instruksi atau maklumat kementerian di sini..."></textarea>
                </div>
                <button class="w-full py-3 bg-primary text-white text-xs font-bold rounded-xl shadow hover:bg-opacity-90 transition flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">send</span> Siarkan Pengumuman Sekarang
                </button>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-outline-variant shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-on-surface uppercase tracking-wide">Log Riwayat Kirim</h3>
                <div class="space-y-3">
                    @foreach($historyBroadcast as $log)
                    <div class="p-3 bg-[#f7f9fb] rounded-xl border border-outline-variant/40 space-y-1">
                        <h4 class="text-xs font-bold text-primary line-clamp-1">{{ $log['subjek'] }}</h4>
                        <p class="text-[10px] text-on-surface-variant font-medium">Target: {{ $log['target'] }}</p>
                        <div class="flex justify-between items-center pt-1 text-[9px] text-on-surface-variant font-semibold">
                            <span>{{ $log['tanggal'] }}</span>
                            <span class="text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded">{{ $log['status'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>