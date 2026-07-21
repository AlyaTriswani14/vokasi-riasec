import Link from "next/link";
import { redirect } from "next/navigation";
import { getSession } from "@/lib/auth";
import { prisma } from "@/lib/prisma";
import { ArrowLeft, UserCheck, Award } from "lucide-react";

export default async function GuruBkSiswaDetailPage({
  params,
}: {
  params: Promise<{ id: string }>;
}) {
  const user = await getSession();
  if (!user || user.role !== "guru_bk") redirect("/guru-bk/login");

  const { id } = await params;
  const siswa = await prisma.user.findFirst({
    where: {
      id: parseInt(id, 10),
      role: "siswa",
      asal_sekolah: user.nama_sekolah || "",
    },
    include: {
      results: {
        orderBy: { createdAt: "desc" },
        take: 1,
      },
    },
  });

  if (!siswa) {
    redirect("/guru-bk/panel");
  }

  const hasil = siswa.results[0];

  const skorArr = hasil
    ? [
        { code: "R", name: "Realistic (Praktis)", val: hasil.skorR },
        { code: "I", name: "Investigative (Pemikir)", val: hasil.skorI },
        { code: "A", name: "Artistic (Kreatif)", val: hasil.skorA },
        { code: "S", name: "Social (Penolong)", val: hasil.skorS },
        { code: "E", name: "Enterprising (Pemimpin)", val: hasil.skorE },
        { code: "C", name: "Conventional (Teratur)", val: hasil.skorC },
      ]
    : [];

  return (
    <div className="min-h-screen bg-slate-50 p-4 md:p-8">
      <div className="max-w-2xl mx-auto space-y-6">
        <Link
          href="/guru-bk/panel"
          className="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-slate-800"
        >
          <ArrowLeft className="w-4 h-4" /> Kembali ke Panel Guru BK
        </Link>

        {/* Student Profile Overview */}
        <div className="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 space-y-4">
          <div className="flex items-center gap-3">
            <div className="w-12 h-12 rounded-2xl bg-teal-100 text-teal-700 flex items-center justify-center font-bold text-xl">
              👤
            </div>
            <div>
              <h1 className="text-xl font-extrabold text-slate-800">{siswa.name}</h1>
              <p className="text-xs text-slate-500">
                NISN: {siswa.nisn || "-"} • Kelas: {siswa.kelas || "-"} • Email: {siswa.email}
              </p>
            </div>
          </div>

          <div className="grid grid-cols-2 gap-2 text-xs bg-slate-50 p-3 rounded-2xl border border-slate-100">
            <div><span className="text-slate-400 font-bold">Sekolah:</span> {siswa.asal_sekolah}</div>
            <div><span className="text-slate-400 font-bold">Domisili:</span> {siswa.kecamatan}, {siswa.kabupaten_kota}</div>
          </div>
        </div>

        {/* RIASEC Score Breakdown */}
        <div className="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 space-y-4">
          <h2 className="text-sm font-extrabold text-slate-800 flex items-center gap-2">
            <Award className="w-5 h-5 text-amber-500" /> Hasil Breakdown Skor RIASEC Siswa
          </h2>

          {!hasil ? (
            <div className="text-xs text-slate-400 text-center py-6">Siswa belum mengerjakan tes RIASEC.</div>
          ) : (
            <div className="space-y-3">
              {skorArr.map((item) => {
                const persen = Math.min(100, Math.round((item.val / 5) * 100));
                return (
                  <div key={item.code} className="space-y-1">
                    <div className="flex items-center justify-between text-xs">
                      <span className="font-extrabold text-slate-800">{item.name}</span>
                      <span className="font-mono text-teal-700 font-bold">{item.val} Poin ({persen}%)</span>
                    </div>
                    <div className="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                      <div
                        className="bg-teal-600 h-full rounded-full transition-all duration-500"
                        style={{ width: `${persen}%` }}
                      ></div>
                    </div>
                  </div>
                );
              })}
            </div>
          )}
        </div>
      </div>
    </div>
  );
}
