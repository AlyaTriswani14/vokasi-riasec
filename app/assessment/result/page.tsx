import { redirect } from "next/navigation";
import { getSession } from "@/lib/auth";
import { prisma } from "@/lib/prisma";
import BottomNav from "@/components/BottomNav";
import TopHeader from "@/components/TopHeader";
import { getJenjangTheme } from "@/lib/theme";
import { RIASEC_VISUAL, RiasecCode } from "@/lib/riasecData";
import { Award, Wrench, Microscope, Palette, HeartHandshake, Megaphone, FileText } from "lucide-react";

const RIASEC_ICONS: Record<RiasecCode, typeof Wrench> = {
  r: Wrench,
  i: Microscope,
  a: Palette,
  s: HeartHandshake,
  e: Megaphone,
  c: FileText,
};

export default async function AssessmentResultPage() {
  const user = await getSession();
  if (!user) redirect("/login");

  const theme = getJenjangTheme(user.jenjang);

  const latestResult = await prisma.riasecResult.findFirst({
    where: { userId: user.id },
    orderBy: { createdAt: "desc" },
  });

  if (!latestResult) {
    redirect("/assessment");
  }

  const skorArr: Record<RiasecCode, number> = {
    r: latestResult.skorR,
    i: latestResult.skorI,
    a: latestResult.skorA,
    s: latestResult.skorS,
    e: latestResult.skorE,
    c: latestResult.skorC,
  };

  const persenArr = Object.fromEntries(
    Object.entries(skorArr).map(([kode, skor]) => [kode, Math.round((skor / 7) * 100)])
  ) as Record<RiasecCode, number>;

  const top3 = (Object.entries(persenArr) as [RiasecCode, number][]).sort((a, b) => b[1] - a[1]).slice(0, 3);

  const namaDepan = user.name.split(" ")[0];

  return (
    <div className="min-h-screen bg-[#f8fafc] pb-24 relative">
      <TopHeader name={user.name} />

      <main className="flex flex-col gap-5 max-w-3xl mx-auto px-4 pt-6 pb-12">
        {/* Hero selamat */}
        <div className="rounded-3xl p-6 shadow-lg relative overflow-hidden text-white text-center" style={theme.gradientStyle}>
          <div className="absolute w-32 h-32 bg-white/15 rounded-full -top-10 -right-10" />
          <div className="absolute w-24 h-24 bg-white/10 rounded-full -bottom-8 -left-8" />
          <div className="relative z-10 flex flex-col items-center">
            <div className="bg-white/20 border-2 border-white/40 w-16 h-16 rounded-full flex items-center justify-center mb-4">
              <Award className="w-7 h-7" />
            </div>
            <h1 className="text-2xl font-extrabold mb-3">Selamat, {namaDepan}!</h1>
            <p className="text-white/85 text-sm">
              Hasil tesmu telah selesai. Cek tipe minat dominanmu dan rekomendasi jurusan yang cocok di bawah ini.
            </p>
          </div>
        </div>

        {/* Profil minat dominan */}
        <div className={`bg-white rounded-3xl p-6 shadow-sm border ${theme.accentBorder}`}>
          <h2 className={`text-center ${theme.accentText} font-bold text-lg mb-8`}>Profil Minat Dominan</h2>

          <div className="flex justify-center items-end gap-4 md:gap-8 h-48">
            {top3.map(([kode, persen]) => {
              const data = RIASEC_VISUAL[kode];
              return (
                <div key={kode} className="flex flex-col items-center w-20 md:w-24">
                  <div className="w-full bg-gray-100 rounded-t-lg h-32 relative overflow-hidden flex items-end">
                    <div
                      className={`w-full ${data.warna} flex items-center justify-center text-white font-bold text-xl transition-all duration-1000 ease-out`}
                      style={{ height: `${persen}%` }}
                    >
                      {kode.toUpperCase()}
                    </div>
                  </div>
                  <p className={`font-bold ${data.teksWarna} mt-3 text-sm`}>{persen}%</p>
                  <p className="text-xs text-gray-800 font-medium">{data.nama}</p>
                </div>
              );
            })}
          </div>
        </div>

        {/* Detail minat */}
        <div>
          <h2 className="text-lg font-bold text-gray-800 mb-3">Detail Minat Kamu</h2>

          <div className="flex flex-col gap-4">
            {top3.map(([kode]) => {
              const data = RIASEC_VISUAL[kode];
              const Icon = RIASEC_ICONS[kode];
              return (
                <div key={kode} className={`bg-white border ${theme.accentBorder} rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow`}>
                  <div className="flex gap-4">
                    <div className={`w-12 h-12 rounded-xl ${data.bgWarna} ${data.teksWarna} flex items-center justify-center text-2xl shrink-0`}>
                      <Icon className="w-6 h-6" />
                    </div>
                    <div>
                      <h3 className={`font-bold ${data.teksWarna} text-lg`}>
                        {data.nama} ({data.label})
                      </h3>
                      <p className="text-gray-600 text-sm mt-1 leading-relaxed">{data.deskripsi}</p>
                    </div>
                  </div>
                  <div className={`mt-4 ${theme.accentBg} rounded-xl p-4`}>
                    <p className={`text-[11px] font-bold ${theme.accentText} tracking-widest mb-1.5`}>REKOMENDASI SMK:</p>
                    <p className="text-sm font-medium text-gray-800">{data.rekomendasi}</p>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      </main>

      <BottomNav />
    </div>
  );
}
