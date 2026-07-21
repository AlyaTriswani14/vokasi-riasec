"use client";

import { useState, useEffect } from "react";
import { Clock, Target, CalendarDays, Server, Save, CheckCircle2 } from "lucide-react";
import KemendikdasmenNav from "../_components/KemendikdasmenNav";

export default function KemendikdasmenSettingsPage() {
  const [durasiTesMenit, setDurasiTesMenit] = useState(5);
  const [targetKuotaNasional, setTargetKuotaNasional] = useState(600000);
  const [tahunAjaran, setTahunAjaran] = useState("2026/2027");
  const [statusSistem, setStatusSistem] = useState("Aktif");

  const [loading, setLoading] = useState(true);
  const [saving, setSaving] = useState(false);
  const [message, setMessage] = useState("");
  const [error, setError] = useState("");

  useEffect(() => {
    fetch("/api/kemendikdasmen/settings")
      .then((res) => res.json())
      .then((data) => {
        if (data.durasi_tes_menit) setDurasiTesMenit(data.durasi_tes_menit);
        if (data.target_kuota_nasional) setTargetKuotaNasional(data.target_kuota_nasional);
        if (data.tahun_ajaran) setTahunAjaran(data.tahun_ajaran);
        if (data.status_sistem) setStatusSistem(data.status_sistem);
      })
      .finally(() => setLoading(false));
  }, []);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setMessage("");
    setError("");
    setSaving(true);

    try {
      const res = await fetch("/api/kemendikdasmen/settings", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          durasi_tes_menit: durasiTesMenit,
          target_kuota_nasional: targetKuotaNasional,
          tahun_ajaran: tahunAjaran,
          status_sistem: statusSistem,
        }),
      });

      const data = await res.json();
      if (!res.ok) throw new Error(data.error || "Gagal menyimpan pengaturan.");
      setMessage("Pengaturan berhasil disimpan! Durasi tes baru langsung berlaku untuk pengerjaan berikutnya.");
    } catch (err: any) {
      setError(err.message);
    } finally {
      setSaving(false);
    }
  };

  if (loading) {
    return (
      <main className="min-h-screen bg-slate-50 flex items-center justify-center p-4">
        <div className="text-center text-slate-500 font-medium">Memuat pengaturan sistem...</div>
      </main>
    );
  }

  return (
    <div className="min-h-screen bg-[#f8fafc]">
      <KemendikdasmenNav active="settings" />
      <div className="max-w-2xl mx-auto px-4 py-8 space-y-6">
        <div>
          <span className="inline-block bg-[#003366] text-white text-[10px] font-bold px-3 py-1.5 rounded-full mb-2">
            ADMIN DIREKTORAT SMK
          </span>
          <h1 className="text-xl font-extrabold text-slate-800">Pengaturan Sistem</h1>
          <p className="text-sm text-slate-500">Konfigurasi umum platform Bakat Minat.</p>
        </div>

        <div className="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 space-y-4">
          {message && (
            <div className="bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs p-3.5 rounded-xl font-medium flex items-center gap-2">
              <CheckCircle2 className="w-4 h-4 text-emerald-600 shrink-0" />
              <span>{message}</span>
            </div>
          )}

          {error && (
            <div className="bg-rose-50 text-rose-600 border border-rose-200 text-xs p-3.5 rounded-xl font-medium">
              {error}
            </div>
          )}

          <form onSubmit={handleSubmit} className="space-y-4 pt-2">
            <div>
              <label className="block text-xs font-bold text-slate-700 mb-1.5">
                <Clock className="w-3.5 h-3.5 text-[#2F6FED] inline-block mr-1" /> Durasi Tes (menit)
              </label>
              <input
                type="number"
                required
                min={1}
                max={180}
                value={durasiTesMenit}
                onChange={(e) => setDurasiTesMenit(parseInt(e.target.value, 10))}
                className="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm"
              />
              <p className="text-[11px] text-slate-400 mt-1">
                Waktu pengerjaan yang diberikan kepada siswa saat tes RIASEC berlangsung.
              </p>
            </div>

            <div>
              <label className="block text-xs font-bold text-slate-700 mb-1.5">
                <Target className="w-3.5 h-3.5 text-[#c2410c] inline-block mr-1" /> Target Kuota Nasional (siswa)
              </label>
              <input
                type="number"
                required
                value={targetKuotaNasional}
                onChange={(e) => setTargetKuotaNasional(parseInt(e.target.value, 10))}
                className="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm"
              />
            </div>

            <div className="grid grid-cols-2 gap-4">
              <div>
                <label className="block text-xs font-bold text-slate-700 mb-1.5">
                  <CalendarDays className="w-3.5 h-3.5 text-[#0f766e] inline-block mr-1" /> Tahun Ajaran
                </label>
                <input
                  type="text"
                  required
                  placeholder="2026/2027"
                  value={tahunAjaran}
                  onChange={(e) => setTahunAjaran(e.target.value)}
                  className="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm"
                />
              </div>

              <div>
                <label className="block text-xs font-bold text-slate-700 mb-1.5">
                  <Server className="w-3.5 h-3.5 text-green-600 inline-block mr-1" /> Status Sistem
                </label>
                <select
                  value={statusSistem}
                  onChange={(e) => setStatusSistem(e.target.value)}
                  className="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm"
                >
                  <option value="Aktif">Aktif</option>
                  <option value="Maintenance">Maintenance</option>
                </select>
              </div>
            </div>

            <button
              type="submit"
              disabled={saving}
              className="w-full bg-[#003366] hover:bg-[#002855] text-white font-bold py-3 rounded-xl shadow-lg shadow-blue-200 flex items-center justify-center gap-2 text-sm transition-all mt-4"
            >
              <Save className="w-4 h-4" /> {saving ? "Memproses..." : "Simpan Pengaturan"}
            </button>
          </form>
        </div>
      </div>
    </div>
  );
}
