"use client";

import { useState } from "react";
import { useRouter } from "next/navigation";
import Link from "next/link";
import { School, Mail, Lock, User, Hash, ArrowLeft } from "lucide-react";

export default function GuruBkDaftarPage() {
  const router = useRouter();

  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [passwordConfirmation, setPasswordConfirmation] = useState("");
  const [namaSekolah, setNamaSekolah] = useState("");
  const [npsn, setNpsn] = useState("");
  const [jenjang, setJenjang] = useState("smk");

  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError("");

    if (password.length < 8) {
      setError("Password minimal 8 karakter.");
      return;
    }

    if (password !== passwordConfirmation) {
      setError("Konfirmasi password tidak cocok.");
      return;
    }

    setLoading(true);

    try {
      const res = await fetch("/api/guru-bk/register", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          name,
          email,
          password,
          nama_sekolah: namaSekolah,
          npsn,
          jenjang,
        }),
      });

      const data = await res.json();
      if (!res.ok) throw new Error(data.error || "Pendaftaran gagal.");

      router.push("/guru-bk/panel");
    } catch (err: any) {
      setError(err.message);
    } finally {
      setLoading(false);
    }
  };

  return (
    <main className="min-h-screen bg-slate-50 flex items-center justify-center p-4 py-8">
      <div className="w-full max-w-md bg-white rounded-3xl shadow-xl p-8 border border-slate-100">
        <div className="text-center mb-6">
          <div className="w-12 h-12 rounded-2xl bg-teal-100 text-teal-700 flex items-center justify-center mx-auto mb-3">
            <School className="w-7 h-7" />
          </div>
          <h1 className="text-xl font-extrabold text-slate-800">Daftar Akun Guru BK</h1>
          <p className="text-xs text-slate-500 mt-1">Registrasi Sekolah & Guru Pembimbing BK</p>
        </div>

        {error && (
          <div className="bg-rose-50 text-rose-600 border border-rose-200 text-xs p-3 rounded-xl mb-4 font-medium">
            {error}
          </div>
        )}

        <form onSubmit={handleSubmit} className="space-y-3">
          <div>
            <label className="block text-xs font-bold text-slate-700 mb-1">Nama Guru BK</label>
            <input
              type="text"
              required
              value={name}
              onChange={(e) => setName(e.target.value)}
              placeholder="Contoh: Budi Santoso, S.Pd"
              className="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm"
            />
          </div>

          <div>
            <label className="block text-xs font-bold text-slate-700 mb-1">Email Resmi Guru</label>
            <input
              type="email"
              required
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              placeholder="gurubk@sekolah.sch.id"
              className="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm"
            />
          </div>

          <div className="grid grid-cols-2 gap-3">
            <div>
              <label className="block text-xs font-bold text-slate-700 mb-1">Password</label>
              <input
                type="password"
                required
                minLength={8}
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                placeholder="Minimal 8 karakter"
                className="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs"
              />
            </div>
            <div>
              <label className="block text-xs font-bold text-slate-700 mb-1">Ulangi Password</label>
              <input
                type="password"
                required
                minLength={8}
                value={passwordConfirmation}
                onChange={(e) => setPasswordConfirmation(e.target.value)}
                placeholder="Ulangi password"
                className="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs"
              />
            </div>
          </div>

          <div className="grid grid-cols-2 gap-3">
            <div>
              <label className="block text-xs font-bold text-slate-700 mb-1">Nama Sekolah</label>
              <input
                type="text"
                required
                value={namaSekolah}
                onChange={(e) => setNamaSekolah(e.target.value)}
                placeholder="SMKN 1 Jakarta"
                className="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs"
              />
            </div>

            <div>
              <label className="block text-xs font-bold text-slate-700 mb-1">NPSN</label>
              <input
                type="text"
                required
                value={npsn}
                onChange={(e) => setNpsn(e.target.value)}
                placeholder="20100001"
                className="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs"
              />
              <p className="text-[10px] text-slate-400 mt-1">Satu sekolah hanya bisa punya satu akun.</p>
            </div>
          </div>

          <div>
            <label className="block text-xs font-bold text-slate-700 mb-1">Jenjang Sekolah</label>
            <select
              value={jenjang}
              onChange={(e) => setJenjang(e.target.value)}
              className="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm"
            >
              <option value="smp">SMP / MTs</option>
              <option value="smk">SMK (Sekolah Menengah Kejuruan)</option>
            </select>
          </div>

          <button
            type="submit"
            disabled={loading}
            className="w-full bg-teal-700 hover:bg-teal-800 text-white font-bold py-3 rounded-xl shadow-lg shadow-teal-200 text-sm transition-all mt-4"
          >
            {loading ? "Memproses..." : "Daftar Akun Guru BK"}
          </button>
        </form>

        <div className="mt-6 text-center text-xs text-slate-500 space-y-2">
          <div>
            Sudah punya akun?{" "}
            <Link href="/guru-bk/login" className="text-teal-700 font-bold hover:underline">
              Masuk di sini
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
