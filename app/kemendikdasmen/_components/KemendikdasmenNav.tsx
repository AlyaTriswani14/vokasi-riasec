"use client";

import { useEffect, useState } from "react";
import Link from "next/link";
import { useRouter } from "next/navigation";
import { GraduationCap, LogOut } from "lucide-react";

const TABS = [
  { key: "dashboard", label: "Dashboard", href: "/kemendikdasmen/dashboard" },
  { key: "users", label: "Manajemen Sekolah", href: "/kemendikdasmen/users" },
  { key: "questions", label: "Bank Soal", href: "/kemendikdasmen/questions" },
  { key: "settings", label: "Pengaturan", href: "/kemendikdasmen/settings" },
  { key: "broadcast", label: "Broadcast", href: "/kemendikdasmen/broadcast" },
];

interface KemendikdasmenNavProps {
  active: "dashboard" | "users" | "questions" | "settings" | "broadcast";
  userName?: string;
}

export default function KemendikdasmenNav({ active, userName }: KemendikdasmenNavProps) {
  const router = useRouter();
  const [name, setName] = useState(userName || "");

  useEffect(() => {
    if (userName) return;
    fetch("/api/auth/session")
      .then((res) => res.json())
      .then((data) => {
        if (data?.user?.name) setName(data.user.name);
      })
      .catch(() => {});
  }, [userName]);

  const handleLogout = async (e: React.FormEvent) => {
    e.preventDefault();
    await fetch("/api/auth/logout", { method: "POST" });
    router.push("/kemendikdasmen/login");
  };

  return (
    <div className="sticky top-0 z-50">
      <div className="w-full flex justify-between items-center p-4 md:px-8 bg-white border-b border-slate-100 shadow-sm">
        <div className="flex items-center gap-2 text-[#003366] font-bold text-lg">
          <GraduationCap className="w-5 h-5" /> <span>Bakat Minat</span>
        </div>
        <div className="flex items-center gap-4">
          <div className="text-right hidden sm:block">
            <p className="text-xs font-bold text-slate-700">{name}</p>
            <p className="text-[10px] text-slate-400">Admin Direktorat SMK</p>
          </div>
          <form onSubmit={handleLogout}>
            <button
              type="submit"
              className="w-9 h-9 rounded-full bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100 transition-colors"
              title="Logout"
            >
              <LogOut className="w-4 h-4" />
            </button>
          </form>
        </div>
      </div>

      <div className="w-full bg-[#003366] overflow-x-auto">
        <div className="max-w-6xl mx-auto flex gap-1 px-4">
          {TABS.map((tab) => (
            <Link
              key={tab.key}
              href={tab.href}
              className={
                tab.key === active
                  ? "text-white text-xs font-bold px-4 py-3 border-b-2 border-white whitespace-nowrap"
                  : "text-white/60 hover:text-white text-xs font-bold px-4 py-3 border-b-2 border-transparent whitespace-nowrap transition-colors"
              }
            >
              {tab.label}
            </Link>
          ))}
        </div>
      </div>
    </div>
  );
}
