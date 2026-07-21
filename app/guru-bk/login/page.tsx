"use client";

import { useState } from "react";
import { useRouter } from "next/navigation";
import Link from "next/link";
import { School, Mail, Lock, LogIn, ArrowLeft } from "lucide-react";

export default function GuruBkLoginPage() {
  const router = useRouter();

  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError("");
    setLoading(true);

    try {
      const res = await fetch("/api/guru-bk/login", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ email, password }),
      });

      const data = await res.json();
      if (!res.ok) throw new Error(data.error || "Login gagal.");

      router.push("/guru-bk/panel");
    } catch (err: any) {
      setError(err.message);
    } finally {
      setLoading(false);
    }
  };

  return (
    <main className="min-h-screen bg-slate-50 flex items-center justify-center p-4">
      <div className="w-full max-w-md bg-white rounded-3xl shadow-xl p-8 border border-slate-100">
        <div className="text-center mb-8">
          <div className="w-14 h-14 rounded-2xl bg-teal-100 text-teal-700 flex items-center justify-center mx-auto mb-3">
            <School className="w-8 h-8" />
          </div>
          <h1 className="text-2xl font-extrabold text-slate-800">Login Admin Guru BK</h1>
          <p className="text-xs text-slate-500 mt-1">
            Portal Pemantauan & Analisis RIASEC Siswa Binaan Sekolah
          </p>
        </div>

        {error && (
          <div className="bg-rose-50 text-rose-600 border border-rose-200 text-xs p-3 rounded-xl mb-4 font-medium">
            {error}
          </div>
        )}

        <form onSubmit={handleSubmit} className="space-y-4">
          <div>
            <label className="block text-xs font-bold text-slate-700 mb-1">Email Guru BK</label>
            <div className="relative">
              <Mail className="w-4 h-4 absolute left-3 top-3 text-slate-400" />
              <input
                type="email"
                required
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                placeholder="gurubk@sekolah.sch.id"
                className="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
              />
            </div>
          </div>

          <div>
            <label className="block text-xs font-bold text-slate-700 mb-1">Password</label>
            <div className="relative">
              <Lock className="w-4 h-4 absolute left-3 top-3 text-slate-400" />
              <input
                type="password"
                required
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                placeholder="••••••••"
                className="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
              />
            </div>
          </div>

          <button
            type="submit"
            disabled={loading}
            className="w-full bg-teal-700 hover:bg-teal-800 text-white font-bold py-3 rounded-xl shadow-lg shadow-teal-200 flex items-center justify-center gap-2 text-sm transition-all"
          >
            {loading ? "Memproses..." : "Masuk ke Panel Guru BK"} <LogIn className="w-4 h-4" />
          </button>
        </form>

        <div className="mt-6 text-center text-xs text-slate-500 space-y-2">
          <div>
            Belum mendaftarkan sekolah?{" "}
            <Link href="/guru-bk/daftar" className="text-teal-700 font-bold hover:underline">
              Daftar di sini
            </Link>
          </div>
          <div>
            <Link href="/pilih-admin" className="text-slate-400 hover:text-slate-600 font-medium inline-flex items-center gap-1">
              <ArrowLeft className="w-3 h-3" /> Pilih Peran Lain
            </Link>
          </div>
        </div>
      </div>
    </main>
  );
}
