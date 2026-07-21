import Link from "next/link";
import { ArrowRight, GraduationCap } from "lucide-react";

export default function LandingPage() {
  return (
    <main className="font-sans min-h-screen flex items-center justify-center p-6 relative overflow-hidden bg-gradient-to-br from-[#6C4CF1] via-[#A34CF1] to-[#F1533D]">
      {/* Background Decorative Circles */}
      <div className="absolute w-72 h-72 bg-white/10 rounded-full -top-16 -right-10 pointer-events-none"></div>
      <div className="absolute w-56 h-56 bg-white/10 rounded-full top-1/3 -left-16 pointer-events-none"></div>
      <div className="absolute w-40 h-40 bg-white/10 rounded-full bottom-10 right-1/4 pointer-events-none"></div>

      <div className="relative z-10 w-full max-w-md text-center text-white">
        <div className="bg-white/15 backdrop-blur-md w-16 h-16 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-8 shadow-inner border border-white/20">
          🎓
        </div>

        <p className="text-xs font-bold uppercase tracking-widest text-white/80 mb-4">
          Asesmen Holland RIASEC
        </p>
        <h1 className="text-4xl md:text-5xl font-extrabold leading-tight mb-5">
          Yuk, temukan<br />jalan serumu!
        </h1>
        <p className="text-white/90 text-sm md:text-base leading-relaxed mb-10 max-w-sm mx-auto">
          Kenali minat & bakatmu lewat tes seru, dapatkan rekomendasi jurusan yang paling cocok buat masa depanmu.
        </p>

        <div className="flex items-center justify-center -space-x-3 mb-8">
          <div className="w-10 h-10 rounded-full bg-[#FFD166] border-2 border-white flex items-center justify-center text-base shadow-sm">🧑</div>
          <div className="w-10 h-10 rounded-full bg-[#4CD9C0] border-2 border-white flex items-center justify-center text-base shadow-sm">👩</div>
          <div className="w-10 h-10 rounded-full bg-[#FF7A9E] border-2 border-white flex items-center justify-center text-base shadow-sm">🧑‍🎤</div>
          <div className="w-10 h-10 rounded-full bg-white/25 border-2 border-white flex items-center justify-center text-[11px] font-bold shadow-sm">12K+</div>
        </div>

        <Link
          href="/mulai"
          className="inline-flex items-center justify-center gap-2 bg-white text-[#6C4CF1] font-bold text-sm py-4 px-10 rounded-2xl shadow-xl hover:bg-slate-50 hover:scale-105 active:scale-95 transition-all duration-200"
        >
          Mulai Sekarang <ArrowRight className="w-4 h-4" />
        </Link>

        <div className="mt-8">
          <Link href="/pilih-admin" className="text-xs text-white/70 hover:text-white underline underline-offset-4 font-medium transition-colors">
            Masuk sebagai Admin Guru BK / Kemendikdasmen
          </Link>
        </div>
      </div>
    </main>
  );
}
