<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Manajemen Soal - Admin Pusat</title>
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
        
        <a class="bg-secondary-container text-on-secondary-container font-bold rounded-lg flex items-center px-4 py-3 transition text-xs" href="{{ route('kemendikdasmen.questions') }}">
            <span class="material-symbols-outlined mr-3">quiz</span>Manajemen Soal
        </a>
        
        <a class="text-on-surface-variant hover:bg-outline-variant/30 rounded-lg flex items-center px-4 py-3 transition text-xs font-bold" href="{{ route('kemendikdasmen.settings') }}"><span class="material-symbols-outlined mr-3">settings</span>System Settings</a>
        <a class="text-on-surface-variant hover:bg-outline-variant/30 rounded-lg flex items-center px-4 py-3 transition text-xs font-bold" href="{{ route('kemendikdasmen.broadcast') }}"><span class="material-symbols-outlined mr-3">campaign</span>Broadcast Center</a>
    </nav>
    <div class="pt-4 border-t border-outline-variant">
        <form action="{{ route('kemendikdasmen.logout') }}" method="POST">@csrf
            <button type="submit" class="w-full text-red-600 hover:bg-red-50 rounded-lg flex items-center px-4 py-3 transition font-bold text-xs"><span class="material-symbols-outlined mr-3">logout</span>Keluar</button>
        </form>
    </div>
</aside>

<main class="flex-1 pl-64 h-screen overflow-y-auto">
    <div class="p-8 space-y-6 max-w-[1400px] mx-auto">
        <header class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-primary">Manajemen Soal</h1>
                <p class="text-xs text-on-surface-variant uppercase font-bold tracking-wider">Kelola Instrumen Kuesioner & Bank Soal RIASEC Nasional</p>
            </div>
            <button class="px-4 py-2 bg-primary text-white text-xs font-bold rounded-xl flex items-center gap-2 shadow transition hover:bg-opacity-90">
                <span class="material-symbols-outlined text-sm">add_box</span> Tambah Butir Soal
            </button>
        </header>

        <section class="bg-white p-6 rounded-2xl border border-outline-variant shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-outline-variant text-[11px] font-bold text-on-surface-variant bg-surface-container-low uppercase tracking-wider">
                            <th class="p-4 w-16 rounded-l-xl">No</th>
                            <th class="p-4">Butir Pernyataan Soal Instrumen</th>
                            <th class="p-4 text-center">Kode Aspek</th>
                            <th class="p-4 text-center">Tipe Kepribadian</th>
                            <th class="p-4 text-center rounded-r-xl">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs divide-y divide-outline-variant/20">
                        @foreach($soalList as $soal)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4 text-on-surface-variant font-medium">{{ sprintf('%02d', $soal['id']) }}</td>
                            
                            <td class="p-4 font-semibold text-gray-900 text-[13px] max-w-xl leading-relaxed">{{ $soal['pernyataan'] }}</td>
                            
                            <td class="p-4 text-center font-bold text-gray-700 text-sm tracking-wide">
                                {{ $soal['aspek'] }}
                            </td>
                            
                            <td class="p-4 text-center">
                                @php
                                    $badgeStyle = match($soal['aspek']) {
                                        'R' => 'bg-slate-100 text-slate-700',
                                        'I' => 'bg-amber-100 text-amber-800',
                                        'A' => 'bg-purple-100 text-purple-800',
                                        'S' => 'bg-emerald-100 text-emerald-800',
                                        'E' => 'bg-sky-100 text-sky-800',
                                        'C' => 'bg-indigo-100 text-indigo-800',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full font-bold text-[10px] uppercase tracking-wide {{ $badgeStyle }}">
                                    {{ $soal['tipe'] }}
                                </span>
                            </td>
                            
                            <td class="p-4 text-center">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 font-bold text-[10px] tracking-wider uppercase">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    {{ $soal['status'] }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</main>
</body>
</html>