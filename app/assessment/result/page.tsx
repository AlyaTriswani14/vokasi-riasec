import Link from "next/link";
import { redirect } from "next/navigation";
import { getSession } from "@/lib/auth";
import { prisma } from "@/lib/prisma";
import BottomNav from "@/components/BottomNav";
import { Award, Sparkles, ArrowRight, RotateCcw } from "lucide-react";

export default async function AssessmentResultPage() {
  const user = await getSession();
  if (!user) redirect("/login");

  const latestResult = await prisma.riasecResult.findFirst({
    where: { userId: user.id },
    orderBy: { createdAt: "desc" },
  });

  if (!latestResult) {
    redirect("/assessment");
  }

  const scores = [
    { code: "R", name: "Realistic (Praktis)", desc: "Menyukai aktivitas fisik, alat perkakas, dan praktik di luar ruangan.", score: latestResult.skorR },
    { code: "I", name: "Investigative (Pemikir)", desc: "Gemar mengamati, riset, belajar, dan menganalisis masalah kompleks.", score: latestResult.skorI },
    { code: "A", name: "Artistic (Kreatif)", desc: "Jiwa ekspresif, orisinal, dan menyukai seni/kreativitas visual.", score: latestResult.skorA },
    { code: "S", name: "Social (Penolong)", desc: "Senang membantu, mengajar, dan berinteraksi dengan orang lain.", score: latestResult.skorS },
    { code: "E", name: "Enterprising (Pemimpin)", desc: "Memengaruhi orang lain, berani mengambil risiko, dan mengejar target.", score: latestResult.skorE },
    { code: "C", name: "Conventional (Teratur)", desc: "Menyukai data, angka, dan sistem yang terstruktur rapi.", score: latestResult.skorC },
  ];

  scores.sort((a, b) => b.score - a.score);
  const top3 = scores.slice(0, 3);
  const maxPossible = 5; // Total items per aspect approx

  return (
    <div className="min-h-screen bg-slate-50 pb-24 max-w-md mx-auto relative shadow-2xl">
      <div className="bg-gradient-to-br from-purple-700 to-indigo-700 p-6 pt-10 text-white rounded-b-3xl text-center">
        <div className="w-14 h-14 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mx-auto mb-3 text-2xl border border-white/30">
          🏆
        </div>
        <h1 className="text-2xl font-extrabold">Hasil Asesmen RIASEC</h1>
        <p className="text-xs text-purple-200 mt-1">
          Berikut adalah 3 profil kepribadian Holland paling dominan padamu:
        </p>
      </div>

      <div className="p-4 space-y-4">
        {/* Top 3 Cards */}
        <div className="space-y-3">
          {top3.map((item, index) => (
            <div
              key={item.code}
              className="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm relative overflow-hidden"
            >
              <div className="flex items-center justify-between mb-2">
                <div className="flex items-center gap-2">
                  <span className="w-7 h-7 rounded-xl bg-purple-100 text-purple-700 font-black text-xs flex items-center justify-center">
                    #{index + 1}
                  </span>
                  <h3 className="font-extrabold text-slate-800 text-sm">{item.name}</h3>
                </div>
                <span className="text-xs font-bold text-purple-600 bg-purple-50 px-2.5 py-1 rounded-full border border-purple-100">
                  {item.score} Poin
                </span>
              </div>
              <p className="text-xs text-slate-500 leading-relaxed mb-3">{item.desc}</p>
            </div>
          ))}
        </div>

        {/* Action Buttons */}
        <div className="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-3">
          <Link
            href="/rekomendasi"
            className="w-full inline-flex items-center justify-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3.5 px-4 rounded-xl text-xs shadow-md shadow-purple-200 transition-all"
          >
            Lihat Rekomendasi Jurusan & SMK Terdekat <ArrowRight className="w-4 h-4" />
          </Link>

          <Link
            href="/assessment/questions"
            className="w-full inline-flex items-center justify-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3 px-4 rounded-xl text-xs transition-all"
          >
            <RotateCcw className="w-3.5 h-3.5" /> Ulangi Tes
          </Link>
        </div>
      </div>

      <BottomNav />
    </div>
  );
}
