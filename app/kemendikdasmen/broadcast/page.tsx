"use client";

import { useState, useEffect } from "react";
import { Send, Trash2, Bell } from "lucide-react";
import KemendikdasmenNav from "../_components/KemendikdasmenNav";

const LABEL_PENERIMA: Record<string, string> = { siswa: "Siswa", guru_bk: "Guru BK", semua: "Semua" };

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
    <div className="min-h-screen bg-[#f8fafc]">
      <KemendikdasmenNav active="broadcast" />
      <div className="max-w-4xl mx-auto px-4 py-8 space-y-6">
        <div>
          <span className="inline-block bg-[#003366] text-white text-[10px] font-bold px-3 py-1.5 rounded-full mb-2">
            ADMIN DIREKTORAT SMK
          </span>
          <h1 className="text-xl font-extrabold text-slate-800">Broadcast &amp; Announcement Center</h1>
          <p className="text-sm text-slate-500">
            Kirim pengumuman ke siswa dan/atau Guru BK, bisa dipisah per jenjang.
          </p>
        </div>

        {/* Form Create Broadcast */}
        <div className="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 space-y-4">
          <h2 className="font-bold text-slate-800 text-sm">Buat Broadcast Baru</h2>

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
              className="w-full bg-[#003366] hover:bg-[#002855] text-white font-bold py-3 rounded-xl shadow-lg shadow-blue-200 flex items-center justify-center gap-2 text-xs transition-all mt-2"
            >
              <Send className="w-4 h-4" /> {sending ? "Mengirim Broadcast..." : "Kirim Broadcast"}
            </button>
          </form>
        </div>

        {/* History Broadcast List */}
        <div className="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 space-y-4">
          <h2 className="text-base font-extrabold text-slate-800 flex items-center gap-2">
            <Bell className="w-5 h-5 text-[#003366]" /> Riwayat Broadcast ({broadcasts.length})
          </h2>

          <div className="space-y-3">
            {broadcasts.length === 0 ? (
              <p className="text-xs text-slate-400 text-center py-6">Belum ada riwayat broadcast.</p>
            ) : (
              broadcasts.map((b) => (
                <div key={b.id} className="bg-slate-50 p-4 rounded-2xl border border-slate-100 relative">
                  <div className="flex items-start justify-between gap-3">
                    <div>
                      <h4 className="font-extrabold text-slate-800 text-xs">{b.subjek}</h4>
                      <div className="flex items-center gap-2 mt-1.5 flex-wrap">
                        <span className="bg-blue-50 text-[#003366] text-[10px] font-bold px-2.5 py-1 rounded-full">
                          {LABEL_PENERIMA[b.targetPenerima] || b.targetPenerima}
                        </span>
                        {b.targetJenjang === "smp" ? (
                          <span className="bg-orange-50 text-[#c2410c] text-[10px] font-bold px-2.5 py-1 rounded-full">SMP</span>
                        ) : b.targetJenjang === "smk" ? (
                          <span className="bg-blue-50 text-[#2F6FED] text-[10px] font-bold px-2.5 py-1 rounded-full">SMK</span>
                        ) : (
                          <span className="bg-slate-100 text-slate-500 text-[10px] font-bold px-2.5 py-1 rounded-full">Semua</span>
                        )}
                        <span className="text-[10px] text-slate-400 font-medium">
                          {new Date(b.createdAt).toLocaleDateString("id-ID")}
                        </span>
                      </div>
                    </div>
                    <button
                      onClick={() => handleDelete(b.id)}
                      className="p-1 text-red-500 hover:bg-red-100 rounded-lg shrink-0"
                      title="Hapus broadcast ini"
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
