"use client";

import { useState, useEffect } from "react";
import { FileQuestion, Plus, Trash2, Edit2 } from "lucide-react";
import KemendikdasmenNav from "../_components/KemendikdasmenNav";

const ASPEK_WARNA: Record<string, string> = {
  R: "bg-red-50 text-[#EF4444]",
  I: "bg-blue-50 text-[#3B82F6]",
  A: "bg-orange-50 text-[#F97316]",
  S: "bg-cyan-50 text-[#06B6D4]",
  E: "bg-amber-50 text-[#F59E0B]",
  C: "bg-green-50 text-[#10B981]",
};

interface Soal {
  id: number;
  pernyataan: string;
  aspek: string;
  urutan: number;
  status: string;
}

export default function KemendikdasmenQuestionsPage() {
  const [soalList, setSoalList] = useState<Soal[]>([]);
  const [loading, setLoading] = useState(true);

  // Form Tambah / Edit
  const [showModal, setShowModal] = useState(false);
  const [editId, setEditId] = useState<number | null>(null);
  const [pernyataan, setPernyataan] = useState("");
  const [aspek, setAspek] = useState("R");
  const [status, setStatus] = useState("aktif");

  const loadQuestions = () => {
    setLoading(true);
    fetch("/api/kemendikdasmen/questions")
      .then((res) => res.json())
      .then((data) => {
        if (data.soalList) setSoalList(data.soalList);
      })
      .finally(() => setLoading(false));
  };

  useEffect(() => {
    loadQuestions();
  }, []);

  const handleOpenAdd = () => {
    setEditId(null);
    setPernyataan("");
    setAspek("R");
    setStatus("aktif");
    setShowModal(true);
  };

  const handleOpenEdit = (s: Soal) => {
    setEditId(s.id);
    setPernyataan(s.pernyataan);
    setAspek(s.aspek);
    setStatus(s.status);
    setShowModal(true);
  };

  const handleSave = async (e: React.FormEvent) => {
    e.preventDefault();

    if (editId) {
      // PUT Update
      await fetch(`/api/kemendikdasmen/questions/${editId}`, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ pernyataan, aspek, status }),
      });
    } else {
      // POST Create
      await fetch("/api/kemendikdasmen/questions", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ pernyataan, aspek }),
      });
    }

    setShowModal(false);
    loadQuestions();
  };

  const handleDelete = async (id: number) => {
    if (!confirm("Hapus soal ini dari Bank Soal RIASEC?")) return;
    await fetch(`/api/kemendikdasmen/questions/${id}`, { method: "DELETE" });
    loadQuestions();
  };

  return (
    <div className="min-h-screen bg-[#f8fafc]">
      <KemendikdasmenNav active="questions" />
      <div className="max-w-6xl mx-auto px-4 py-8 space-y-6">
        <div className="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
          <div>
            <span className="inline-block bg-[#003366] text-white text-[10px] font-bold px-3 py-1.5 rounded-full mb-2">
              ADMIN DIREKTORAT SMK
            </span>
            <h1 className="text-xl font-extrabold text-slate-800">Bank Soal RIASEC</h1>
            <p className="text-sm text-slate-500">Daftar pernyataan/pertanyaan yang digunakan dalam tes RIASEC.</p>
          </div>

          <button
            onClick={handleOpenAdd}
            className="inline-flex items-center gap-2 bg-[#003366] hover:bg-[#002855] text-white font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm transition-all shrink-0"
          >
            <Plus className="w-4 h-4" /> Tambah Soal
          </button>
        </div>

        {/* Modal Add/Edit */}
        {showModal && (
          <div className="fixed inset-0 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 z-50">
            <div className="bg-white rounded-3xl p-6 w-full max-w-md shadow-2xl space-y-4">
              <h3 className="font-extrabold text-slate-800 text-base">
                {editId ? "Edit Pertanyaan RIASEC" : "Tambah Pertanyaan RIASEC"}
              </h3>

              <form onSubmit={handleSave} className="space-y-3">
                <div>
                  <label className="block text-xs font-bold text-slate-700 mb-1">Pernyataan Soal</label>
                  <textarea
                    required
                    rows={3}
                    value={pernyataan}
                    onChange={(e) => setPernyataan(e.target.value)}
                    placeholder="Masukkan pernyataan soal..."
                    className="w-full p-3 bg-slate-50 border rounded-xl text-xs"
                  ></textarea>
                </div>

                <div className="grid grid-cols-2 gap-3">
                  <div>
                    <label className="block text-xs font-bold text-slate-700 mb-1">Aspek RIASEC</label>
                    <select
                      value={aspek}
                      onChange={(e) => setAspek(e.target.value)}
                      className="w-full px-3 py-2 bg-slate-50 border rounded-xl text-xs"
                    >
                      <option value="R">R - Realistic</option>
                      <option value="I">I - Investigative</option>
                      <option value="A">A - Artistic</option>
                      <option value="S">S - Social</option>
                      <option value="E">E - Enterprising</option>
                      <option value="C">C - Conventional</option>
                    </select>
                  </div>

                  <div>
                    <label className="block text-xs font-bold text-slate-700 mb-1">Status</label>
                    <select
                      value={status}
                      onChange={(e) => setStatus(e.target.value)}
                      className="w-full px-3 py-2 bg-slate-50 border rounded-xl text-xs"
                    >
                      <option value="aktif">Aktif</option>
                      <option value="nonaktif">Nonaktif</option>
                    </select>
                  </div>
                </div>

                <div className="flex items-center justify-end gap-2 pt-2">
                  <button
                    type="button"
                    onClick={() => setShowModal(false)}
                    className="px-4 py-2 text-xs font-bold text-slate-500 hover:text-slate-700"
                  >
                    Batal
                  </button>
                  <button type="submit" className="px-4 py-2 bg-[#003366] hover:bg-[#002855] text-white text-xs font-bold rounded-xl shadow-md">
                    Simpan Pertanyaan
                  </button>
                </div>
              </form>
            </div>
          </div>
        )}

        {/* Table List */}
        <div className="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 space-y-4">
          <div className="flex items-center justify-between">
            <h2 className="text-base font-extrabold text-slate-800 flex items-center gap-2">
              <FileQuestion className="w-5 h-5 text-[#003366]" /> Bank Soal Asesmen RIASEC ({soalList.length} Soal)
            </h2>
          </div>

          <div className="overflow-x-auto">
            <table className="w-full text-left text-xs text-slate-600">
              <thead className="bg-slate-50 text-slate-700 font-extrabold uppercase text-[10px]">
                <tr>
                  <th className="p-3 w-12">No</th>
                  <th className="p-3">Pernyataan Soal</th>
                  <th className="p-3 w-28">Aspek</th>
                  <th className="p-3 w-24">Status</th>
                  <th className="p-3 w-24">Aksi</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-100">
                {soalList.length === 0 ? (
                  <tr>
                    <td colSpan={5} className="p-6 text-center text-slate-400">
                      Belum ada soal tersimpan.
                    </td>
                  </tr>
                ) : (
                  soalList.map((s, idx) => (
                    <tr key={s.id} className="hover:bg-slate-50">
                      <td className="p-3 font-bold text-slate-400">{idx + 1}</td>
                      <td className="p-3 font-medium text-slate-800">{s.pernyataan}</td>
                      <td className="p-3">
                        <span className={`${ASPEK_WARNA[s.aspek] || "bg-slate-50 text-slate-500"} text-[10px] font-bold px-2.5 py-1 rounded-full`}>
                          {s.aspek}
                        </span>
                      </td>
                      <td className="p-3">
                        <span
                          className={`px-2 py-0.5 rounded-full text-[10px] font-bold ${
                            s.status === "aktif"
                              ? "bg-emerald-100 text-emerald-800"
                              : "bg-slate-100 text-slate-600"
                          }`}
                        >
                          {s.status.toUpperCase()}
                        </span>
                      </td>
                      <td className="p-3 flex items-center gap-2">
                        <button
                          onClick={() => handleOpenEdit(s)}
                          className="p-1.5 bg-blue-50 text-[#003366] rounded-lg hover:bg-blue-100"
                          title="Edit soal ini"
                        >
                          <Edit2 className="w-3.5 h-3.5" />
                        </button>
                        <button
                          onClick={() => handleDelete(s.id)}
                          className="p-1.5 bg-red-50 text-red-500 rounded-lg hover:bg-red-100"
                          title="Hapus soal ini"
                        >
                          <Trash2 className="w-3.5 h-3.5" />
                        </button>
                      </td>
                    </tr>
                  ))
                )}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  );
}
