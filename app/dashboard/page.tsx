import Link from "next/link";
import { redirect } from "next/navigation";
import { getSession } from "@/lib/auth";
import { prisma } from "@/lib/prisma";
import BottomNav from "@/components/BottomNav";
import TopHeader from "@/components/TopHeader";
import { getJenjangTheme, RIASEC_LABELS } from "@/lib/theme";
import { Check, Compass, Megaphone, User } from "lucide-react";

export default async function DashboardPage() {
  const user = await getSession();

  if (!user) {
    redirect("/login");
  }

  if (!user.nisn || !user.asal_sekolah) {
    redirect("/lengkapi-profil");
  }

  const theme = getJenjangTheme(user.jenjang);

  const hasilTes = await prisma.riasecResult.findFirst({
    where: { userId: user.id },
    orderBy: { createdAt: "desc" },
  });

  let tipeDominan: string | null = null;
  if (hasilTes) {
    const skor: Record<string, number> = {
      R: hasilTes.skorR,
      I: hasilTes.skorI,
      A: hasilTes.skorA,
      S: hasilTes.skorS,
      E: hasilTes.skorE,
      C: hasilTes.skorC,
    };
    const top = Object.entries(skor).sort((a, b) => b[1] - a[1])[0][0];
    tipeDominan = RIASEC_LABELS[top];
  }

  // Pengumuman dari Admin Direktorat, disaring sesuai target penerima & jenjang siswa.
  const pengumuman = await prisma.broadcast.findMany({
    where: {
      targetPenerima: { in: ["siswa", "semua"] },
      targetJenjang: { in: [user.jenjang || "smp", "semua"] },
    },
    orderBy: { createdAt: "desc" },
    take: 5,
  });

  return (
    <div className="min-h-screen bg-[#f8fafc] pb-24 relative">
      <TopHeader name={user.name} />

      <main className="flex flex-col gap-5 max-w-4xl mx-auto px-4 pt-6 pb-12">
        {/* Hero */}
        <div className="rounded-3xl p-6 shadow-lg relative overflow-hidden text-white" style={theme.gradientStyle}>
          <div className="absolute w-32 h-32 bg-white/15 rounded-full -top-10 -right-10" />
          <div className="relative z-10 flex items-center gap-4">
            <div className="w-14 h-14 rounded-full bg-white/20 border-2 border-white/40 flex items-center justify-center text-2xl shrink-0">
              <User className="w-6 h-6" />
            </div>
            <div>
              <p className="text-xs text-white/80 mb-0.5">Halo, semangat terus!</p>
              <h2 className="font-extrabold text-xl">{user.name}</h2>
              <span className="inline-block bg-white/25 text-[10px] font-bold px-2.5 py-1 rounded-full mt-1.5">
                {theme.badgeLabel}
              </span>
            </div>
          </div>
        </div>

        {/* Status + hasil terakhir */}
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div className={`bg-white border ${theme.accentBorder} rounded-2xl p-5 shadow-sm`}>
            <p className="text-[10px] font-bold text-gray-400 tracking-wider uppercase mb-2">Status Tes Minat</p>
            <div className="flex items-center gap-2 mb-3">
              <div
                className={`w-6 h-6 rounded-full flex items-center justify-center text-sm ${
                  hasilTes ? "bg-[#dcfce7] text-[#16a34a]" : "bg-gray-100 text-gray-400"
                }`}
              >
                <Check className="w-3.5 h-3.5" />
              </div>
              <h3 className={`font-bold text-xl ${hasilTes ? "text-[#16a34a]" : "text-gray-400"}`}>
                {hasilTes ? "Selesai" : "Belum Tes"}
              </h3>
            </div>
            {hasilTes ? (
              <p className="text-xs text-gray-500">
                Tes terakhir: {hasilTes.createdAt.toLocaleDateString("id-ID", { day: "2-digit", month: "short", year: "numeric" })}
              </p>
            ) : (
              <p className="text-xs text-red-500">Silakan lakukan tes terlebih dahulu.</p>
            )}
          </div>

          <div className="rounded-2xl p-5 text-white shadow-sm relative overflow-hidden" style={theme.gradientStyle}>
            <p className="text-[10px] font-bold text-white/80 tracking-wider uppercase mb-3">Hasil Terakhir</p>
            {hasilTes ? (
              <p className="text-sm">
                Skor R: {hasilTes.skorR}, I: {hasilTes.skorI}, A: {hasilTes.skorA}
              </p>
            ) : (
              <p className="text-sm">Data belum tersedia.</p>
            )}
          </div>
        </div>

        {/* Kartu highlight pembeda SMP / SMK */}
        <div className={`bg-white border ${theme.accentBorder} rounded-2xl p-5 shadow-sm`}>
          <p className="text-[10px] font-bold text-gray-400 tracking-wider uppercase mb-2">
            {theme.isSmk ? "Progress Eksplorasi Skill" : "Rekomendasi Awal"}
          </p>
          {hasilTes ? (
            <>
              <h3 className={`font-bold ${theme.accentText} text-lg mb-1`}>Tipe dominan kamu: {tipeDominan}</h3>
              <p className="text-xs text-gray-600 mb-4">
                {theme.isSmk
                  ? "Lihat rekomendasi keahlian tambahan (soft skill & hard skill) di luar jurusanmu."
                  : "Lihat rekomendasi jurusan SMK yang paling cocok buat kamu."}
              </p>
            </>
          ) : (
            <>
              <h3 className="font-bold text-gray-400 text-lg mb-1">Belum ada data</h3>
              <p className="text-xs text-gray-500 mb-4">Selesaikan tes minat dulu supaya kami bisa kasih rekomendasi.</p>
            </>
          )}
          <Link
            href="/eksplorasi"
            className={`inline-flex items-center gap-1.5 ${theme.accentBtn} text-white text-xs font-bold py-2 px-4 rounded-lg transition-colors`}
          >
            <Compass className="w-3.5 h-3.5" /> Buka Eksplorasi
          </Link>
        </div>

        {/* Pengumuman */}
        <div className={`bg-white border ${theme.accentBorder} rounded-2xl p-5 shadow-sm`}>
          <div className="flex items-center gap-2 mb-4">
            <div className={`w-8 h-8 rounded-lg ${theme.accentBg} ${theme.accentText} flex items-center justify-center`}>
              <Megaphone className="w-4 h-4" />
            </div>
            <div>
              <p className="text-[10px] font-bold text-gray-400 tracking-wider uppercase">Pengumuman</p>
              <h3 className="font-bold text-gray-800 text-sm">Info &amp; Berita Terbaru</h3>
            </div>
          </div>

          {pengumuman.length === 0 ? (
            <div className="text-center py-6">
              <p className="text-xs text-gray-400">Belum ada pengumuman untuk saat ini.</p>
            </div>
          ) : (
            <div className="flex flex-col gap-3">
              {pengumuman.map((p: (typeof pengumuman)[number]) => (
                <div key={p.id} className={`border ${theme.accentBorder} rounded-xl p-4`}>
                  <div className="flex items-start justify-between gap-3">
                    <h4 className="font-bold text-gray-800 text-sm">{p.subjek}</h4>
                    <span className="text-[10px] text-gray-400 whitespace-nowrap shrink-0">
                      {p.createdAt.toLocaleDateString("id-ID", { day: "2-digit", month: "short", year: "numeric" })}
                    </span>
                  </div>
                  <p className="text-xs text-gray-600 mt-1.5 whitespace-pre-line">{p.isi}</p>
                </div>
              ))}
            </div>
          )}
        </div>
      </main>

      <BottomNav />
    </div>
  );
}
