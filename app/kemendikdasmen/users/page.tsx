"use client";

import { useState, useEffect } from "react";
import Link from "next/link";
import { ArrowLeft, School, Plus, Search, Trash2, Users } from "lucide-react";

interface GuruUser {
  id: number;
  name: string;
  email: string;
  nama_sekolah: string;
  npsn: string;
  jenjang: string;
  jumlah_siswa: number;
}

export default function KemendikdasmenUsersPage() {
  const [users, setUsers] = useState<GuruUser[]>([]);
  const [search, setSearch] = useState("");
  const [jenjang, setJenjang] = useState("");
  const [loading, setLoading] = useState(true);

  // Form tambah sekolah
  const [showAddModal, setShowAddModal] = useState(false);
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [namaSekolah, setNamaSekolah] = useState("");
  const [npsn, setNpsn] = useState("");
  const [formJenjang, setFormJenjang] = useState("smk");
  const [error, setError] = useState("");

  const loadUsers = () => {
    setLoading(true);
    const params = new URLSearchParams();
    if (search) params.set("search", search);
    if (jenjang) params.set("jenjang", jenjang);

    fetch(`/api/kemendikdasmen/users?${params.toString()}`)
      .then((res) => res.json())
      .then((data) => {
        if (data.users) setUsers(data.users);
      })
      .finally(() => setLoading(false));
  };

  useEffect(() => {
    loadUsers();
  }, [jenjang]);

  const handleSearchSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    loadUsers();
  };

  const handleCreateSekolah = async (e: React.FormEvent) => {
    e.preventDefault();
    setError("");

    try {
      const res = await fetch("/api/kemendikdasmen/users", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          name,
          email,
          password,
          nama_sekolah: namaSekolah,
          npsn,
          jenjang: formJenjang,
        }),
      });

      const data = await res.json();
      if (!res.ok) throw new Error(data.error || "Gagal menambah sekolah.");

      setShowAddModal(false);
      setName("");
      setEmail("");
      setPassword("");
      setNamaSekolah("");
      setNpsn("");
      loadUsers();
    } catch (err: any) {
      setError(err.message);
    }
  };

  const handleDelete = async (id: number) => {
    if (!confirm("Apakah kamu yakin ingin menghapus akun sekolah ini?")) return;

    await fetch(`/api/kemendikdasmen/users/${id}`, { method: "DELETE" });
    loadUsers();
  };

  return (
    <div className="min-h-screen bg-slate-50 p-4 md:p-8">
      <div className="max-w-6xl mx-auto space-y-6">
        <div className="flex items-center justify-between">
          <Link
            href="/kemendikdasmen/dashboard"
            className="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-slate-800"
          >
            <ArrowLeft className="w-4 h-4" /> Kembali ke Dashboard
          </Link>

          <button
            onClick={() => setShowAddModal(true)}
            className="inline-flex items-center gap-2 bg-[#003366] hover:bg-[#0d3f70] text-white font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm transition-all"
          >
            <Plus className="w-4 h-4" /> Tambah Sekolah / Guru BK
          </button>
        </div>

        {/* Modal Tambah Sekolah */}
        {showAddModal && (
          <div className="fixed inset-0 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 z-50">
            <div className="bg-white rounded-3xl p-6 w-full max-w-md shadow-2xl space-y-4">
              <h3 className="font-extrabold text-slate-800 text-base">Tambah Akun Sekolah (Guru BK)</h3>
              {error && <div className="text-xs text-rose-600 bg-rose-50 p-3 rounded-xl border border-rose-200">{error}</div>}

              <form onSubmit={handleCreateSekolah} className="space-y-3">
                <input
                  type="text"
                  required
                  placeholder="Nama Guru BK / Penanggung Jawab"
                  value={name}
                  onChange={(e) => setName(e.target.value)}
                  className="w-full px-3.5 py-2 bg-slate-50 border rounded-xl text-xs"
                />
                <input
                  type="email"
                  required
                  placeholder="Email Resmi Sekolah"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  className="w-full px-3.5 py-2 bg-slate-50 border rounded-xl text-xs"
                />
                <input
                  type="password"
                  required
                  placeholder="Password Account"
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                  className="w-full px-3.5 py-2 bg-slate-50 border rounded-xl text-xs"
                />
                <input
                  type="text"
                  required
                  placeholder="Nama Sekolah"
                  value={namaSekolah}
                  onChange={(e) => setNamaSekolah(e.target.value)}
                  className="w-full px-3.5 py-2 bg-slate-50 border rounded-xl text-xs"
                />
                <input
                  type="text"
                  required
                  placeholder="NPSN Sekolah"
                  value={npsn}
                  onChange={(e) => setNpsn(e.target.value)}
                  className="w-full px-3.5 py-2 bg-slate-50 border rounded-xl text-xs"
                />
                <select
                  value={formJenjang}
                  onChange={(e) => setFormJenjang(e.target.value)}
                  className="w-full px-3.5 py-2 bg-slate-50 border rounded-xl text-xs"
                >
                  <option value="smp">SMP / MTs</option>
                  <option value="smk">SMK</option>
                </select>

                <div className="flex items-center justify-end gap-2 pt-2">
                  <button
                    type="button"
                    onClick={() => setShowAddModal(false)}
                    className="px-4 py-2 text-xs font-bold text-slate-500 hover:text-slate-700"
                  >
                    Batal
                  </button>
                  <button type="submit" className="px-4 py-2 bg-[#003366] text-white text-xs font-bold rounded-xl shadow-md">
                    Simpan Sekolah
                  </button>
                </div>
              </form>
            </div>
          </div>
        )}

        {/* Table List */}
        <div className="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 space-y-4">
          <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h2 className="text-base font-extrabold text-slate-800 flex items-center gap-2">
              <School className="w-5 h-5 text-teal-600" /> User Management Sekolah & Guru BK
            </h2>

            <form onSubmit={handleSearchSubmit} className="flex items-center gap-2">
              <input
                type="text"
                value={search}
                onChange={(e) => setSearch(e.target.value)}
                placeholder="Cari nama/npsn/sekolah..."
                className="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs"
              />
              <select
                value={jenjang}
                onChange={(e) => setJenjang(e.target.value)}
                className="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs"
              >
                <option value="">Semua Jenjang</option>
                <option value="smp">SMP</option>
                <option value="smk">SMK</option>
              </select>
              <button type="submit" className="bg-[#003366] text-white px-3 py-1.5 rounded-xl text-xs font-bold">
                Cari
              </button>
            </form>
          </div>

          <div className="overflow-x-auto">
            <table className="w-full text-left text-xs text-slate-600">
              <thead className="bg-slate-50 text-slate-700 font-extrabold uppercase text-[10px]">
                <tr>
                  <th className="p-3">Nama Sekolah</th>
                  <th className="p-3">NPSN</th>
                  <th className="p-3">Guru BK / Pengelola</th>
                  <th className="p-3">Jenjang</th>
                  <th className="p-3">Jumlah Siswa</th>
                  <th className="p-3">Aksi</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-100">
                {users.length === 0 ? (
                  <tr>
                    <td colSpan={6} className="p-6 text-center text-slate-400">
                      Belum ada data sekolah.
                    </td>
                  </tr>
                ) : (
                  users.map((u) => (
                    <tr key={u.id} className="hover:bg-slate-50">
                      <td className="p-3 font-bold text-slate-800">{u.nama_sekolah}</td>
                      <td className="p-3 font-mono">{u.npsn}</td>
                      <td className="p-3">
                        <span className="font-semibold block text-slate-700">{u.name}</span>
                        <span className="text-[10px] text-slate-400">{u.email}</span>
                      </td>
                      <td className="p-3 uppercase font-bold text-[10px]">{u.jenjang}</td>
                      <td className="p-3 font-bold">{u.jumlah_siswa} Siswa</td>
                      <td className="p-3">
                        <button
                          onClick={() => handleDelete(u.id)}
                          className="p-1.5 bg-rose-50 text-rose-600 rounded-lg hover:bg-rose-100"
                        >
                          <Trash2 className="w-4 h-4" />
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
