import Link from "next/link";
import { redirect } from "next/navigation";
import { getSession } from "@/lib/auth";
import { ArrowLeft, BookOpen, Award, Briefcase } from "lucide-react";
import BottomNav from "@/components/BottomNav";
import TopHeader from "@/components/TopHeader";
import { getJenjangTheme } from "@/lib/theme";
import { JURUSAN_DATA, POTENSI_WARNA } from "@/lib/riasecData";

export default async function JurusanDetailPage({
  params,
}: {
  params: Promise<{ slug: string }>;
}) {
  const user = await getSession();
  if (!user) redirect("/login");

  const { slug } = await params;
  const theme = getJenjangTheme(user.jenjang);
  const j = JURUSAN_DATA[slug];

  const readableTitle = slug
    .split("-")
    .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
    .join(" ");

  return (
    <div className="min-h-screen bg-[#f8fafc] pb-24 max-w-md mx-auto relative shadow-2xl">
      <TopHeader name={user.name} />

      <main className="flex flex-col gap-5 px-4 pt-6 pb-12">
        <Link href="/eksplorasi" className="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-gray-700 transition-colors w-fit">
          <ArrowLeft className="w-3.5 h-3.5" /> Kembali ke Eksplorasi
        </Link>

        {!j ? (
          <div className={`bg-white border ${theme.accentBorder} rounded-3xl p-10 shadow-sm text-center`}>
            <p className="text-sm text-gray-500">Detail jurusan &quot;{readableTitle}&quot; belum tersedia.</p>
          </div>
        ) : (
          <>
            {/* Hero */}
            <div className="rounded-3xl p-6 shadow-lg relative overflow-hidden text-white" style={theme.gradientStyle}>
              <div className="absolute w-32 h-32 bg-white/15 rounded-full -top-10 -right-10" />
              <div className="relative z-10">
                <div className="w-14 h-14 rounded-2xl bg-white/20 border-2 border-white/40 flex items-center justify-center text-2xl mb-4">
                  <BookOpen className="w-6 h-6" />
                </div>
                <span className="bg-white/25 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">Jurusan SMK</span>
                <h1 className="text-2xl font-extrabold mt-3">{j.nama}</h1>
              </div>
            </div>

            {/* Tentang */}
            <div className={`bg-white border ${theme.accentBorder} rounded-2xl p-5 shadow-sm`}>
              <h3 className="font-bold text-gray-800 text-base mb-3">Tentang Jurusan</h3>
              <p className="text-sm text-gray-600 leading-relaxed">{j.deskripsi}</p>
            </div>

            {/* Kompetensi */}
            <div>
              <h3 className="font-bold text-gray-800 text-base mb-3 pl-1">Kompetensi Utama</h3>
              <div className="grid grid-cols-1 gap-4">
                {j.kompetensi.map((k) => (
                  <div key={k.judul} className={`bg-white border ${theme.accentBorder} rounded-2xl p-5 shadow-sm`}>
                    <div className={`w-10 h-10 rounded-xl ${theme.accentBg} ${theme.accentText} flex items-center justify-center mb-4`}>
                      <Award className="w-4 h-4" />
                    </div>
                    <h4 className={`text-[10px] font-bold ${theme.accentText} tracking-wider mb-2 uppercase`}>{k.judul}</h4>
                    <p className="text-xs text-gray-600 leading-relaxed">{k.desc}</p>
                  </div>
                ))}
              </div>
            </div>

            {/* Prospek karir */}
            <div>
              <h3 className="font-bold text-gray-800 text-base mb-3 pl-1">Prospek Karir</h3>
              <div className={`bg-white rounded-2xl border ${theme.accentBorder} shadow-sm overflow-hidden`}>
                <div className="flex justify-between p-4 text-white text-xs font-bold tracking-wide" style={theme.gradientStyle}>
                  <span>Jabatan</span>
                  <span>Potensi</span>
                </div>
                {j.karir.map((k, idx) => (
                  <div
                    key={k.jabatan}
                    className={`flex justify-between items-center p-4 ${
                      idx !== j.karir.length - 1 ? "border-b border-gray-100" : ""
                    } hover:bg-gray-50 transition-colors`}
                  >
                    <div className="flex items-center gap-3 text-sm text-gray-800 font-medium">
                      <Briefcase className="w-4 h-4 text-gray-400" />
                      <span>{k.jabatan}</span>
                    </div>
                    <span className={`${POTENSI_WARNA[k.potensi] || "bg-gray-100 text-gray-500"} text-[10px] font-bold px-2.5 py-1 rounded`}>
                      {k.potensi}
                    </span>
                  </div>
                ))}
              </div>
            </div>
          </>
        )}
      </main>

      <BottomNav />
    </div>
  );
}
