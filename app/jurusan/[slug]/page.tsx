import Link from "next/link";
import { ArrowLeft, BookOpen, CheckCircle, Briefcase, Award } from "lucide-react";
import BottomNav from "@/components/BottomNav";

export default async function JurusanDetailPage({
  params,
}: {
  params: Promise<{ slug: string }>;
}) {
  const { slug } = await params;
  const readableTitle = slug
    .split("-")
    .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
    .join(" ");

  return (
    <div className="min-h-screen bg-slate-50 pb-24 max-w-md mx-auto relative shadow-2xl">
      <div className="bg-gradient-to-br from-purple-700 to-indigo-800 p-6 pt-10 text-white rounded-b-3xl">
        <Link href="/eksplorasi" className="inline-flex items-center gap-1 text-xs text-purple-200 mb-3 hover:text-white">
          <ArrowLeft className="w-4 h-4" /> Kembali ke Eksplorasi
        </Link>
        <h1 className="text-2xl font-extrabold">{readableTitle}</h1>
        <p className="text-xs text-purple-200 mt-1">
          Panduan kompetensi, materi pembelajaran, dan prospek karir lulusan.
        </p>
      </div>

      <div className="p-4 space-y-4">
        <div className="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-4">
          <div className="flex items-center gap-2 text-purple-600 font-extrabold text-xs">
            <BookOpen className="w-4 h-4" /> Deskripsi Keahlian
          </div>
          <p className="text-xs text-slate-600 leading-relaxed">
            Keahlian bidang <span className="font-bold">{readableTitle}</span> membekali siswa dengan pengetahuan teori dasar, keahlian praktis laboratorium/bengkel, dan pengalaman proyek industri riil sesuai standar DU/DI (Dunia Usaha & Dunia Industri).
          </p>

          <div className="border-t border-slate-100 pt-3">
            <h4 className="text-xs font-bold text-slate-800 mb-2 flex items-center gap-1.5">
              <Award className="w-4 h-4 text-amber-500" /> Kompetensi Utama yang Dipelajari:
            </h4>
            <ul className="text-xs text-slate-600 space-y-1.5">
              <li className="flex items-center gap-2">
                <CheckCircle className="w-3.5 h-3.5 text-emerald-500" /> Penguasaan Standar Operasional Industri
              </li>
              <li className="flex items-center gap-2">
                <CheckCircle className="w-3.5 h-3.5 text-emerald-500" /> Troubleshooting & Analisis Kasus Teknik
              </li>
              <li className="flex items-center gap-2">
                <CheckCircle className="w-3.5 h-3.5 text-emerald-500" /> Sertifikasi Profesi Nasional (BNSP)
              </li>
            </ul>
          </div>

          <div className="border-t border-slate-100 pt-3">
            <h4 className="text-xs font-bold text-slate-800 mb-2 flex items-center gap-1.5">
              <Briefcase className="w-4 h-4 text-blue-500" /> Prospek Karir & Pekerjaan:
            </h4>
            <div className="flex flex-wrap gap-1.5">
              <span className="bg-slate-100 text-slate-700 text-[10px] font-bold px-2.5 py-1 rounded-lg">
                Teknisi Ahli
              </span>
              <span className="bg-slate-100 text-slate-700 text-[10px] font-bold px-2.5 py-1 rounded-lg">
                Supervisor Proyek
              </span>
              <span className="bg-slate-100 text-slate-700 text-[10px] font-bold px-2.5 py-1 rounded-lg">
                Wirausaha Mandiri
              </span>
            </div>
          </div>
        </div>
      </div>

      <BottomNav />
    </div>
  );
}
