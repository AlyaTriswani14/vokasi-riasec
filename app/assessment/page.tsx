import Link from "next/link";
import { redirect } from "next/navigation";
import { getSession } from "@/lib/auth";
import { prisma } from "@/lib/prisma";
import BottomNav from "@/components/BottomNav";
import TopHeader from "@/components/TopHeader";
import { getJenjangTheme } from "@/lib/theme";
import { Wrench, Search, Palette, Users, Briefcase, ClipboardList } from "lucide-react";

const TIPE_RIASEC = [
  { kode: "R", nama: "Realistic", Icon: Wrench, desc: "Suka kerja praktis: menggunakan alat, mesin, atau aktivitas fisik langsung." },
  { kode: "I", nama: "Investigative", Icon: Search, desc: "Suka meneliti, menganalisis data, dan memecahkan masalah secara logis." },
  { kode: "A", nama: "Artistic", Icon: Palette, desc: "Suka berekspresi kreatif lewat seni, musik, desain, atau tulisan." },
  { kode: "S", nama: "Social", Icon: Users, desc: "Suka membantu, mengajar, dan berinteraksi langsung dengan orang lain." },
  { kode: "E", nama: "Enterprising", Icon: Briefcase, desc: "Suka memimpin, meyakinkan orang lain, dan mengambil inisiatif/risiko." },
  { kode: "C", nama: "Conventional", Icon: ClipboardList, desc: "Suka kerja terstruktur, rapi, detail, dan mengikuti prosedur yang jelas." },
];

export default async function AssessmentGuidePage() {
  const user = await getSession();
  if (!user) redirect("/login");

  const theme = getJenjangTheme(user.jenjang);

  const sudahTes = !!(await prisma.riasecResult.findFirst({ where: { userId: user.id } }));

  return (
    <div className="min-h-screen bg-[#f8fafc] pb-24 relative">
      <TopHeader name={user.name} />

      <main className="flex flex-col gap-5 max-w-4xl mx-auto px-4 pt-6 pb-12">
        <div className="rounded-3xl p-6 shadow-lg relative overflow-hidden text-white" style={theme.gradientStyle}>
          <div className="absolute w-32 h-32 bg-white/15 rounded-full -top-10 -right-10" />
          <div className="relative z-10">
            <h1 className="font-extrabold text-xl mb-1">Assessment RIASEC</h1>
            <p className="text-sm text-white/85">
              Sebelum mulai, kenalan dulu yuk sama 6 tipe minat RIASEC di bawah ini. Nanti hasil tes kamu akan
              dicocokkan ke salah satu (atau kombinasi) tipe ini.
            </p>
          </div>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
          {TIPE_RIASEC.map(({ kode, nama, Icon, desc }) => (
            <div key={kode} className={`bg-white border ${theme.accentBorder} rounded-2xl p-5 shadow-sm flex gap-4 items-start`}>
              <div
                className="w-12 h-12 shrink-0 rounded-xl flex items-center justify-center text-lg text-white"
                style={theme.gradientStyle}
              >
                <Icon className="w-5 h-5" />
              </div>
              <div>
                <h3 className={`font-bold ${theme.accentText} text-base`}>
                  {nama} <span className="text-gray-400 text-xs font-normal">({kode})</span>
                </h3>
                <p className="text-xs text-gray-600 mt-1">{desc}</p>
              </div>
            </div>
          ))}
        </div>

        <div className={`bg-white border ${theme.accentBorder} rounded-2xl p-6 shadow-sm flex flex-col items-center text-center gap-3 mt-2`}>
          <h2 className="font-bold text-lg text-gray-800">{sudahTes ? "Mau ulangi tes?" : "Siap untuk mulai?"}</h2>
          <p className="text-sm text-gray-500 max-w-sm">
            {sudahTes
              ? "Kamu sudah pernah menyelesaikan tes ini. Kamu bisa mengulang kapan saja kalau minatmu berubah — hasil terbaru akan menggantikan yang lama di Dashboard."
              : 'Tes ini terdiri dari 42 pertanyaan Ya/Tidak dan bisa diselesaikan dalam waktu sekitar 10 menit. Jawab sejujur-jujurnya sesuai apa yang kamu rasakan, bukan yang menurutmu "benar".'}
          </p>
          <Link
            href="/assessment/questions"
            className={`${theme.accentBtn} text-white font-bold text-sm py-3 px-8 rounded-xl transition-colors`}
          >
            {sudahTes ? "Ulangi Tes" : "Mulai Tes"}
          </Link>
        </div>
      </main>

      <BottomNav />
    </div>
  );
}
