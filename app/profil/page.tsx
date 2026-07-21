"use client";

import { useState, useEffect } from "react";
import { useRouter } from "next/navigation";
import BottomNav from "@/components/BottomNav";
import { User, LogOut, MapPin, School, Hash, BookOpen, Save } from "lucide-react";

export default function ProfilPage() {
  const router = useRouter();

  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [nisn, setNisn] = useState("");
  const [asalSekolah, setAsalSekolah] = useState("");
  const [kelas, setKelas] = useState("9");
  const [provinsi, setProvinsi] = useState("");
  const [kabupatenKota, setKabupatenKota] = useState("");
  const [kecamatan, setKecamatan] = useState("");
  const [kelurahan, setKelurahan] = useState("");

  const [loading, setLoading] = useState(true);
  const [updating, setUpdating] = useState(false);
  const [message, setMessage] = useState("");
  const [error, setError] = useState("");

  useEffect(() => {
    fetch("/api/auth/session")
      .then((res) => res.json())
      .then((data) => {
        if (!data.authenticated) {
          router.push("/login");
        } else if (data.user) {
          setName(data.user.name || "");
          setEmail(data.user.email || "");
          setNisn(data.user.nisn || "");
          setAsalSekolah(data.user.asal_sekolah || "");
          setKelas(data.user.kelas || "9");
          setProvinsi(data.user.provinsi || "");
          setKabupatenKota(data.user.kabupaten_kota || "");
          setKecamatan(data.user.kecamatan || "");
          setKelurahan(data.user.kelurahan || "");
        }
      })
      .finally(() => setLoading(false));
  }, [router]);

  const handleLogout = async () => {
    await fetch("/api/auth/logout", { method: "POST" });
    router.push("/login");
  };

  const handleUpdate = async (e: React.FormEvent) => {
    e.preventDefault();
    setMessage("");
    setError("");
    setUpdating(true);

    try {
      const res = await fetch("/api/auth/lengkapi-profil", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          name,
          nisn,
          asal_sekolah: asalSekolah,
          kelas,
          provinsi,
          kabupaten_kota: kabupatenKota,
          kecamatan,
          kelurahan,
        }),
      });

      const data = await res.json();
      if (!res.ok) throw new Error(data.error || "Gagal mengupdate profil.");
      setMessage("Profil berhasil diperbarui!");
    } catch (err: any) {
      setError(err.message);
    } finally {
      setUpdating(false);
    }
  };

  if (loading) {
    return (
      <main className="min-h-screen bg-slate-50 flex items-center justify-center p-4">
        <div className="text-center text-slate-500 font-medium">Memuat data profil...</div>
      </main>
    );
  }

  return (
    <div className="min-h-screen bg-slate-50 pb-24 max-w-md mx-auto relative shadow-2xl">
      <div className="bg-gradient-to-br from-purple-700 to-indigo-700 p-6 pt-10 text-white rounded-b-3xl">
        <div className="flex items-center gap-4">
          <div className="w-14 h-14 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center font-bold text-2xl border border-white/30">
            👤
          </div>
          <div>
            <h1 className="text-xl font-extrabold">{name}</h1>
            <p className="text-xs text-purple-200">{email}</p>
          </div>
        </div>
      </div>

      <div className="p-4 space-y-4">
        {message && (
          <div className="bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs p-3 rounded-xl font-medium">
            {message}
          </div>
        )}

        {error && (
          <div className="bg-rose-50 text-rose-600 border border-rose-200 text-xs p-3 rounded-xl font-medium">
            {error}
          </div>
        )}

        <form onSubmit={handleUpdate} className="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-3">
          <h3 className="font-extrabold text-slate-800 text-sm mb-1">Edit Data Diri</h3>

          <div>
            <label className="block text-[11px] font-bold text-slate-600 mb-1">Nama Lengkap</label>
            <input
              type="text"
              required
              value={name}
              onChange={(e) => setName(e.target.value)}
              className="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs"
            />
          </div>

          <div>
            <label className="block text-[11px] font-bold text-slate-600 mb-1">NISN</label>
            <input
              type="text"
              required
              maxLength={10}
              value={nisn}
              onChange={(e) => setNisn(e.target.value)}
              className="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs"
            />
          </div>

          <div>
            <label className="block text-[11px] font-bold text-slate-600 mb-1">Asal Sekolah</label>
            <input
              type="text"
              required
              value={asalSekolah}
              onChange={(e) => setAsalSekolah(e.target.value)}
              className="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs"
            />
          </div>

          <div className="border-t border-slate-100 pt-3">
            <h4 className="text-[11px] font-extrabold text-purple-600 mb-2">Domisili Tempat Tinggal</h4>
            <div className="grid grid-cols-2 gap-2 text-xs">
              <input type="text" readOnly value={provinsi} className="p-2 bg-slate-100 rounded-lg text-[11px] text-slate-600" />
              <input type="text" readOnly value={kabupatenKota} className="p-2 bg-slate-100 rounded-lg text-[11px] text-slate-600" />
              <input type="text" readOnly value={kecamatan} className="p-2 bg-slate-100 rounded-lg text-[11px] text-slate-600" />
              <input type="text" readOnly value={kelurahan} className="p-2 bg-slate-100 rounded-lg text-[11px] text-slate-600" />
            </div>
          </div>

          <button
            type="submit"
            disabled={updating}
            className="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 rounded-xl text-xs shadow-md flex items-center justify-center gap-1.5 transition-all mt-2"
          >
            <Save className="w-3.5 h-3.5" /> {updating ? "Memproses..." : "Simpan Perubahan"}
          </button>
        </form>

        <button
          onClick={handleLogout}
          className="w-full bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 font-bold py-3 rounded-2xl text-xs flex items-center justify-center gap-2 transition-all"
        >
          <LogOut className="w-4 h-4" /> Keluar dari Akun (Logout)
        </button>
      </div>

      <BottomNav />
    </div>
  );
}
