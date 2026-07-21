import Link from "next/link";
import { redirect } from "next/navigation";
import { getSession } from "@/lib/auth";
import { prisma } from "@/lib/prisma";
import BottomNav from "@/components/BottomNav";
import TopHeader from "@/components/TopHeader";
import { getJenjangTheme } from "@/lib/theme";
import { REKOM_JURUSAN, REKOM_SKILL, TIPE_LABELS, RiasecCode, slugify } from "@/lib/riasecData";
import { Compass, Star, GraduationCap, ChevronRight } from "lucide-react";

export default async function EksplorasiPage() {
  const user = await getSession();
  if (!user) redirect("/login");

  const theme = getJenjangTheme(user.jenjang);

  const hasilTes = await prisma.riasecResult.findFirst({
    where: { userId: user.id },
    orderBy: { createdAt: "desc" },
  });

  let persenArr: Record<RiasecCode, number> | null = null;
  let top3: [RiasecCode, number][] = [];
  let tipeDominan: RiasecCode | null = null;

  if (hasilTes) {
    const skorArr: Record<RiasecCode, number> = {
      r: hasilTes.skorR,
      i: hasilTes.skorI,
      a: hasilTes.skorA,
      s: hasilTes.skorS,
      e: hasilTes.skorE,
      c: hasilTes.skorC,
    };
    persenArr = Object.fromEntries(
      Object.entries(skorArr).map(([k, v]) => [k, Math.round((v / 7) * 100)])
    ) as Record<RiasecCode, number>;
    top3 = (Object.entries(persenArr) as [RiasecCode, number][]).sort((a, b) => b[1] - a[1]).slice(0, 3);
    tipeDominan = top3[0][0];
  }

  return (
    <div className="min-h-screen bg-[#f8fafc] pb-24 relative">
      <TopHeader name={user.name} />

      <main className="flex flex-col gap-5 max-w-4xl mx-auto px-4 pt-6 pb-12">
        <div className="rounded-3xl p-6 shadow-lg relative overflow-hidden text-white" style={theme.gradientStyle}>
          <div className="absolute w-32 h-32 bg-white/15 rounded-full -top-10 -right-10" />
          <div className="relative z-10">
            <h1 className="font-extrabold text-xl mb-1 flex items-center gap-2">
              <Compass className="w-5 h-5" /> Eksplorasi
            </h1>
            <p className="text-sm text-white/85">
              {theme.isSmk
                ? "Lihat hasil minatmu dan rekomendasi keahlian tambahan di luar jurusanmu."
                : "Lihat hasil minatmu dan rekomendasi jurusan SMK yang paling cocok."}
            </p>
          </div>
        </div>

        {!hasilTes || !persenArr || !tipeDominan ? (
          <div className={`bg-white border ${theme.accentBorder} rounded-3xl p-8 shadow-sm flex flex-col items-center text-center gap-3`}>
            <div className="w-16 h-16 rounded-full flex items-center justify-center text-white" style={theme.gradientStyle}>
              <Compass className="w-7 h-7" />
            </div>
            <h2 className={`font-bold ${theme.accentText} text-lg`}>Belum ada hasil tes</h2>
            <p className="text-sm text-gray-500 max-w-xs">
              Selesaikan tes minat dulu di menu Assessment supaya kami bisa kasih rekomendasi buat kamu.
            </p>
            <Link href="/assessment" className={`inline-block ${theme.accentBtn} text-white text-xs font-bold py-2.5 px-5 rounded-lg transition-colors`}>
              Ke Halaman Assessment
            </Link>
          </div>
        ) : (
          <>
            {/* 3 tipe dominan */}
            <div className="rounded-2xl p-5 text-white shadow-sm relative overflow-hidden" style={theme.gradientStyle}>
              <p className="text-[10px] font-bold text-white/80 tracking-wider uppercase mb-3 text-center">3 Tipe Dominan Kamu</p>
              <div className="grid grid-cols-3 gap-2">
                {top3.map(([kode, persen], idx) => (
                  <div key={kode} className="bg-white/15 rounded-xl p-3 text-center">
                    <p className="text-[10px] font-bold text-white/70 mb-1">#{idx + 1}</p>
                    <p className="font-extrabold text-lg">{kode.toUpperCase()}</p>
                    <p className="text-[10px] font-medium text-white/90 mb-1">{TIPE_LABELS[kode]}</p>
                    <p className="text-xs font-bold">{persen}%</p>
                  </div>
                ))}
              </div>
            </div>

            {/* Rincian semua skor */}
            <div className={`bg-white border ${theme.accentBorder} rounded-2xl p-5 shadow-sm`}>
              <p className="text-[10px] font-bold text-gray-400 tracking-wider uppercase mb-3">Rincian Skor</p>
              <div className="grid grid-cols-2 gap-3">
                {(Object.entries(persenArr) as [RiasecCode, number][]).map(([kode, persen]) => (
                  <div key={kode} className={`rounded-xl ${theme.accentBg} p-3 text-center`}>
                    <p className={`text-lg font-extrabold ${theme.accentText}`}>{persen}%</p>
                    <p className="text-[10px] font-bold text-gray-500">
                      {TIPE_LABELS[kode]} [{kode.toUpperCase()}]
                    </p>
                  </div>
                ))}
              </div>
            </div>

            {/* Rekomendasi */}
            <div>
              <h2 className="text-lg font-bold text-gray-800 mb-3">
                {theme.isSmk ? "Rekomendasi Keahlian Tambahan" : "Rekomendasi Jurusan SMK"}
              </h2>
              <p className="text-xs text-gray-500 mb-4">
                Berdasarkan tipe dominan kamu: <span className={`${theme.accentText} font-bold`}>{TIPE_LABELS[tipeDominan]}</span>
              </p>
              <div className="grid grid-cols-1 gap-3">
                {(theme.isSmk ? REKOM_SKILL[tipeDominan] : REKOM_JURUSAN[tipeDominan]).map((item) =>
                  theme.isSmk ? (
                    <div key={item} className={`bg-white border ${theme.accentBorder} rounded-2xl p-4 shadow-sm flex items-center gap-3`}>
                      <div className={`w-9 h-9 shrink-0 rounded-lg ${theme.accentBg} flex items-center justify-center ${theme.accentText}`}>
                        <Star className="w-4 h-4" />
                      </div>
                      <p className="text-xs font-bold text-gray-700">{item}</p>
                    </div>
                  ) : (
                    <Link
                      key={item}
                      href={`/jurusan/${slugify(item)}`}
                      className={`bg-white border ${theme.accentBorder} rounded-2xl p-4 shadow-sm flex items-center gap-3 hover:shadow-md transition-shadow`}
                    >
                      <div className={`w-9 h-9 shrink-0 rounded-lg ${theme.accentBg} flex items-center justify-center ${theme.accentText}`}>
                        <GraduationCap className="w-4 h-4" />
                      </div>
                      <p className="text-xs font-bold text-gray-700 flex-grow">{item}</p>
                      <ChevronRight className="w-3.5 h-3.5 text-gray-300" />
                    </Link>
                  )
                )}
              </div>
            </div>
          </>
        )}
      </main>

      <BottomNav />
    </div>
  );
}
