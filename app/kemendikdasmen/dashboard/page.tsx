import Link from "next/link";
import { redirect } from "next/navigation";
import { getSession } from "@/lib/auth";
import { prisma } from "@/lib/prisma";
import { Building2, Users, FileQuestion, Settings, Radio, LogOut, School, CheckCircle, BarChart3 } from "lucide-react";

export default async function KemendikdasmenDashboardPage() {
  const user = await getSession();
  if (!user || user.role !== "kemendikdasmen") {
    redirect("/kemendikdasmen/login");
  }

  const totalGuruBk = await prisma.user.count({ where: { role: "guru_bk" } });
  const totalSiswa = await prisma.user.count({ where: { role: "siswa" } });
  const totalTes = await prisma.riasecResult.count();
  const totalSoal = await prisma.soalRiasec.count();

  return (
    <div className="min-h-screen bg-slate-50 p-4 md:p-8">
      <div className="max-w-6xl mx-auto space-y-6">
        {/* Top Navigation */}
        <div className="bg-[#003366] text-white p-6 rounded-3xl shadow-lg flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div>
            <div className="flex items-center gap-2 font-bold text-xs text-blue-200 uppercase tracking-widest mb-1">
              <Building2 className="w-4 h-4" /> Direktorat SMK - Kemendikdasmen RI
            </div>
            <h1 className="text-xl font-black">Dashboard Pusat Sistem RIASEC Vokasi</h1>
            <p className="text-xs text-blue-100 mt-0.5">Pengelolaan Nasional Tes Minat Bakat Vokasi</p>
          </div>

          <form action="/api/auth/logout" method="POST">
            <button
              type="submit"
              className="inline-flex items-center gap-1.5 bg-white/10 hover:bg-white/20 text-white font-bold text-xs px-4 py-2 rounded-xl border border-white/20 transition-all"
            >
              <LogOut className="w-3.5 h-3.5" /> Logout
            </button>
          </form>
        </div>

        {/* System Stats Overview */}
        <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div className="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <School className="w-5 h-5 text-teal-600 mb-2" />
            <p className="text-[10px] font-bold uppercase text-slate-400">Total Sekolah / Guru BK</p>
            <h3 className="text-2xl font-black text-slate-800">{totalGuruBk}</h3>
          </div>

          <div className="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <Users className="w-5 h-5 text-blue-600 mb-2" />
            <p className="text-[10px] font-bold uppercase text-slate-400">Total Siswa Terdaftar</p>
            <h3 className="text-2xl font-black text-slate-800">{totalSiswa}</h3>
          </div>

          <div className="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <CheckCircle className="w-5 h-5 text-emerald-600 mb-2" />
            <p className="text-[10px] font-bold uppercase text-slate-400">Total Tes Selesai</p>
            <h3 className="text-2xl font-black text-slate-800">{totalTes}</h3>
          </div>

          <div className="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <FileQuestion className="w-5 h-5 text-purple-600 mb-2" />
            <p className="text-[10px] font-bold uppercase text-slate-400">Bank Soal RIASEC</p>
            <h3 className="text-2xl font-black text-slate-800">{totalSoal} Soal</h3>
          </div>
        </div>

        {/* Core Modules Grid */}
        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
          <Link
            href="/kemendikdasmen/users"
            className="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all group"
          >
            <div className="w-12 h-12 rounded-2xl bg-teal-100 text-teal-700 flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
              <School className="w-6 h-6" />
            </div>
            <h3 className="font-extrabold text-slate-800 text-sm mb-1 group-hover:text-blue-600 transition-colors">
              User Management
            </h3>
            <p className="text-xs text-slate-500">Kelola akun Guru BK dan sekolah binaan nasional.</p>
          </Link>

          <Link
            href="/kemendikdasmen/questions"
            className="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all group"
          >
            <div className="w-12 h-12 rounded-2xl bg-purple-100 text-purple-700 flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
              <FileQuestion className="w-6 h-6" />
            </div>
            <h3 className="font-extrabold text-slate-800 text-sm mb-1 group-hover:text-purple-600 transition-colors">
              Bank Soal RIASEC
            </h3>
            <p className="text-xs text-slate-500">Kelola butir soal, aspek R-I-A-S-E-C, & import CSV.</p>
          </Link>

          <Link
            href="/kemendikdasmen/settings"
            className="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all group"
          >
            <div className="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
              <Settings className="w-6 h-6" />
            </div>
            <h3 className="font-extrabold text-slate-800 text-sm mb-1 group-hover:text-amber-600 transition-colors">
              Pengaturan Sistem
            </h3>
            <p className="text-xs text-slate-500">Atur durasi timer tes, kuota nasional, & status sistem.</p>
          </Link>

          <Link
            href="/kemendikdasmen/broadcast"
            className="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all group"
          >
            <div className="w-12 h-12 rounded-2xl bg-rose-100 text-rose-700 flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
              <Radio className="w-6 h-6" />
            </div>
            <h3 className="font-extrabold text-slate-800 text-sm mb-1 group-hover:text-rose-600 transition-colors">
              Broadcast Center
            </h3>
            <p className="text-xs text-slate-500">Kirim pengumuman massal ke siswa & Guru BK.</p>
          </Link>
        </div>
      </div>
    </div>
  );
}
