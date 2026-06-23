<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Jalanmu - Login Portal RIASEC</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#eef6fa] min-h-screen flex items-center justify-center antialiased m-0 p-0" x-data="{ selectedRole: 'siswa_smp' }">

    <div class="flex w-full min-h-screen bg-white">
        
        <div class="hidden lg:flex lg:w-[40%] bg-cover bg-center relative p-12 flex-col justify-between shrink-0" 
             style="background-image: linear-gradient(rgba(0, 32, 96, 0.85), rgba(10, 17, 40, 0.9)), url('https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=1200&q=80');">
            
            <div class="self-start pt-2">
                <div class="bg-white/95 backdrop-blur-md p-3.5 rounded-2xl shadow-md border border-white/20 inline-block">
                    <img src="{{ asset('images/logo-vokasi.png') }}" alt="Logo Ditjen Vokasi Kemendikdasmen" class="h-16 w-auto object-contain">
                </div>
            </div>

            <div class="pr-6 my-auto pt-6">
                <span class="text-[10px] font-bold uppercase tracking-widest text-[#76f1da] bg-[#76f1da]/10 px-3 py-1.5 rounded-full border border-[#76f1da]/20">
                    Asesmen Holland RIASEC
                </span>
                <h2 class="text-3xl font-black text-white mt-5 leading-tight tracking-tight">Pilih Jalanmu, Tentukan Masa Depan Pendidikanmu.</h2>
                <p class="text-slate-300 text-sm mt-3 leading-relaxed font-medium">Platform Interaktif Pemetaan Minat, Bakat, dan Perencanaan Karier bagi Siswa Vokasi di Indonesia.</p>
            </div>

            <div class="text-xs text-slate-400 font-medium tracking-wide pt-4">
                &copy; 2026 Kerja Praktik Institut Teknologi Del.
            </div>
        </div>

        <div class="w-full lg:w-[60%] flex items-center justify-center p-8 sm:p-12 xl:p-16 bg-[#eef6fa]">
            
            <div class="w-full max-w-2xl bg-white p-10 rounded-[36px] shadow-xl border border-slate-100/80">
                
                <div class="mb-8 text-center">
                    <h2 class="text-3xl font-black text-[#003865] tracking-tight">Pilih Jalanmu</h2>
                    <p class="text-xs text-slate-500 font-semibold mt-1">Tentukan masa depan pendidikanmu dengan langkah yang tepat.</p>
                </div>

                <form action="#" method="POST" class="space-y-6">
                    <input type="hidden" name="role" :value="selectedRole">

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2.5">Pilih Peran</label>
                        <div class="grid grid-cols-4 gap-2.5 bg-slate-50 p-2 rounded-2xl border border-slate-200">
                            
                            <button type="button" @click="selectedRole = 'siswa_smp'"
                                    class="flex flex-col items-center justify-center py-4 px-1 rounded-xl border transition-all duration-200 focus:outline-none cursor-pointer"
                                    :class="selectedRole === 'siswa_smp' ? 'bg-[#76f1da]/30 border-[#4ee4c7] text-[#004b87] font-black shadow-sm scale-[1.01]' : 'bg-white border-slate-200 text-slate-500 hover:bg-slate-50'">
                                <span class="text-2xl mb-1">👦</span>
                                <span class="text-[11px] tracking-tight text-center font-bold whitespace-nowrap">Siswa SMP</span>
                            </button>

                            <button type="button" @click="selectedRole = 'siswa_smk'"
                                    class="flex flex-col items-center justify-center py-4 px-1 rounded-xl border transition-all duration-200 focus:outline-none cursor-pointer"
                                    :class="selectedRole === 'siswa_smk' ? 'bg-[#76f1da]/30 border-[#4ee4c7] text-[#004b87] font-black shadow-sm scale-[1.01]' : 'bg-white border-slate-200 text-slate-500 hover:bg-slate-50'">
                                <span class="text-2xl mb-1">💼</span>
                                <span class="text-[11px] tracking-tight text-center font-bold whitespace-nowrap">Siswa SMK</span>
                            </button>

                            <button type="button" @click="selectedRole = 'guru_smp'"
                                    class="flex flex-col items-center justify-center py-4 px-1 rounded-xl border transition-all duration-200 focus:outline-none cursor-pointer"
                                    :class="selectedRole === 'guru_smp' ? 'bg-[#76f1da]/30 border-[#4ee4c7] text-[#004b87] font-black shadow-sm scale-[1.01]' : 'bg-white border-slate-200 text-slate-500 hover:bg-slate-50'">
                                <span class="text-2xl mb-1">🏫</span>
                                <span class="text-[11px] tracking-tight text-center font-bold whitespace-nowrap">Guru SMP</span>
                            </button>

                            <button type="button" @click="selectedRole = 'guru_smk'"
                                    class="flex flex-col items-center justify-center py-4 px-1 rounded-xl border transition-all duration-200 focus:outline-none cursor-pointer"
                                    :class="selectedRole === 'guru_smk' ? 'bg-[#76f1da]/30 border-[#4ee4c7] text-[#004b87] font-black shadow-sm scale-[1.01]' : 'bg-white border-slate-200 text-slate-500 hover:bg-slate-50'">
                                <span class="text-2xl mb-1">👨‍🏫</span>
                                <span class="text-[11px] tracking-tight text-center font-bold whitespace-nowrap">Guru SMK</span>
                            </button>

                        </div>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                                <span x-text="(selectedRole === 'siswa_smp' || selectedRole === 'siswa_smk') ? 'Email atau NISN' : 'Email atau NIP'"></span>
                            </label>
                            <div class="relative">
                                <input type="text" required :placeholder="(selectedRole === 'siswa_smp' || selectedRole === 'siswa_smk') ? 'Masukkan Email atau NISN' : 'Masukkan Email atau NIP'"
                                       class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-4 focus:ring-blue-500/5 focus:border-[#004b87] transition pr-10 text-slate-700 font-semibold shadow-sm">
                                <span class="absolute right-4 top-3.5 text-slate-400 text-sm">👤</span>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-1.5">
                                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider">Kata Sandi</label>
                                <a href="#" class="text-xs font-bold text-[#004b87] hover:underline tracking-tight">Lupa Sandi?</a>
                            </div>
                            <div class="relative" x-data="{ showPass: false }">
                                <input :type="showPass ? 'text' : 'password'" required placeholder="••••••••"
                                       class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-4 focus:ring-blue-500/5 focus:border-[#004b87] transition pr-10 text-slate-700 font-semibold shadow-sm">
                                <button type="button" @click="showPass = !showPass" class="absolute right-4 top-3.5 text-slate-400 focus:outline-none cursor-pointer text-xs">
                                    <span x-text="showPass ? '🔒' : '👁️'"></span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full bg-[#004b87] hover:bg-[#003865] text-white font-bold py-3.5 rounded-xl text-xs transition flex items-center justify-center space-x-2 shadow-md shadow-blue-900/10 cursor-pointer">
                            <span>Masuk ke Dashboard</span>
                            <span>➔</span>
                        </button>
                    </div>

                    <div class="text-center pt-5 border-t border-slate-100 flex items-center justify-center space-x-2">
                        <span class="text-xs text-slate-400 font-medium">Belum memiliki akun?</span>
                        <a href="{{ route('register') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 hover:underline transition">
                            Daftar Akun Baru
                        </a>
                    </div>
                </form>

            </div>
        </div>

    </div>

</body>
</html>