"use client";

import { useState, useEffect } from "react";
import Link from "next/link";
import { ArrowLeft, Radio, Send, Trash2, Bell } from "lucide-react";

interface BroadcastItem {
  id: number;
  subjek: string;
  isi: string;
  targetPenerima: string;
  targetJenjang: string;
  createdAt: string;
}

export default function KemendikdasmenBroadcastPage() {
  const [broadcasts, setBroadcasts] = useState<BroadcastItem[]>([]);
  const [subjek, setSubjek] = useState("");
  const [isi, setIsi] = useState("");
  const [targetPenerima, setTargetPenerima] = useState("semua");
  const [targetJenjang, setTargetJenjang] = useState("semua");
  const [loading, setLoading] = useState(true);
  const [sending, setSending] = useState(false);

  const loadBroadcasts = () => {
    setLoading(true);
    fetch("/api/kemendikdasmen/broadcast")
      .then((res) => res.json())
      .then((data) => {
        if (data.broadcasts) setBroadcasts(data.broadcasts);
      })
      .finally(() => setLoading(false));
  };

  useEffect(() => {
    loadBroadcasts();
  }, []);

  const handleSend = async (e: React.FormEvent) => {
    e.preventDefault();
    setSending(true);

    try {
      const res = await fetch("/api/kemendikdasmen/broadcast", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          subjek,
          isi,
          target_penerima: targetPenerima,
          target_jenjang: targetJenjang,
        }),
      });

      if (!res.ok) throw new Error("Gagal mengirim broadcast.");

      setSubjek("");
      setIsi("");
      loadBroadcasts();
    } catch (err: any) {
      alert(err.message);
    } finally {
      setSending(false);
    }
  };

  const handleDelete = async (id: number) => {
    if (!confirm("Hapus pengumuman broadcast ini?")) return;
    await fetch(`/api/kemendikdasmen/broadcast/${id}`, { method: "DELETE" });
    loadBroadcasts();
  };

  return (
    <div className="min-h-screen bg-slate-50 p-4 md:p-8">
      <div className="max-w-4xl mx-auto space-y-6">
        <Link
          href="/kemendikdasmen/dashboard"
          className="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-slate-800"
        >
          <ArrowLeft className="w-4 h-4" /> Kembali ke Dashboard
        </Link>

        {/* Form Create Broadcast */}
        <div className="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 space-y-4">
          <div className="flex items-center gap-3">
            <div className="w-12 h-12 rounded-2xl bg-rose-100 text-rose-700 flex items-center justify-center">
              <Radio className="w-6 h-6" />
            </div>
            <div>
              <h1 className="text-xl font-extrabold text-slate-800">Broadcast Center (Pengumuman Massal)</h1>
              <p className="text-xs text-slate-500">Kirim pemberitahuan penting ke pengguna platform</p>
            </div>
          </div>

          <form onSubmit={handleSend} className="space-y-3 pt-2">
            <div>
              <label className="block text-xs font-bold text-slate-700 mb-1">Subjek Pengumuman</label>
              <input
                type="text"
                required
                value={subjek}
                onChange={(e) => setSubjek(e.target.value)}
                placeholder="Contoh: Pembukaan Jadwal Asesmen RIASEC Gelombang II"
                className="w-full px-4 py-2.5 bg-slate-50 border rounded-xl text-xs"
              />
            </div>

            <div>
              <label className="block text-xs font-bold text-slate-700 mb-1">Isi Pesan Broadcast</label>
              <textarea
                required
                rows={4}
                value={isi}
                onChange={(e) => setIsi(e.target.value)}
                placeholder="Tuliskan detail informasi pengumuman..."
                className="w-full p-3 bg-slate-50 border rounded-xl text-xs"
              ></textarea>
            </div>

            <div className="grid grid-cols-2 gap-3">
              <div>
                <label className="block text-xs font-bold text-slate-700 mb-1">Target Penerima</label>
                <select
                  value={targetPenerima}
                  onChange={(e) => setTargetPenerima(e.target.value)}
                  className="w-full px-3 py-2 bg-slate-50 border rounded-xl text-xs"
                >
                  <option value="semua">Semua Pengguna (Siswa & Guru)</option>
                  <option value="siswa">Khusus Siswa</option>
                  <option value="guru_bk">Khusus Guru BK</option>
                </select>
              </div>

              <div>
                <label className="block text-xs font-bold text-slate-700 mb-1">Target Jenjang</label>
                <select
                  value={targetJenjang}
                  onChange={(e) => setTargetJenjang(e.target.value)}
                  className="w-full px-3 py-2 bg-slate-50 border rounded-xl text-xs"
                >
                  <option value="semua">Semua Jenjang (SMP & SMK)</option>
                  <option value="smp">SMP / MTs</option>
                  <option value="smk">SMK</option>
                </select>
              </div>
            </div>

            <button
              type="submit"
              disabled={sending}
              className="w-full bg-rose-600 hover:bg-rose-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-rose-200 flex items-center justify-center gap-2 text-xs transition-all mt-2"
            >
              <Send className="w-4 h-4" /> {sending ? "Mengirim Broadcast..." : "Kirim Broadcast Sekarang"}
            </button>
          </form>
        </div>

        {/* History Broadcast List */}
        <div className="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 space-y-4">
          <h2 className="text-base font-extrabold text-slate-800 flex items-center gap-2">
            <Bell className="w-5 h-5 text-rose-600" /> Riwayat Broadcast Pengumuman ({broadcasts.length})
          </h2>

          <div className="space-y-3">
            {broadcasts.length === 0 ? (
              <p className="text-xs text-slate-400 text-center py-6">Belum ada riwayat broadcast.</p>
            ) : (
              broadcasts.map((b) => (
                <div key={b.id} className="bg-slate-50 p-4 rounded-2xl border border-slate-100 relative">
                  <div className="flex items-start justify-between">
                    <div>
                      <h4 className="font-extrabold text-slate-800 text-xs">{b.subjek}</h4>
                      <span className="text-[10px] text-slate-400 font-medium">
                        {new Date(b.createdAt).toLocaleString("id-ID")} • Target: {b.targetPenerima.toUpperCase()} ({b.targetJenjang.toUpperCase()})
                      </span>
                    </div>
                    <button
                      onClick={() => handleDelete(b.id)}
                      className="p-1 text-rose-600 hover:bg-rose-100 rounded-lg"
                    >
                      <Trash2 className="w-4 h-4" />
                    </button>
                  </div>
                  <p className="text-xs text-slate-600 mt-2 leading-relaxed">{b.isi}</p>
                </div>
              ))
            )}
          </div>
        </div>
      </div>
    </div>
  );
}
