"use client";

import { useState } from "react";
import { useRouter } from "next/navigation";
import Image from "next/image";
import { Eye, EyeOff, Lock, LogIn, ShieldCheck, User } from "lucide-react";

export default function KemendikdasmenLoginPage() {
  const router = useRouter();

  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [remember, setRemember] = useState(false);
  const [showPassword, setShowPassword] = useState(false);
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError("");
    setLoading(true);

    try {
      const res = await fetch("/api/kemendikdasmen/login", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ email, password, remember }),
      });

      const data = await res.json();
      if (!res.ok) throw new Error(data.error || "NIP/Email atau password yang Anda masukkan salah.");

      router.push("/kemendikdasmen/dashboard");
    } catch (err: any) {
      setError(err.message);
    } finally {
      setLoading(false);
    }
  };

  return (
    <main className="w-full min-h-screen grid grid-cols-1 lg:grid-cols-2 bg-white overflow-hidden">
      {/* Left branding panel */}
      <div className="relative hidden lg:flex flex-col justify-between p-12 bg-[#002060] overflow-hidden">
        <div className="relative z-10 w-full">
          <div className="absolute -top-12 -left-12 bg-white px-8 py-5 rounded-br-3xl shadow-md">
            <Image
              src="/images/logo_ditjen_vokasi.png"
              alt="Kemendikdasmen RI"
              width={80}
              height={80}
              className="h-20 w-auto object-contain"
            />
          </div>

          <div className="mt-36">
            <h2 className="text-white font-extrabold text-3xl leading-tight mb-6">
              Pusat Kendali <br /> Sistem Informasi <br /> Bakat Peserta Didik SMK
            </h2>
            <p className="text-slate-300 text-sm max-w-md opacity-90">
              Platform integrasi data nasional untuk pengelolaan minat bakat yang telah dilakukan oleh
              peserta didik dalam mengetahui kemampuan murid berdasarkan metode RIASEC.
            </p>
          </div>
        </div>

        <div className="relative z-10 flex items-center gap-6 mt-auto">
          <div className="flex flex-col opacity-60">
            <span className="text-white/70 text-[11px] font-bold tracking-widest uppercase">
              Administrasi Pusat
            </span>
            <span className="text-white/60 text-xs">
              Kompleks Kemendikdasmen, Jl. Jenderal Sudirman, Senayan, Jakarta, 10270, Indonesia
            </span>
          </div>
        </div>
      </div>

      {/* Right form panel */}
      <div className="flex flex-col justify-center items-center p-8 md:p-16 bg-white min-h-screen">
        <div className="w-full max-w-md">
          <div className="lg:hidden flex flex-col items-center mb-10">
            <Image
              src="/images/logo_ditjen_vokasi.png"
              alt="Logo Kemendikdasmen RI"
              width={80}
              height={80}
              className="h-20 w-auto object-contain mb-4"
            />
            <h1 className="font-extrabold text-xl text-[#002060]">Kemendikdasmen RI</h1>
          </div>

          <header className="mb-10 text-center lg:text-left">
            <h2 className="font-extrabold text-3xl text-[#002060] mb-2">Admin Login</h2>
            <p className="text-slate-500 text-sm">
              Silakan masuk untuk mengakses panel administrasi pusat.
            </p>
          </header>

          <form onSubmit={handleSubmit} className="space-y-6">
            {error && (
              <div className="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm mb-4">
                {error}
              </div>
            )}

            <div className="space-y-2">
              <label className="block text-[11px] font-bold text-slate-500 uppercase tracking-wider" htmlFor="email">
                NIP / Email
              </label>
              <div className="relative group">
                <User className="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-[#002060] transition-colors" />
                <input
                  id="email"
                  name="email"
                  required
                  type="text"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  placeholder="Masukkan NIP atau Email Resmi"
                  className="w-full h-14 pl-12 pr-4 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#002060]/30 focus:border-[#002060] transition-all outline-none text-sm text-slate-800"
                />
              </div>
            </div>

            <div className="space-y-2">
              <div className="flex justify-between items-end">
                <label className="block text-[11px] font-bold text-slate-500 uppercase tracking-wider" htmlFor="password">
                  Password
                </label>
                <a className="text-[#002060] text-[11px] font-bold hover:underline" href="#">
                  Lupa Kata Sandi?
                </a>
              </div>
              <div className="relative group">
                <Lock className="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-[#002060] transition-colors" />
                <input
                  id="password"
                  name="password"
                  required
                  type={showPassword ? "text" : "password"}
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                  placeholder="••••••••"
                  className="w-full h-14 pl-12 pr-12 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#002060]/30 focus:border-[#002060] transition-all outline-none text-sm text-slate-800"
                />
                <button
                  type="button"
                  onClick={() => setShowPassword((v) => !v)}
                  className="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 transition-colors"
                >
                  {showPassword ? <EyeOff className="w-4 h-4" /> : <Eye className="w-4 h-4" />}
                </button>
              </div>
            </div>

            <div className="flex items-center gap-3 py-2">
              <input
                id="remember"
                type="checkbox"
                checked={remember}
                onChange={(e) => setRemember(e.target.checked)}
                className="w-5 h-5 rounded border-slate-300 text-[#002060] focus:ring-[#002060]"
              />
              <label htmlFor="remember" className="text-sm text-slate-500 cursor-pointer">
                Tetap masuk di perangkat ini
              </label>
            </div>

            <button
              type="submit"
              disabled={loading}
              className="w-full h-14 bg-[#004b87] text-white font-bold text-base rounded-lg hover:bg-[#002060] transition-all transform active:scale-[0.98] shadow-md flex items-center justify-center gap-3"
            >
              {loading ? "Memproses..." : "Masuk ke Panel Admin"}
              <LogIn className="w-4 h-4" />
            </button>
          </form>

          <footer className="mt-12 pt-8 border-t border-slate-200 flex items-center justify-center sm:justify-start gap-2 text-slate-500 text-xs">
            <ShieldCheck className="w-4 h-4" />
            <span>Koneksi Terenkripsi</span>
          </footer>
        </div>
      </div>
    </main>
  );
}
