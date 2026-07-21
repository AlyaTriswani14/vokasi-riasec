import Link from "next/link";
import { redirect } from "next/navigation";
import { getSession } from "@/lib/auth";
import { prisma } from "@/lib/prisma";
import { School, Download, Users, CheckCircle, Clock, Search, LogOut, Megaphone } from "lucide-react";

const TIPE_LABELS: Record<string, string> = {
  R: "Realistic",
  I: "Investigative",
  A: "Artistic",
  S: "Social",
  E: "Enterprising",
  C: "Conventional",
};

function tipeDominan(hasil?: {
  skorR: number;
  skorI: number;
  skorA: number;
  skorS: number;
  skorE: number;
  skorC: number;
} | null) {
  if (!hasil) return null;
  const skor: Record<string, number> = {
    R: hasil.skorR,
    I: hasil.skorI,
    A: hasil.skorA,
    S: hasil.skorS,
    E: hasil.skorE,
    C: hasil.skorC,
  };
  return Object.entries(skor).sort((a, b) => b[1] - a[1])[0][0];
}

export default async function GuruBkPanelPage({
  searchParams,
}: {
  searchParams: Promise<{ search?: string; status?: string }>;
}) {
  const user = await getSession();
  if (!user || user.role !== "guru_bk") {
    redirect("/guru-bk/login");
  }

  const { search = "", status = "" } = await searchParams;

  const allSiswa = await prisma.user.findMany({
    where: {
      role: "siswa",
      asal_sekolah: user.nama_sekolah || "",
    },
    include: {
      results: {
        orderBy: { createdAt: "desc" },
        take: 1,
      },
    },
    orderBy: { name: "asc" },
  });

  // Pengumuman dari Admin Direktorat SMK yang relevan untuk peran guru_bk,
  // menyesuaikan target penerima & jenjang sekolah (meniru Broadcast::untukUser()).
  const pengumuman = await prisma.broadcast.findMany({
    where: {
      AND: [
        { OR: [{ targetPenerima: "guru_bk" }, { targetPenerima: "semua" }] },
        { OR: [{ targetJenjang: user.jenjang || undefined }, { targetJenjang: "semua" }] },
      ],
    },
    orderBy: { createdAt: "desc" },
    take: 5,
  });

  const totalSiswa = allSiswa.length;
  const sudahTes = allSiswa.filter((s) => s.results.length > 0).length;
  const belumTes = totalSiswa - sudahTes;

  let filteredSiswa = allSiswa;

  if (search.trim() !== "") {
    const q = search.toLowerCase();
    filteredSiswa = filteredSiswa.filter((s) => s.name.toLowerCase().includes(q));
  }

  if (status === "sudah") {
    filteredSiswa = filteredSiswa.filter((s) => s.results.length > 0);
  } else if (status === "belum") {
    filteredSiswa = filteredSiswa.filter((s) => s.results.length === 0);
  }

  return (
    <div className="min-h-screen bg-slate-50 p-4 md:p-8">
      <div className="max-w-6xl mx-auto space-y-6">
        {/* Top Navbar */}
        <div className="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div>
            <div className="flex items-center gap-2 text-teal-700 font-extrabold text-sm mb-1">
              <School className="w-5 h-5" /> Panel Guru BK - {user.nama_sekolah}
            </div>
            <h1 className="text-xl font-black text-slate-800">Selamat Datang, {user.name}</h1>
            <p className="text-xs text-slate-500">NPSN: {user.npsn || "-"} • Jenjang: {user.jenjang?.toUpperCase()}</p>
          </div>

          <div className="flex items-center gap-3">
            <a
              href="/api/guru-bk/export"
              className="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm transition-all"
            >
              <Download className="w-4 h-4" /> Export CSV Hasil Tes
            </a>
            <form action="/api/auth/logout" method="POST">
              <button
                type="submit"
                className="p-2.5 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-xl transition-colors"
              >
                <LogOut className="w-4 h-4" />
              </button>
            </form>
          </div>
        </div>

        {/* Stats Cards */}
        <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div className="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div className="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center">
              <Users className="w-6 h-6" />
            </div>
            <div>
              <p className="text-xs font-bold text-slate-400 uppercase">Total Siswa Binaan</p>
              <h3 className="text-2xl font-black text-slate-800">{totalSiswa}</h3>
            </div>
          </div>

          <div className="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div className="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
              <CheckCircle className="w-6 h-6" />
            </div>
            <div>
              <p className="text-xs font-bold text-slate-400 uppercase">Sudah Tes RIASEC</p>
              <h3 className="text-2xl font-black text-slate-800">{sudahTes}</h3>
            </div>
          </div>

          <div className="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div className="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
              <Clock className="w-6 h-6" />
            </div>
            <div>
              <p className="text-xs font-bold text-slate-400 uppercase">Belum Tes RIASEC</p>
              <h3 className="text-2xl font-black text-slate-800">{belumTes}</h3>
            </div>
          </div>
        </div>

        {/* Pengumuman dari Kemendikdasmen */}
        {pengumuman.length > 0 && (
          <div className="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
            <div className="flex items-center gap-2 mb-4">
              <div className="w-8 h-8 rounded-lg bg-blue-50 text-teal-700 flex items-center justify-center">
                <Megaphone className="w-4 h-4" />
              </div>
              <div>
                <p className="text-[10px] font-bold text-slate-400 tracking-wider uppercase">Pengumuman</p>
                <h3 className="font-bold text-slate-800 text-sm">Info dari Direktorat SMK</h3>
              </div>
            </div>
            <div className="flex flex-col gap-3">
              {pengumuman.map((p) => (
                <div key={p.id} className="border border-slate-100 rounded-xl p-4">
                  <div className="flex items-start justify-between gap-3">
                    <h4 className="font-bold text-slate-800 text-sm">{p.subjek}</h4>
                    <span className="text-[10px] text-slate-400 whitespace-nowrap shrink-0">
                      {new Date(p.createdAt).toLocaleDateString("id-ID", { day: "2-digit", month: "short", year: "numeric" })}
                    </span>
                  </div>
                  <p className="text-xs text-slate-600 mt-1.5 whitespace-pre-line">{p.isi}</p>
                </div>
              ))}
            </div>
          </div>
        )}

        {/* Student Table & Filters */}
        <div className="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 space-y-4">
          <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h2 className="text-base font-extrabold text-slate-800">Daftar Siswa Binaan Sekolah</h2>

            <form method="GET" className="flex items-center gap-2">
              <div className="relative">
                <Search className="w-4 h-4 absolute left-3 top-2.5 text-slate-400" />
                <input
                  type="text"
                  name="search"
                  defaultValue={search}
                  placeholder="Cari nama siswa..."
                  className="pl-9 pr-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none"
                />
              </div>

              <select
                name="status"
                defaultValue={status}
                className="py-1.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs"
              >
                <option value="">Semua Status</option>
                <option value="sudah">Sudah Tes</option>
                <option value="belum">Belum Tes</option>
              </select>

              <button type="submit" className="bg-teal-700 text-white font-bold text-xs px-3 py-1.5 rounded-xl">
                Filter
              </button>
            </form>
          </div>

          <div className="overflow-x-auto">
            <table className="w-full text-left text-xs text-slate-600">
              <thead className="bg-slate-50 text-slate-700 font-extrabold uppercase text-[10px]">
                <tr>
                  <th className="p-3">Nama Siswa</th>
                  <th className="p-3">Kelas</th>
                  <th className="p-3">NISN</th>
                  <th className="p-3">Status Tes</th>
                  <th className="p-3">Tanggal Tes</th>
                  <th className="p-3">RIASEC Dominan</th>
                  <th className="p-3">Aksi</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-100">
                {filteredSiswa.length === 0 ? (
                  <tr>
                    <td colSpan={7} className="p-6 text-center text-slate-400">
                      Tidak ada data siswa ditemukan.
                    </td>
                  </tr>
                ) : (
                  filteredSiswa.map((siswa) => {
                    const hasil = siswa.results[0];
                    const dominan = tipeDominan(hasil);
                    return (
                      <tr key={siswa.id} className="hover:bg-slate-50/80">
                        <td className="p-3 font-bold text-slate-800">{siswa.name}</td>
                        <td className="p-3">{siswa.kelas || "-"}</td>
                        <td className="p-3 font-mono">{siswa.nisn || "-"}</td>
                        <td className="p-3">
                          {hasil ? (
                            <span className="bg-emerald-100 text-emerald-800 font-bold px-2 py-0.5 rounded-full text-[10px]">
                              Selesai
                            </span>
                          ) : (
                            <span className="bg-slate-100 text-slate-600 font-bold px-2 py-0.5 rounded-full text-[10px]">
                              Belum Tes
                            </span>
                          )}
                        </td>
                        <td className="p-3">
                          {hasil ? new Date(hasil.createdAt).toLocaleDateString("id-ID") : "-"}
                        </td>
                        <td className="p-3">
                          {dominan ? (
                            <span className="bg-blue-50 text-teal-700 font-bold px-2 py-0.5 rounded-full text-[10px]">
                              {TIPE_LABELS[dominan]} ({dominan})
                            </span>
                          ) : (
                            <span className="text-slate-300">-</span>
                          )}
                        </td>
                        <td className="p-3">
                          <Link
                            href={`/guru-bk/siswa/${siswa.id}`}
                            className="text-teal-700 font-bold hover:underline text-[11px]"
                          >
                            {hasil ? "Detail Hasil" : "Lihat Profil"}
                          </Link>
                        </td>
                      </tr>
                    );
                  })
                )}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  );
}
