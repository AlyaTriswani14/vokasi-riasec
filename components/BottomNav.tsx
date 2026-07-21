"use client";

import { useEffect, useState } from "react";
import Link from "next/link";
import { usePathname } from "next/navigation";
import { LayoutDashboard, FileText, Compass, Target, User } from "lucide-react";
import { getJenjangTheme } from "@/lib/theme";

// Order matches the original Blade bottom nav partial:
// Dashboard, Assessment, Eksplorasi, Rekomendasi, Profil.
const navItems = [
  { href: "/dashboard", label: "Dashboard", icon: LayoutDashboard },
  { href: "/assessment", label: "Assessment", icon: FileText },
  { href: "/eksplorasi", label: "Eksplorasi", icon: Compass },
  { href: "/rekomendasi", label: "Rekomendasi", icon: Target },
  { href: "/profil", label: "Profil", icon: User },
];

export default function BottomNav() {
  const pathname = usePathname();
  const [jenjang, setJenjang] = useState<string | null | undefined>(undefined);

  useEffect(() => {
    fetch("/api/auth/session")
      .then((res) => res.json())
      .then((data) => setJenjang(data?.user?.jenjang ?? null))
      .catch(() => setJenjang(null));
  }, []);

  const { accentText } = getJenjangTheme(jenjang);

  return (
    <nav className="fixed bottom-0 w-full z-50 bg-white border-t border-slate-200 shadow-[0_-4px_10px_rgba(0,0,0,0.02)] px-2 py-3 flex justify-around items-center">
      {navItems.map((item) => {
        const Icon = item.icon;
        const isActive = pathname === item.href || (item.href !== "/dashboard" && pathname.startsWith(item.href));
        return (
          <Link
            key={item.href}
            href={item.href}
            className={`flex flex-col items-center gap-1 text-[10px] font-medium transition-colors ${
              isActive ? `${accentText} font-bold` : "text-slate-400 hover:text-slate-600"
            }`}
          >
            <Icon className={`w-5 h-5 ${isActive ? "stroke-[2.5px]" : "stroke-[1.8px]"}`} />
            <span>{item.label}</span>
          </Link>
        );
      })}
    </nav>
  );
}
