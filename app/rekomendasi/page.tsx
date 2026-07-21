import Link from "next/link";
import { redirect } from "next/navigation";
import { getSession } from "@/lib/auth";
import { prisma } from "@/lib/prisma";
import { getSekolahTerdekat } from "@/lib/sekolahService";
import BottomNav from "@/components/BottomNav";
import { Sparkles, MapPin, Building, BookOpen, ArrowRight, CheckCircle2 } from "lucide-react";

export default async function RekomendasiPage() {
  const user = await getSession();
  if (!user) redirect("/login");

  const latestResult = await prisma.riasecResult.findFirst({
    where: { userId: user.id },
    orderBy: { createdAt: "desc" },
  });

  const sekolahTerdekat = await getSekolahTerdekat(user);

  const majorMapping: Record<string, { nama: string; desc: string; rekomendasi: string[] }> = {
    R: {
      nama: "Realistic (Praktis)",
      desc: "Menyukai aktivitas fisik, merakit alat, dan praktik teknik.",
      rekomendasi: ["Teknik Mesin", "Teknik Otomotif", "Teknik Sipil & Konstruksi", "Teknik Ketenagalistrikan"],
    },
    I: {
      nama: "Investigative (Pemikir)",
      desc: "Gemar mengamati, menganalisis, riset, dan pemrograman komputer.",
      rekomendasi: ["Teknik Komputer & Jaringan (TKJ)", "Rekayasa Perangkat Lunak (RPL)", "Kimia Analisis", "Farmasi Klinis"],
    },
    A: {
      nama: "Artistic (Kreatif)",
      desc: "Ekspresif, orisinal, dan menyukai kreasi visual serta media.",
      rekomendasi: ["Desain Komunikasi Visual (DKV)", "Multimedia & Animasi", "Seni Lukis & Kriya", "Tata Busana"],
    },
    S: {
      nama: "Social (Penolong)",
      desc: "Senang membantu, mengajar, dan berinteraksi sosial.",
      rekomendasi: ["Asisten Keperawatan", "Pekerjaan Sosial", "Layanan Kecepatan Kuliner", "Wisata & Perhotelan"],
    },
    E: {
      nama: "Enterprising (Pemimpin)",
      desc: "Memengaruhi orang lain, berani mengambil peluang bisnis & manajemen.",
      rekomendasi: ["Bisnis Daring & Pemasaran", "Manajemen Perkantoran", "Usaha Perjalanan Wisata", "Retail"],
    },
    C: {
      nama: "Conventional (Teratur)",
      desc: "Menyukai data, laporan keuangan, dan prosedur terstruktur.",
      rekomendasi: ["Akuntansi & Keuangan Lembaga", "Perbankan Syariah", "Administrasi Perkantoran", "Logistik"],
    },
  };

  let recommendedMajors: Array<{ code: string; nama: string; desc: string; rekomendasi: string[] }> = [];

  if (latestResult) {
    const scores = [
      { code: "R", score: latestResult.skorR },
      { code: "I", score: latestResult.skorI },
      { code: "A", score: latestResult.skorA },
      { code: "S", score: latestResult.skorS },
      { code: "E", score: latestResult.skorE },
      { code: "C", score: latestResult.skorC },
    ];
    scores.sort((a, b) => b.score - a.score);

    for (const item of scores.slice(0, 3)) {
      if (majorMapping[item.code]) {
        recommendedMajors.push({
          code: item.code,
          ...majorMapping[item.code],
        });
      }
    }
  }

  return (
    <div className="min-h-screen bg-slate-50 pb-24 max-w-md mx-auto relative shadow-2xl">
      <div className="bg-gradient-to-br from-indigo-700 via-purple-700 to-pink-600 p-6 pt-10 text-white rounded-b-3xl">
        <h1 className="text-2xl font-extrabold flex items-center gap-2">
          <Sparkles className="w-6 h-6 text-amber-300" /> Rekomendasi Jurusan & SMK
        </h1>
        <p className="text-xs text-purple-100 mt-1">
          Disesuaikan dengan tipe minat RIASEC dan lokasi domisili domisili tempat tinggalmu.
        </p>
      </div>

      <div className="p-4 space-y-5">
        {/* Recommended Majors Section */}
        <div className="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-4">
          <h2 className="text-sm font-extrabold text-slate-800 flex items-center gap-2">
            <BookOpen className="w-4 h-4 text-purple-600" /> Jurusan Vokasi Paling Cocok
          </h2>

          {!latestResult ? (
            <div className="bg-purple-50 p-4 rounded-xl text-center text-xs text-purple-700 border border-purple-100">
              Kamu belum melakukan tes RIASEC.{" "}
              <Link href="/assessment" className="font-bold underline ml-1">
                Jalankan Tes Sekarang
              </Link>
            </div>
          ) : (
            <div className="space-y-3">
              {recommendedMajors.map((item) => (
                <div key={item.code} className="bg-slate-50 p-4 rounded-xl border border-slate-100">
                  <div className="flex items-center justify-between mb-1.5">
                    <span className="font-extrabold text-xs text-purple-700">{item.nama}</span>
                    <span className="text-[10px] font-black bg-purple-100 text-purple-800 px-2 py-0.5 rounded-full">
                      Tipe {item.code}
                    </span>
                  </div>
                  <p className="text-[11px] text-slate-500 mb-2 leading-relaxed">{item.desc}</p>
                  <div className="flex flex-wrap gap-1.5">
                    {item.rekomendasi.map((jur, i) => (
                      <span
                        key={i}
                        className="bg-white text-slate-700 border border-slate-200 text-[10px] font-bold px-2.5 py-1 rounded-lg shadow-2xs"
                      >
                        {jur}
                      </span>
                    ))}
                  </div>
                </div>
              ))}
            </div>
          )}
        </div>

        {/* Closest SMK Section */}
        <div className="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-4">
          <div className="flex items-center justify-between">
            <h2 className="text-sm font-extrabold text-slate-800 flex items-center gap-2">
              <Building className="w-4 h-4 text-indigo-600" /> SMK Terdekat di Domisilimu
            </h2>
            <span className="text-[10px] text-slate-400 font-bold">{user.kabupaten_kota || "Indonesia"}</span>
          </div>

          {sekolahTerdekat.length === 0 ? (
            <div className="text-xs text-slate-400 text-center py-4 bg-slate-50 rounded-xl border border-dashed border-slate-200">
              Belum ada data sekolah di lokasi domisilimu. Lengkapi profil domisili untuk pencarian otomatis.
            </div>
          ) : (
            <div className="space-y-3">
              {sekolahTerdekat.map((item) => (
                <div
                  key={item.sekolah.npsn}
                  className="bg-slate-50 p-4 rounded-xl border border-slate-100 flex items-start justify-between gap-2"
                >
                  <div>
                    <h4 className="font-extrabold text-slate-800 text-xs">{item.sekolah.namaSekolah}</h4>
                    <p className="text-[11px] text-slate-500 mt-0.5">
                      NPSN: {item.sekolah.npsn} • {item.sekolah.kecamatan}, {item.sekolah.kabupatenKota}
                    </p>
                  </div>
                  <span className="shrink-0 text-[10px] font-bold bg-emerald-100 text-emerald-800 px-2 py-1 rounded-full border border-emerald-200">
                    {item.tingkatKecocokan}
                  </span>
                </div>
              ))}
            </div>
          )}
        </div>
      </div>

      <BottomNav />
    </div>
  );
}
