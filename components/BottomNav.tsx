"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { LayoutDashboard, FileText, Compass, Sparkles, User } from "lucide-react";

export default function BottomNav() {
  const pathname = usePathname();

  const navItems = [
    { href: "/dashboard", label: "Dashboard", icon: LayoutDashboard },
    { href: "/assessment", label: "Tes RIASEC", icon: FileText },
    { href: "/rekomendasi", label: "Rekomendasi", icon: Sparkles },
    { href: "/eksplorasi", label: "Eksplorasi", icon: Compass },
    { href: "/profil", label: "Profil", icon: User },
  ];

  return (
    <nav className="fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-slate-200 shadow-lg px-4 py-2 flex justify-around items-center max-w-md mx-auto rounded-t-2xl">
      {navItems.map((item) => {
        const Icon = item.icon;
        const isActive = pathname === item.href || (item.href !== "/dashboard" && pathname.startsWith(item.href));
        return (
          <Link
            key={item.href}
            href={item.href}
            className={`flex flex-col items-center gap-1 text-xs font-medium transition-colors ${
              isActive ? "text-purple-600 font-bold" : "text-slate-500 hover:text-purple-500"
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
