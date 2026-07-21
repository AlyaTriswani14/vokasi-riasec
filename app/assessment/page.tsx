import Link from "next/link";
import { redirect } from "next/navigation";
import { getSession } from "@/lib/auth";
import { prisma } from "@/lib/prisma";
import BottomNav from "@/components/BottomNav";
import { FileText, Clock, CheckCircle2, ArrowRight } from "lucide-react";

export default async function AssessmentGuidePage() {
  const user = await getSession();

  if (!user) redirect("/login");

  const latestResult = await prisma.riasecResult.findFirst({
    where: { userId: user.id },
  });

  const durasiSetting = await prisma.pengaturan.findUnique({
    where: { kunci: "durasi_tes_menit" },
  });

  const durasiMenit = parseInt(durasiSetting?.nilai || "5", 10);

  return (
    <div className="min-h-screen bg-slate-50 pb-24 max-w-md mx-auto relative shadow-2xl">
      <div className="bg-gradient-to-r from-purple-600 to-indigo-600 p-6 pt-10 text-white rounded-b-3xl">
        <h1 className="text-2xl font-extrabold flex items-center gap-2">
          <FileText className="w-6 h-6" /> Tes RIASEC
        </h1>
        <p className="text-xs text-purple-100 mt-1">
          Panduan pelaksanaan tes kecocokan minat & bakat.
        </p>
      </div>

      <div className="p-4 space-y-4">
        <div className="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-4">
          <div className="flex items-center gap-3 bg-amber-50 text-amber-900 p-3 rounded-xl border border-amber-200">
            <Clock className="w-6 h-6 text-amber-600 shrink-0" />
            <div className="text-xs">
              <span className="font-bold block text-sm">Durasi Tes: {durasiMenit} Menit</span>
              Timer akan otomatis berjalan setelah kamu menekan tombol Mulai.
            </div>
          </div>

          <h3 className="font-extrabold text-slate-800 text-sm">Petunjuk Pengisian:</h3>
          <ul className="text-xs text-slate-600 space-y-2">
            <li className="flex items-start gap-2">
              <CheckCircle2 className="w-4 h-4 text-purple-600 shrink-0 mt-0.5" />
              <span>Pilih &quot;YA&quot; pada setiap pernyataan yang sesuai dengan kepribadian atau kesukaanmu.</span>
            </li>
            <li className="flex items-start gap-2">
              <CheckCircle2 className="w-4 h-4 text-purple-600 shrink-0 mt-0.5" />
              <span>Jawab secara jujur sesuai diri sendiri tanpa dipengaruhi orang lain.</span>
            </li>
            <li className="flex items-start gap-2">
              <CheckCircle2 className="w-4 h-4 text-purple-600 shrink-0 mt-0.5" />
              <span>Hasil tes akan langsung mengelompokkan 3 tipe RIASEC dominanmu.</span>
            </li>
          </ul>

          <Link
            href="/assessment/questions"
            className="w-full inline-flex items-center justify-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3.5 px-4 rounded-xl text-sm shadow-lg shadow-purple-200 transition-all mt-4"
          >
            {latestResult ? "Ulangi Tes Sekarang" : "Mulai Tes Sekarang"} <ArrowRight className="w-4 h-4" />
          </Link>
        </div>
      </div>

      <BottomNav />
    </div>
  );
}
