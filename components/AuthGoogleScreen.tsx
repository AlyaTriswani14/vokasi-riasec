"use client";

import { Suspense } from "react";
import { useSearchParams } from "next/navigation";
import Link from "next/link";
import { GraduationCap } from "lucide-react";

function GoogleIcon() {
  return (
    <svg className="w-5 h-5" viewBox="0 0 48 48">
      <path
        fill="#FFC107"
        d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 12.955 4 4 12.955 4 24s8.955 20 20 20 20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"
      />
      <path
        fill="#FF3D00"
        d="M6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 16.318 4 9.656 8.337 6.306 14.691z"
      />
      <path
        fill="#4CAF50"
        d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238C29.211 35.091 26.715 36 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z"
      />
      <path
        fill="#1976D2"
        d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 01-4.087 5.571l.003-.002 6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z"
      />
    </svg>
  );
}

function AuthForm() {
  const searchParams = useSearchParams();
  const jenjang = searchParams.get("jenjang") === "smk" ? "smk" : "smp";
  const error = searchParams.get("error");

  return (
    <div className="w-full md:w-1/2 flex items-center justify-center p-8 relative overflow-hidden bg-gradient-to-br from-orange-50 via-white to-blue-50">
      <div className="absolute w-64 h-64 bg-gradient-to-br from-[#7C3AED] to-[#EC4899] opacity-10 rounded-full -top-10 -right-16" />
      <div className="absolute w-64 h-64 bg-gradient-to-br from-[#22C1C3] to-[#2F6FED] opacity-10 rounded-full -bottom-16 -left-10" />

      <div className="relative z-10 bg-white w-full max-w-[420px] rounded-[30px] shadow-xl p-10 border border-slate-100">
        <div className="flex items-center gap-2 mb-6">
          <div className="w-10 h-1.5 rounded-full bg-gradient-to-r from-[#7C3AED] to-[#EC4899]" />
          <div className="w-10 h-1.5 rounded-full bg-gradient-to-r from-[#7C3AED] to-[#EC4899]" />
          <div className="w-10 h-1.5 rounded-full bg-gray-200" />
        </div>

        <div className="mb-6">
          <span
            className={`inline-block text-[10px] font-bold uppercase tracking-widest text-white px-4 py-1.5 rounded-full ${
              jenjang === "smk"
                ? "bg-gradient-to-r from-[#2F6FED] to-[#22C1C3]"
                : "bg-gradient-to-r from-[#FF7A45] to-[#FFB13D]"
            }`}
          >
            Jenjang {jenjang.toUpperCase()} · Langkah 2 dari 3
          </span>
        </div>

        <div className="mb-8">
          <h2 className="text-2xl font-extrabold text-[#0F355C] mb-2">Daftar atau Masuk</h2>
          <p className="text-xs text-slate-500">
            Satu akun Google untuk daftar sekaligus masuk lain waktu, tidak perlu ingat password.
          </p>
        </div>

        {error && (
          <div className="mb-5 bg-red-50 border border-red-200 text-red-600 text-xs rounded-xl p-3">
            <p>Gagal masuk dengan Google. Silakan coba lagi.</p>
          </div>
        )}

        <a
          href={`/auth/google/redirect?jenjang=${jenjang}`}
          className="w-full bg-white border-2 border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-bold py-3.5 rounded-xl flex items-center justify-center gap-3 transition duration-300"
        >
          <GoogleIcon />
          <span>Daftar / Masuk dengan Google</span>
        </a>

        <p className="text-[10px] text-slate-400 text-center leading-relaxed mt-5">
          Dengan melanjutkan, kamu menyetujui data akun Google (nama & email) digunakan untuk keperluan asesmen ini.
        </p>

        <div className="text-center pt-6 mt-6 border-t border-slate-100">
          <Link href="/mulai" className="text-xs font-bold text-[#008073] hover:text-[#005c52] tracking-wider transition">
            &larr; Ganti jenjang
          </Link>
        </div>
      </div>
    </div>
  );
}

export default function AuthGoogleScreen() {
  return (
    <main className="bg-gray-50 text-slate-800 min-h-screen flex">
      <div className="hidden md:flex md:w-1/2 bg-[#0F355C] text-white p-12 flex-col justify-between relative overflow-hidden">
        <div className="absolute w-64 h-64 bg-gradient-to-br from-[#EC4899] to-[#7C3AED] opacity-30 rounded-full -top-10 -right-10 blur-2xl" />
        <div className="absolute w-64 h-64 bg-gradient-to-br from-[#22C1C3] to-[#2F6FED] opacity-30 rounded-full bottom-10 -left-16 blur-2xl" />
        <div className="relative z-10">
          <div className="bg-white text-black p-3 rounded-xl inline-flex items-center gap-2 mb-10">
            <GraduationCap className="w-6 h-6" />
            <span className="font-bold text-sm">Direktorat Vokasi</span>
          </div>
          <h1 className="text-4xl lg:text-5xl font-extrabold leading-tight mb-6">
            Pilih Jalanmu, Tentukan Masa Depan Pendidikanmu.
          </h1>
          <p className="text-slate-300 text-base max-w-md">
            Platform Interaktif Pemetaan Minat, Bakat, dan Perencanaan Karier bagi Siswa Vokasi di Indonesia.
          </p>
        </div>
        <div className="relative z-10 text-xs text-slate-400">&copy; 2026 Tim Peserta Didik Direktorat SMK.</div>
      </div>

      <Suspense fallback={<div className="w-full flex items-center justify-center p-4 text-slate-500">Loading...</div>}>
        <AuthForm />
      </Suspense>
    </main>
  );
}
