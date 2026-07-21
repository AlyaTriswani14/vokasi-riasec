import { redirect } from "next/navigation";
import { getSession } from "@/lib/auth";
import { prisma } from "@/lib/prisma";
import KemendikdasmenNav from "../_components/KemendikdasmenNav";
import { Baby, GraduationCap, CheckCircle2, School, Landmark, ChartArea } from "lucide-react";

function formatNumber(n: number) {
  return n.toLocaleString("id-ID");
}

export default async function KemendikdasmenDashboardPage() {
  const user = await getSession();
  if (!user || user.role !== "kemendikdasmen") {
    redirect("/kemendikdasmen/login");
  }

  const [totalSiswaSmp, totalSiswaSmk, totalSekolahSmp, totalSekolahSmk] = await Promise.all([
    prisma.user.count({ where: { role: "siswa", jenjang: "smp" } }),
    prisma.user.count({ where: { role: "siswa", jenjang: "smk" } }),
    prisma.user.count({ where: { role: "guru_bk", jenjang: "smp" } }),
    prisma.user.count({ where: { role: "guru_bk", jenjang: "smk" } }),
  ]);

  const [siswaSmpIds, siswaSmkIds] = await Promise.all([
    prisma.user.findMany({ where: { role: "siswa", jenjang: "smp" }, select: { id: true } }),
    prisma.user.findMany({ where: { role: "siswa", jenjang: "smk" }, select: { id: true } }),
  ]);

  const smpIdList: number[] = siswaSmpIds.map((u: { id: number }) => u.id);
  const smkIdList: number[] = siswaSmkIds.map((u: { id: number }) => u.id);

  const [totalTesSmp, totalTesSmk] = await Promise.all([
    prisma.riasecResult.findMany({
      where: { userId: { in: smpIdList } },
      distinct: ["userId"],
      select: { userId: true },
    }),
    prisma.riasecResult.findMany({
      where: { userId: { in: smkIdList } },
      distinct: ["userId"],
      select: { userId: true },
    }),
  ]);

  // Top 5 sekolah berdasarkan jumlah siswa terdaftar
  const semuaGuru = await prisma.user.findMany({ where: { role: "guru_bk" } });
  const topSekolahRaw = await Promise.all(
    semuaGuru.map(async (guru: { nama_sekolah: string | null; npsn: string | null }) => {
      const jumlahSiswa = await prisma.user.count({
        where: { role: "siswa", asal_sekolah: guru.nama_sekolah || "" },
      });
      return {
        nama: guru.nama_sekolah || "-",
        npsn: guru.npsn || "-",
        jumlah_siswa: jumlahSiswa,
      };
    })
  );
  const topSekolah = topSekolahRaw
    .sort((a: { jumlah_siswa: number }, b: { jumlah_siswa: number }) => b.jumlah_siswa - a.jumlah_siswa)
    .slice(0, 5);

  // Tren jumlah tes selesai per bulan, dipisah SMP & SMK
  const semuaUser = await prisma.user.findMany({ select: { id: true, jenjang: true } });
  const jenjangMap = new Map(semuaUser.map((u: { id: number; jenjang: string | null }) => [u.id, u.jenjang]));
  const hasilAll = await prisma.riasecResult.findMany({
    select: { userId: true, createdAt: true },
    orderBy: { createdAt: "asc" },
  });

  const trendSmp: Record<string, number> = {};
  const trendSmk: Record<string, number> = {};
  for (const r of hasilAll) {
    const bulan = `${r.createdAt.getFullYear()}-${String(r.createdAt.getMonth() + 1).padStart(2, "0")}`;
    const jenjangSiswa = jenjangMap.get(r.userId);
    if (jenjangSiswa === "smp") trendSmp[bulan] = (trendSmp[bulan] || 0) + 1;
    else if (jenjangSiswa === "smk") trendSmk[bulan] = (trendSmk[bulan] || 0) + 1;
  }

  const bulanLabel = (b: string) => {
    const [y, m] = b.split("-");
    const namaBulan = [
      "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des",
    ];
    return `${namaBulan[parseInt(m, 10) - 1]} ${y}`;
  };

  const allBulan = Array.from(new Set([...Object.keys(trendSmp), ...Object.keys(trendSmk)])).sort();
  const trendData = allBulan.map((b) => ({
    label: bulanLabel(b),
    smp: trendSmp[b] || 0,
    smk: trendSmk[b] || 0,
  }));
  const maxTrend = Math.max(1, ...trendData.map((d) => Math.max(d.smp, d.smk)));

  return (
    <div className="min-h-screen bg-[#f8fafc]">
      <KemendikdasmenNav active="dashboard" userName={user.name} />

      <main className="w-full max-w-6xl mx-auto px-4 py-8 flex flex-col gap-6">
        <div>
          <span className="inline-block bg-[#003366] text-white text-[10px] font-bold px-3 py-1.5 rounded-full mb-2">
            ADMIN DIREKTORAT SMK
          </span>
          <h1 className="text-xl font-extrabold text-slate-800">Dashboard Analitik Platform</h1>
          <p className="text-sm text-slate-500">
            Ringkasan data seluruh sekolah &amp; siswa yang terdaftar, dipisah per jenjang.
          </p>
        </div>

        {/* Stats: 6 kartu, dipisah SMP (oranye) & SMK (biru) */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
          <div className="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <div className="w-10 h-10 rounded-xl bg-orange-50 text-[#c2410c] flex items-center justify-center mb-3">
              <Baby className="w-5 h-5" />
            </div>
            <p className="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Siswa SMP Terdaftar</p>
            <h2 className="text-2xl font-extrabold text-slate-800">{formatNumber(totalSiswaSmp)}</h2>
          </div>
          <div className="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <div className="w-10 h-10 rounded-xl bg-blue-50 text-[#2F6FED] flex items-center justify-center mb-3">
              <GraduationCap className="w-5 h-5" />
            </div>
            <p className="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Siswa SMK Terdaftar</p>
            <h2 className="text-2xl font-extrabold text-slate-800">{formatNumber(totalSiswaSmk)}</h2>
          </div>
          <div className="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <div className="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center mb-3">
              <CheckCircle2 className="w-5 h-5" />
            </div>
            <p className="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Total Tes Selesai</p>
            <h2 className="text-2xl font-extrabold text-green-600">
              {formatNumber(totalTesSmp.length + totalTesSmk.length)}
            </h2>
          </div>
          <div className="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <div className="w-10 h-10 rounded-xl bg-orange-50 text-[#c2410c] flex items-center justify-center mb-3">
              <School className="w-5 h-5" />
            </div>
            <p className="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">SMP Terdaftar</p>
            <h2 className="text-2xl font-extrabold text-slate-800">{formatNumber(totalSekolahSmp)}</h2>
          </div>
          <div className="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <div className="w-10 h-10 rounded-xl bg-blue-50 text-[#2F6FED] flex items-center justify-center mb-3">
              <Landmark className="w-5 h-5" />
            </div>
            <p className="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">SMK Terdaftar</p>
            <h2 className="text-2xl font-extrabold text-slate-800">{formatNumber(totalSekolahSmk)}</h2>
          </div>
          <div className="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
            <div className="w-10 h-10 rounded-xl bg-teal-50 text-[#0f766e] flex items-center justify-center mb-3">
              <ChartArea className="w-5 h-5" />
            </div>
            <p className="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Tes SMP / SMK Selesai</p>
            <h2 className="text-lg font-extrabold text-slate-800">
              {formatNumber(totalTesSmp.length)} <span className="text-[#c2410c]">SMP</span> &middot;{" "}
              {formatNumber(totalTesSmk.length)} <span className="text-[#2F6FED]">SMK</span>
            </h2>
          </div>
        </div>

        {/* Tren peserta tes */}
        <div className="bg-white border border-slate-100 rounded-2xl shadow-sm p-5">
          <h2 className="font-bold text-slate-800 text-sm mb-1">Tren Peserta Tes RIASEC</h2>
          <p className="text-xs text-slate-400 mb-4">
            Jumlah siswa yang menyelesaikan tes per bulan, dipisah jenjang.
          </p>

          {trendData.length === 0 ? (
            <div className="p-10 text-center">
              <p className="text-sm text-slate-500">Belum ada data tes untuk ditampilkan dalam grafik.</p>
            </div>
          ) : (
            <div className="flex flex-col gap-3">
              <div className="flex items-end gap-3 h-48 overflow-x-auto">
                {trendData.map((d) => (
                  <div key={d.label} className="flex flex-col items-center gap-1 min-w-[44px]">
                    <div className="flex items-end gap-0.5 h-36">
                      <div
                        className="w-3.5 rounded-t bg-[#F97316]"
                        style={{ height: `${(d.smp / maxTrend) * 100}%` }}
                        title={`SMP: ${d.smp}`}
                      />
                      <div
                        className="w-3.5 rounded-t bg-[#2F6FED]"
                        style={{ height: `${(d.smk / maxTrend) * 100}%` }}
                        title={`SMK: ${d.smk}`}
                      />
                    </div>
                    <span className="text-[9px] text-slate-400 font-medium whitespace-nowrap">{d.label}</span>
                  </div>
                ))}
              </div>
              <div className="flex items-center gap-4 text-[10px] font-bold text-slate-500">
                <span className="inline-flex items-center gap-1">
                  <span className="w-2.5 h-2.5 rounded-sm bg-[#F97316] inline-block" /> SMP
                </span>
                <span className="inline-flex items-center gap-1">
                  <span className="w-2.5 h-2.5 rounded-sm bg-[#2F6FED] inline-block" /> SMK
                </span>
              </div>
            </div>
          )}
        </div>

        {/* Top sekolah */}
        <div className="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
          <div className="p-5 border-b border-slate-100 flex justify-between items-center">
            <h2 className="font-bold text-slate-800 text-sm">Top 5 Sekolah (Jumlah Siswa Terdaftar)</h2>
            <a href="/kemendikdasmen/users" className="text-[10px] font-bold text-[#003366] hover:underline">
              Lihat semua &rarr;
            </a>
          </div>

          {topSekolah.length === 0 ? (
            <div className="p-10 text-center">
              <p className="text-sm text-slate-500">Belum ada sekolah yang mendaftarkan akun Guru BK.</p>
            </div>
          ) : (
            <div className="overflow-x-auto">
              <table className="w-full text-sm">
                <thead>
                  <tr className="bg-slate-50 text-left">
                    <th className="px-5 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Peringkat</th>
                    <th className="px-5 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Sekolah</th>
                    <th className="px-5 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">NPSN</th>
                    <th className="px-5 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Jumlah Siswa</th>
                  </tr>
                </thead>
                <tbody>
                  {topSekolah.map((s: { nama: string; npsn: string; jumlah_siswa: number }, i: number) => (
                    <tr key={`${s.nama}-${i}`} className="border-t border-slate-50">
                      <td className="px-5 py-3 font-bold text-slate-400">#{i + 1}</td>
                      <td className="px-5 py-3 font-bold text-slate-700">{s.nama}</td>
                      <td className="px-5 py-3 text-slate-500">{s.npsn}</td>
                      <td className="px-5 py-3">
                        <span className="bg-blue-50 text-[#003366] text-[10px] font-bold px-2.5 py-1 rounded-full">
                          {s.jumlah_siswa} siswa
                        </span>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          )}
        </div>
      </main>
    </div>
  );
}
