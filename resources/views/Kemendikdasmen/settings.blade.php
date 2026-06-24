<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>System Settings - Admin Pusat</title>
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
        <a class="bg-secondary-container text-on-secondary-container font-bold rounded-lg flex items-center px-4 py-3 transition text-xs" href="{{ route('kemendikdasmen.settings') }}"><span class="material-symbols-outlined mr-3">settings</span>System Settings</a>
        <a class="text-on-surface-variant hover:bg-outline-variant/30 rounded-lg flex items-center px-4 py-3 transition text-xs font-bold" href="{{ route('kemendikdasmen.broadcast') }}"><span class="material-symbols-outlined mr-3">campaign</span>Broadcast Center</a>
    </nav>
    <div class="pt-4 border-t border-outline-variant">
        <form action="{{ route('kemendikdasmen.logout') }}" method="POST">@csrf
            <button type="submit" class="w-full text-red-600 hover:bg-red-50 rounded-lg flex items-center px-4 py-3 transition font-bold text-xs"><span class="material-symbols-outlined mr-3">logout</span>Keluar</button>
        </form>
    </div>
</aside>

<main class="flex-1 pl-64 h-screen overflow-y-auto">
    <div class="p-8 space-y-6 max-w-[900px] mx-auto">
        <div>
            <h1 class="text-2xl font-bold text-primary">System Configuration</h1>
            <p class="text-xs text-on-surface-variant uppercase font-bold tracking-wider">Konfigurasi Target Kuota & Konstanta Aplikasi Nasional</p>
        </div>

        <section class="bg-white p-6 rounded-2xl border border-outline-variant shadow-sm space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-on-surface mb-2 uppercase">Target Kuota SMK Nasional</label>
                    <input type="number" class="w-full rounded-xl border-outline-variant text-sm px-4 py-2.5" value="{{ $settings['target_kuota_nasional'] }}">
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface mb-2 uppercase">Tahun Ajaran Aktif</label>
                    <input type="text" class="w-full rounded-xl border-outline-variant text-sm px-4 py-2.5" value="{{ $settings['tahun_ajaran'] }}">
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface mb-2 uppercase">Alokasi Waktu Kuesioner (Menit)</label>
                    <input type="number" class="w-full rounded-xl border-outline-variant text-sm px-4 py-2.5" value="{{ $settings['durasi_tes_menit'] }}">
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface mb-2 uppercase">Status Sistem Operasional</label>
                    <select class="w-full rounded-xl border-outline-variant text-sm px-4 py-2.5">
                        <option selected>Normal / Active</option>
                        <option>Maintenance Mode</option>
                    </select>
                </div>
            </div>
            
            <div class="pt-4 border-t border-outline-variant flex justify-end">
                <button class="px-6 py-2.5 bg-primary text-white text-xs font-bold rounded-xl shadow hover:bg-opacity-90 transition">
                    Simpan Perubahan Parameter
                </button>
            </div>
        </section>
    </div>
</main>
</body>
</html>