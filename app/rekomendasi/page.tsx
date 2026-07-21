import Link from "next/link";
import { redirect } from "next/navigation";
import { getSession } from "@/lib/auth";
import { prisma } from "@/lib/prisma";
import { getSekolahTerdekat } from "@/lib/sekolahService";
import BottomNav from "@/components/BottomNav";
import TopHeader from "@/components/TopHeader";
import { getJenjangTheme } from "@/lib/theme";
import { PROSPEK_KARIER, TIPE_LABELS, RiasecCode } from "@/lib/riasecData";
import { Target, Briefcase, MapPin, School } from "lucide-react";

export default async function RekomendasiPage() {
  const user = await getSession();
  if (!user) redirect("/login");

  const theme = getJenjangTheme(user.jenjang);

  const hasilTes = await prisma.riasecResult.findFirst({
    where: { userId: user.id },
    orderBy: { createdAt: "desc" },
  });

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
    tipeDominan = (Object.entries(skorArr) as [RiasecCode, number][]).sort((a, b) => b[1] - a[1])[0][0];
  }

  const domisiliLengkap = !!(user.provinsi && user.kabupaten_kota && user.kecamatan && user.kelurahan);
  const sekolahTerdekat = !theme.isSmk && hasilTes ? await getSekolahTerdekat(user) : [];

  return (
    <div className="min-h-screen bg-[#f8fafc] pb-24 max-w-md mx-auto relative shadow-2xl">
      <TopHeader name={user.name} />

      <main className="flex flex-col gap-5 px-4 pt-6 pb-12">
        <div className="rounded-3xl p-6 shadow-lg relative overflow-hidden text-white" style={theme.gradientStyle}>
          <div className="absolute w-32 h-32 bg-white/15 rounded-full -top-10 -right-10" />
          <div className="relative z-10">
            <h1 className="font-extrabold text-xl mb-1 flex items-center gap-2">
              <Target className="w-5 h-5" /> Rekomendasi
            </h1>
            <p className="text-sm text-white/85">
              {theme.isSmk ? "Prospek karier yang cocok berdasarkan tipe minatmu." : "SMK terdekat yang sesuai minatmu."}
            </p>
          </div>
        </div>

        {!hasilTes || !tipeDominan ? (
          <div className={`bg-white border ${theme.accentBorder} rounded-3xl p-8 shadow-sm flex flex-col items-center text-center gap-3`}>
            <div className="w-16 h-16 rounded-full flex items-center justify-center text-white" style={theme.gradientStyle}>
              <Target className="w-7 h-7" />
            </div>
            <h2 className={`font-bold ${theme.accentText} text-lg`}>Belum ada hasil tes</h2>
            <p className="text-sm text-gray-500 max-w-xs">
              Selesaikan tes minat dulu di menu Assessment supaya kami bisa kasih rekomendasi buat kamu.
            </p>
            <Link href="/assessment" className={`inline-block ${theme.accentBtn} text-white text-xs font-bold py-2.5 px-5 rounded-lg transition-colors`}>
              Ke Halaman Assessment
            </Link>
          </div>
        ) : theme.isSmk ? (
          <div>
            <h2 className="text-lg font-bold text-gray-800 mb-1">Prospek Karier</h2>
            <p className="text-xs text-gray-500 mb-4">
              Berdasarkan tipe dominan kamu: <span className={`${theme.accentText} font-bold`}>{TIPE_LABELS[tipeDominan]}</span>
            </p>
            <div className="flex flex-col gap-3">
              {PROSPEK_KARIER[tipeDominan].map((k) => (
                <div key={k.karier} className={`bg-white border ${theme.accentBorder} rounded-2xl p-5 shadow-sm`}>
                  <div className="flex items-center gap-3 mb-3">
                    <div className="w-10 h-10 shrink-0 rounded-xl flex items-center justify-center text-white" style={theme.gradientStyle}>
                      <Briefcase className="w-4 h-4" />
                    </div>
                    <h3 className={`font-bold ${theme.accentText} text-base`}>{k.karier}</h3>
                  </div>
                  <div className="flex flex-col gap-1.5 text-xs text-gray-600">
                    <p>
                      <span className="font-bold text-gray-500">Mata pelajaran relevan:</span> {k.mapel}
                    </p>
                    <p>
                      <span className="font-bold text-gray-500">Kisaran gaji:</span> {k.gaji}
                    </p>
                  </div>
                </div>
              ))}
            </div>
            <p className="text-[10px] text-gray-400 mt-3">
              *Kisaran gaji bersifat umum sebagai gambaran awal, bisa berbeda tergantung pengalaman, lokasi, dan perusahaan.
            </p>
          </div>
        ) : (
          <div>
            <h2 className="text-lg font-bold text-gray-800 mb-3">SMK Terdekat</h2>

            {!domisiliLengkap ? (
              <div className={`bg-white border ${theme.accentBorder} rounded-2xl p-5 shadow-sm flex flex-col items-center text-center gap-2`}>
                <MapPin className={`w-5 h-5 ${theme.accentText}`} />
                <p className="text-sm text-gray-600">
                  Lengkapi data domisili di halaman{" "}
                  <Link href="/profil" className={`font-bold ${theme.accentText} underline`}>
                    Profil
                  </Link>{" "}
                  supaya kami bisa cari SMK terdekat dari tempat tinggalmu.
                </p>
              </div>
            ) : sekolahTerdekat.length === 0 ? (
              <div className={`bg-white border ${theme.accentBorder} rounded-2xl p-5 shadow-sm flex flex-col items-center text-center gap-2`}>
                <School className={`w-5 h-5 ${theme.accentText}`} />
                <p className="text-sm text-gray-600">Belum ada data SMK yang cocok dengan wilayahmu saat ini.</p>
              </div>
            ) : (
              <div className="flex flex-col gap-3">
                {sekolahTerdekat.map((item) => (
                  <div key={item.sekolah.npsn} className={`bg-white border ${theme.accentBorder} rounded-2xl p-4 shadow-sm flex items-center gap-3`}>
                    <div className={`w-10 h-10 shrink-0 rounded-xl ${theme.accentBg} flex items-center justify-center ${theme.accentText}`}>
                      <School className="w-4 h-4" />
                    </div>
                    <div className="flex-grow">
                      <h3 className="font-bold text-gray-800 text-sm">{item.sekolah.namaSekolah}</h3>
                      <p className="text-xs text-gray-500">
                        {item.sekolah.kecamatan}, {item.sekolah.kabupatenKota}
                      </p>
                    </div>
                    <span className={`text-[10px] font-bold ${theme.accentText} ${theme.accentBg} px-2 py-1 rounded-full shrink-0`}>
                      {item.tingkatKecocokan}
                    </span>
                  </div>
                ))}
              </div>
            )}
          </div>
        )}
      </main>

      <BottomNav />
    </div>
  );
}
