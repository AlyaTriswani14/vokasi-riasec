import Link from "next/link";
import { redirect } from "next/navigation";
import { getSession } from "@/lib/auth";
import BottomNav from "@/components/BottomNav";
import { Compass, ArrowRight, Laptop, Wrench, Palette, HeartHandshake, Briefcase, Calculator } from "lucide-react";

export default async function EksplorasiPage() {
  const user = await getSession();
  if (!user) redirect("/login");

  const bidangList = [
    { slug: "teknologi-informasi", title: "Teknologi Informasi & Komputer", icon: Laptop, color: "from-blue-500 to-indigo-600", count: "12 Jurusan" },
    { slug: "teknik-manufaktur", title: "Teknologi & Rekayasa Teknik", icon: Wrench, color: "from-orange-500 to-amber-600", count: "18 Jurusan" },
    { slug: "seni-ekonomi-kreatif", title: "Seni & Ekonomi Kreatif", icon: Palette, color: "from-pink-500 to-rose-600", count: "10 Jurusan" },
    { slug: "kesehatan-pekerjaan-sosial", title: "Kesehatan & Pekerjaan Sosial", icon: HeartHandshake, color: "from-emerald-500 to-teal-600", count: "8 Jurusan" },
    { slug: "bisnis-manajemen", title: "Bisnis & Manajemen Perkantoran", icon: Briefcase, color: "from-purple-500 to-violet-600", count: "9 Jurusan" },
    { slug: "akuntansi-keuangan", title: "Akuntansi & Keuangan Lembaga", icon: Calculator, color: "from-cyan-500 to-blue-600", count: "6 Jurusan" },
  ];

  return (
    <div className="min-h-screen bg-slate-50 pb-24 max-w-md mx-auto relative shadow-2xl">
      <div className="bg-gradient-to-br from-indigo-800 to-purple-800 p-6 pt-10 text-white rounded-b-3xl">
        <h1 className="text-2xl font-extrabold flex items-center gap-2">
          <Compass className="w-6 h-6 text-[#4CD9C0]" /> Eksplorasi Vokasi
        </h1>
        <p className="text-xs text-purple-200 mt-1">
          Jelajahi berbagai keahlian & jurusan SMK masa depan yang sesuai dengan minatmu.
        </p>
      </div>

      <div className="p-4 space-y-3">
        {bidangList.map((item) => {
          const Icon = item.icon;
          return (
            <Link
              key={item.slug}
              href={`/jurusan/${item.slug}`}
              className="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between hover:shadow-md transition-all group"
            >
              <div className="flex items-center gap-3">
                <div className={`w-12 h-12 rounded-xl bg-gradient-to-br ${item.color} text-white flex items-center justify-center shadow-md`}>
                  <Icon className="w-6 h-6" />
                </div>
                <div>
                  <h3 className="font-extrabold text-slate-800 text-xs group-hover:text-purple-600 transition-colors">
                    {item.title}
                  </h3>
                  <span className="text-[10px] text-slate-400 font-bold">{item.count}</span>
                </div>
              </div>
              <ArrowRight className="w-4 h-4 text-slate-400 group-hover:translate-x-1 transition-transform" />
            </Link>
          );
        })}
      </div>

      <BottomNav />
    </div>
  );
}
