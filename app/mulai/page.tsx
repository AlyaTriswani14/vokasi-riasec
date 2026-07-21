import Link from "next/link";
import { GraduationCap, Wrench, Shield } from "lucide-react";

export default function MulaiPage() {
  return (
    <main className="bg-[#f8fafc] font-sans text-gray-800 min-h-screen flex items-center justify-center p-5 relative overflow-hidden">
      <div className="absolute w-72 h-72 bg-gradient-to-br from-[#7C3AED] to-[#EC4899] opacity-20 rounded-full -top-20 -left-20 pointer-events-none"></div>
      <div className="absolute w-72 h-72 bg-gradient-to-br from-[#22C1C3] to-[#2F6FED] opacity-20 rounded-full -bottom-24 -right-16 pointer-events-none"></div>

      <div className="w-full max-w-xl relative z-10">
        <div className="flex items-center justify-center gap-2 text-[#003366] font-bold text-lg mb-8">
          <GraduationCap className="w-6 h-6" />
          <span>Pilih Jalanmu</span>
        </div>

        <div className="bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 p-6 md:p-10">
          <div className="flex items-center justify-center gap-2 mb-6">
            <div className="w-10 h-1.5 rounded-full bg-gradient-to-r from-[#7C3AED] to-[#EC4899]"></div>
            <div className="w-10 h-1.5 rounded-full bg-gray-200"></div>
            <div className="w-10 h-1.5 rounded-full bg-gray-200"></div>
          </div>

          <div className="text-center mb-8">
            <p className="text-[10px] font-bold uppercase tracking-widest text-[#0f766e] bg-[#ccfbf1] inline-block px-3 py-1 rounded-full mb-3">
              Langkah 1 dari 3
            </p>
            <h1 className="text-xl md:text-2xl font-extrabold text-[#003366] mb-2">
              Kamu siswa dari jenjang apa?
            </h1>
            <p className="text-gray-500 text-sm">
              Tampilan dan rekomendasi akan disesuaikan dengan jenjangmu.
            </p>
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
            <Link
              href="/login?jenjang=smp"
              className="relative overflow-hidden rounded-[24px] p-6 flex flex-col items-center text-center gap-2 text-white shadow-lg shadow-orange-200 bg-gradient-to-br from-[#FF7A45] to-[#FFB13D] hover:scale-[1.02] active:scale-98 transition duration-200"
            >
              <div className="absolute w-24 h-24 bg-white/15 rounded-full -top-8 -right-8"></div>
              <div className="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center text-2xl mb-1 relative z-10">
                <GraduationCap className="w-8 h-8" />
              </div>
              <span className="font-extrabold text-lg relative z-10">SMP / MTs</span>
              <span className="text-xs text-white/90 relative z-10">Sekolah Menengah Pertama</span>
            </Link>

            <Link
              href="/login?jenjang=smk"
              className="relative overflow-hidden rounded-[24px] p-6 flex flex-col items-center text-center gap-2 text-white shadow-lg shadow-blue-200 bg-gradient-to-br from-[#2F6FED] to-[#22C1C3] hover:scale-[1.02] active:scale-98 transition duration-200"
            >
              <div className="absolute w-24 h-24 bg-white/15 rounded-full -top-8 -right-8"></div>
              <div className="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center text-2xl mb-1 relative z-10">
                <Wrench className="w-8 h-8" />
              </div>
              <span className="font-extrabold text-lg relative z-10">SMK</span>
              <span className="text-xs text-white/90 relative z-10">Sekolah Menengah Kejuruan</span>
            </Link>
          </div>

          <Link
            href="/pilih-admin"
            className="w-full text-center text-gray-400 hover:text-[#003366] text-xs font-bold py-3 flex items-center justify-center gap-2 border border-dashed border-gray-200 rounded-2xl transition"
          >
            <Shield className="w-4 h-4" /> Masuk sebagai Admin
          </Link>
        </div>
      </div>
    </main>
  );
}
