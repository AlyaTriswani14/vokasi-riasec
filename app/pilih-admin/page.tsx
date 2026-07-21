import Link from "next/link";
import { GraduationCap, School, Building2, ArrowLeft } from "lucide-react";

export default function PilihAdminPage() {
  return (
    <main className="bg-[#f8fafc] font-sans text-gray-800 min-h-screen flex items-center justify-center relative overflow-x-hidden py-10">
      <div className="absolute w-72 h-72 bg-[#0f766e]/10 rounded-full -top-16 -left-16 pointer-events-none"></div>
      <div className="absolute w-64 h-64 bg-[#003366]/10 rounded-full -bottom-10 -right-10 pointer-events-none"></div>

      <div className="w-full max-w-xl relative z-10 px-4">
        <div className="flex items-center justify-center gap-2 text-[#003366] font-bold text-xl mb-8">
          <GraduationCap className="w-7 h-7" /> <span>Bakat Minat Vokasi</span>
        </div>

        <div className="bg-white rounded-3xl shadow-lg p-8 text-center border border-slate-100">
          <span className="inline-block bg-[#003366] text-white text-[10px] font-bold px-3 py-1.5 rounded-full mb-4">
            MASUK SEBAGAI ADMIN
          </span>
          <h1 className="text-xl font-extrabold text-gray-800 mb-2">Kamu masuk sebagai apa?</h1>
          <p className="text-sm text-gray-500 mb-8">Pilih salah satu sesuai peranmu.</p>

          <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <Link
              href="/guru-bk/login"
              className="group rounded-2xl p-6 text-white text-left shadow-md hover:scale-[1.02] active:scale-98 transition-transform bg-gradient-to-br from-[#0f766e] to-[#14b8a6]"
            >
              <School className="w-8 h-8 mb-3" />
              <h3 className="font-bold text-base mb-1">Admin Sekolah</h3>
              <p className="text-xs text-white/85">Guru BK, pantau siswa bina di sekolahmu.</p>
            </Link>

            <Link
              href="/kemendikdasmen/login"
              className="group rounded-2xl p-6 text-white text-left shadow-md hover:scale-[1.02] active:scale-98 transition-transform bg-gradient-to-br from-[#003366] to-[#0d3f70]"
            >
              <Building2 className="w-8 h-8 mb-3" />
              <h3 className="font-bold text-base mb-1">Admin Direktorat SMK</h3>
              <p className="text-xs text-white/85">Kelola platform secara keseluruhan.</p>
            </Link>
          </div>

          <Link
            href="/mulai"
            className="inline-flex items-center gap-1 text-xs font-bold text-gray-400 hover:text-gray-600 mt-8 transition-colors"
          >
            <ArrowLeft className="w-3.5 h-3.5" /> Kembali
          </Link>
        </div>
      </div>
    </main>
  );
}
