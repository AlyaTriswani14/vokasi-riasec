import Link from "next/link";
import { redirect } from "next/navigation";
import { getSession } from "@/lib/auth";
import { prisma } from "@/lib/prisma";
import BottomNav from "@/components/BottomNav";
import TopHeader from "@/components/TopHeader";
import { getJenjangTheme } from "@/lib/theme";
import { ClipboardCheck, ListOrdered, Smile, Clock, TriangleAlert } from "lucide-react";

export default async function AssessmentGuidePage() {
  const user = await getSession();

  if (!user) redirect("/login");

  const theme = getJenjangTheme(user.jenjang);

  const totalSoal = await prisma.soalRiasec.count({ where: { status: "aktif" } });

  const durasiSetting = await prisma.pengaturan.findUnique({
    where: { kunci: "durasi_tes_menit" },
  });

  const durasiMenit = parseInt(durasiSetting?.nilai || "5", 10);

  return (
    <div className="min-h-screen bg-[#f8fafc] pb-24 relative">
      <TopHeader name={user.name} />

      <main className="max-w-4xl mx-auto px-4 pt-6 pb-12">
        <div className={`bg-white p-8 rounded-3xl shadow-lg border ${theme.accentBorder} text-center relative overflow-hidden`}>
          <div className="absolute w-28 h-28 rounded-full -top-10 -right-10 opacity-10" style={theme.gradientStyle} />
          <div className="relative z-10">
            <div
              className="w-14 h-14 mx-auto rounded-full flex items-center justify-center text-white mb-4"
              style={theme.gradientStyle}
            >
              <ClipboardCheck className="w-6 h-6" />
            </div>
            <h2 className="text-xl font-extrabold text-gray-800 mb-2">Sebelum Mulai Tes</h2>
            <p className="text-sm text-gray-500 mb-6">Baca dulu ketentuannya ya, biar hasil tesmu akurat.</p>

            <div className="flex flex-col gap-3 text-left mb-8">
              <div className="flex items-start gap-3">
                <div className={`w-7 h-7 shrink-0 rounded-lg ${theme.accentBg} ${theme.accentText} flex items-center justify-center mt-0.5`}>
                  <ListOrdered className="w-3.5 h-3.5" />
                </div>
                <p className="text-xs text-gray-600">
                  Ada <span className="font-bold text-gray-800">{totalSoal} pertanyaan</span>, jawab{" "}
                  <span className="font-bold text-gray-800">YA</span> atau <span className="font-bold text-gray-800">TIDAK</span> satu per satu.
                </p>
              </div>
              <div className="flex items-start gap-3">
                <div className={`w-7 h-7 shrink-0 rounded-lg ${theme.accentBg} ${theme.accentText} flex items-center justify-center mt-0.5`}>
                  <Smile className="w-3.5 h-3.5" />
                </div>
                <p className="text-xs text-gray-600">Tidak ada jawaban benar atau salah — jawab sesuai apa yang kamu rasakan.</p>
              </div>
              <div className="flex items-start gap-3">
                <div className={`w-7 h-7 shrink-0 rounded-lg ${theme.accentBg} ${theme.accentText} flex items-center justify-center mt-0.5`}>
                  <Clock className="w-3.5 h-3.5" />
                </div>
                <p className="text-xs text-gray-600">
                  Waktu pengerjaan <span className="font-bold text-gray-800">{durasiMenit} menit</span>. Kalau waktu habis, jawaban yang sudah
                  kamu isi otomatis terkirim.
                </p>
              </div>
              <div className="flex items-start gap-3">
                <div className={`w-7 h-7 shrink-0 rounded-lg ${theme.accentBg} ${theme.accentText} flex items-center justify-center mt-0.5`}>
                  <TriangleAlert className="w-3.5 h-3.5" />
                </div>
                <p className="text-xs text-gray-600">Jangan tutup atau refresh halaman sampai tesnya selesai.</p>
              </div>
            </div>

            <Link
              href="/assessment/questions"
              className="w-full block text-white font-bold text-sm py-4 rounded-2xl transition-transform active:scale-95 shadow-md"
              style={theme.gradientStyle}
            >
              Mulai Tes Sekarang
            </Link>
          </div>
        </div>
      </main>

      <BottomNav />
    </div>
  );
}
