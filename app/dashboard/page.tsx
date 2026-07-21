import Link from "next/link";
import { redirect } from "next/navigation";
import { getSession } from "@/lib/auth";
import { prisma } from "@/lib/prisma";
import BottomNav from "@/components/BottomNav";
import { Sparkles, ArrowRight, Play, CheckCircle, Award } from "lucide-react";

export default async function DashboardPage() {
  const user = await getSession();

  if (!user) {
    redirect("/login");
  }

  if (!user.nisn || !user.asal_sekolah) {
    redirect("/lengkapi-profil");
  }

  const latestResult = await prisma.riasecResult.findFirst({
    where: { userId: user.id },
    orderBy: { createdAt: "desc" },
  });

  let top3: Array<{ code: string; label: string; desc: string; score: number }> = [];

  if (latestResult) {
    const scores = [
      { code: "R", label: "Realistic (Praktis)", desc: "Menyukai aktivitas fisik, mesin, dan praktik.", score: latestResult.skorR },
      { code: "I", label: "Investigative (Pemikir)", desc: "Gemar mengamati, menganalisis, dan sains.", score: latestResult.skorI },
      { code: "A", label: "Artistic (Kreatif)", desc: "Ekspresif, kreatif, dan seni visual.", score: latestResult.skorA },
      { code: "S", label: "Social (Penolong)", desc: "Senang membantu dan mengajar sesama.", score: latestResult.skorS },
      { code: "E", label: "Enterprising (Pemimpin)", desc: "Memengaruhi orang lain dan berjiwa kepemimpinan.", score: latestResult.skorE },
      { code: "C", label: "Conventional (Teratur)", desc: "Menyukai data, rapi, dan terstruktur.", score: latestResult.skorC },
    ];

    scores.sort((a, b) => b.score - a.score);
    top3 = scores.slice(0, 3);
  }

  return (
    <div className="min-h-screen bg-slate-50 pb-24 max-w-md mx-auto relative shadow-2xl">
      {/* Header Banner */}
      <div className="bg-gradient-to-br from-purple-700 via-indigo-600 to-blue-600 p-6 pt-10 text-white rounded-b-3xl shadow-lg relative overflow-hidden">
        <div className="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
        <div className="flex items-center justify-between mb-4">
          <div>
            <p className="text-xs text-purple-200 uppercase font-bold tracking-wider">
              {user.jenjang === "smk" ? "Siswa SMK" : "Siswa SMP/MTs"}
            </p>
            <h1 className="text-2xl font-extrabold">Halo, {user.name.split(" ")[0]}! 👋</h1>
          </div>
          <div className="w-12 h-12 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center font-bold text-xl border border-white/30">
            🎓
          </div>
        </div>
        <p className="text-xs text-purple-100 font-medium">
          {user.asal_sekolah} • {user.provinsi}
        </p>
      </div>

      <div className="p-4 space-y-5">
        {/* Assessment Card */}
        <div className="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
          <div className="flex items-start justify-between mb-3">
            <div>
              <span className="text-[10px] font-extrabold uppercase px-2.5 py-1 bg-purple-100 text-purple-700 rounded-full">
                Tes Minat Bakat
              </span>
              <h2 className="text-base font-extrabold text-slate-800 mt-2">Asesmen Holland RIASEC</h2>
            </div>
            {latestResult ? (
              <CheckCircle className="w-6 h-6 text-emerald-500" />
            ) : (
              <Sparkles className="w-6 h-6 text-purple-500 animate-pulse" />
            )}
          </div>

          <p className="text-xs text-slate-500 mb-4 leading-relaxed">
            {latestResult
              ? "Kamu telah menyelesaikan tes RIASEC. Kamu dapat melihat hasil dan rekomendasi jurusan kapan saja."
              : "Jawab pertanyaan singkat untuk menemukan tipe kepribadian dan jurusan vokasi yang pas buatmu!"}
          </p>

          <Link
            href="/assessment"
            className="w-full inline-flex items-center justify-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-xl text-xs shadow-md shadow-purple-200 transition-all"
          >
            {latestResult ? "Lihat / Ulangi Tes RIASEC" : "Mulai Tes RIASEC"} <ArrowRight className="w-4 h-4" />
          </Link>
        </div>

        {/* RIASEC Top 3 Results */}
        {latestResult && top3.length > 0 && (
          <div className="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm space-y-3">
            <div className="flex items-center gap-2 text-slate-800 font-extrabold text-sm">
              <Award className="w-5 h-5 text-amber-500" />
              <h3>Top 3 Minat Dominanmu</h3>
            </div>

            <div className="grid grid-cols-3 gap-2">
              {top3.map((item, idx) => (
                <div
                  key={item.code}
                  className="bg-slate-50 border border-slate-100 p-3 rounded-xl text-center flex flex-col justify-between"
                >
                  <span className="text-xs font-black text-purple-600">#{idx + 1}</span>
                  <span className="text-lg font-black text-slate-800">{item.code}</span>
                  <span className="text-[10px] text-slate-500 font-bold truncate">{item.label.split(" ")[0]}</span>
                </div>
              ))}
            </div>

            <Link
              href="/rekomendasi"
              className="inline-flex items-center justify-center gap-1.5 text-purple-600 font-bold text-xs hover:underline mt-2"
            >
              Lihat Rekomendasi Jurusan Lengkap <ArrowRight className="w-3.5 h-3.5" />
            </Link>
          </div>
        )}
      </div>

      <BottomNav />
    </div>
  );
}
