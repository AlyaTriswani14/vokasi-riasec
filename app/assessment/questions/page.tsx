"use client";

import { useState, useEffect } from "react";
import { useRouter } from "next/navigation";
import { Clock } from "lucide-react";
import { getJenjangTheme } from "@/lib/theme";

interface Soal {
  id: number;
  pernyataan: string;
  aspek: string;
  urutan: number;
}

export default function QuestionsPage() {
  const router = useRouter();

  const [jenjang, setJenjang] = useState<string | null | undefined>(undefined);
  const [soalList, setSoalList] = useState<Soal[]>([]);
  const [durasiMenit, setDurasiMenit] = useState<number>(5);
  const [timeLeft, setTimeLeft] = useState<number>(0);
  const [jawaban, setJawaban] = useState<number[]>([]);
  const [current, setCurrent] = useState(0); // index of question currently shown
  const [loading, setLoading] = useState(true);
  const [submitting, setSubmitting] = useState(false);
  const [error, setError] = useState("");

  const theme = getJenjangTheme(jenjang);

  useEffect(() => {
    fetch("/api/auth/session")
      .then((res) => res.json())
      .then((data) => setJenjang(data?.user?.jenjang ?? null))
      .catch(() => setJenjang(null));

    fetch("/api/assessment/questions")
      .then((res) => res.json())
      .then((data) => {
        if (data.error) {
          setError(data.error);
        } else {
          setSoalList(data.soalList || []);
          const minutes = data.durasiMenit || 5;
          setDurasiMenit(minutes);
          setTimeLeft(minutes * 60);
        }
      })
      .catch(() => setError("Gagal memuat soal tes."))
      .finally(() => setLoading(false));
  }, []);

  useEffect(() => {
    if (loading || error || timeLeft <= 0 || submitting) return;

    const timer = setInterval(() => {
      setTimeLeft((prev) => {
        if (prev <= 1) {
          clearInterval(timer);
          handleSubmit();
          return 0;
        }
        return prev - 1;
      });
    }, 1000);

    return () => clearInterval(timer);
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [loading, error, submitting]);

  const handleSubmit = async (finalJawaban?: number[]) => {
    if (submitting) return;
    setSubmitting(true);

    try {
      const res = await fetch("/api/assessment/submit", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ jawaban: finalJawaban ?? jawaban }),
      });

      if (!res.ok) {
        throw new Error("Gagal mengirim hasil tes.");
      }

      router.push("/assessment/result");
    } catch (err: any) {
      setError(err.message);
      setSubmitting(false);
    }
  };

  const answer = (soalId: number, isYes: boolean) => {
    const next = isYes ? [...jawaban, soalId] : jawaban;
    setJawaban(next);

    if (current + 1 < soalList.length) {
      setCurrent(current + 1);
    } else {
      handleSubmit(next);
    }
  };

  const minutes = Math.floor(timeLeft / 60);
  const seconds = timeLeft % 60;
  const timerLow = timeLeft <= 30;
  const totalSoal = soalList.length;
  const progressPct = totalSoal > 0 ? ((current + 1) / totalSoal) * 100 : 0;

  if (loading) {
    return (
      <main className="min-h-screen bg-[#f8fafc] flex items-center justify-center p-4">
        <div className="text-center text-gray-500 font-medium">Memuat soal tes...</div>
      </main>
    );
  }

  if (error) {
    return (
      <main className="min-h-screen bg-[#f8fafc] flex items-center justify-center p-4">
        <div className="bg-rose-50 text-rose-600 p-4 rounded-xl text-center text-sm border border-rose-200 max-w-md">{error}</div>
      </main>
    );
  }

  const soal = soalList[current];

  return (
    <main className="min-h-screen bg-[#f8fafc] max-w-xl mx-auto px-4 w-full flex flex-col justify-center py-8">
      {/* Progress + timer */}
      <div className="mb-6 w-full">
        <div className="flex justify-center mb-4">
          <div
            className={`font-extrabold text-2xl flex items-center gap-2 px-5 py-2 rounded-full ${
              timerLow ? "bg-red-50 text-red-500" : `${theme.accentBg} ${theme.accentText}`
            }`}
          >
            <Clock className="w-5 h-5" />
            <span>
              {String(minutes).padStart(2, "0")}:{String(seconds).padStart(2, "0")}
            </span>
          </div>
        </div>
        <div className={`flex justify-between text-xs font-bold ${theme.accentText} mb-2`}>
          <span>Progress Tes</span>
          <span>
            Soal {current + 1} dari {totalSoal}
          </span>
        </div>
        <div className="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
          <div
            className="h-2.5 rounded-full transition-all duration-300"
            style={{ width: `${progressPct}%`, ...theme.gradientBarStyle }}
          />
        </div>
      </div>

      {soal && (
        <div className={`bg-white p-8 rounded-3xl shadow-lg border ${theme.accentBorder} text-center relative overflow-hidden`}>
          <div className="absolute w-24 h-24 rounded-full -top-8 -right-8 opacity-10" style={theme.gradientStyle} />

          <div className="relative z-10">
            <span
              className={`inline-block ${theme.accentText} text-[11px] font-extrabold uppercase tracking-widest px-3 py-1 rounded-full ${theme.accentBg}`}
            >
              Pertanyaan {current + 1}
            </span>
            <h2 className="text-2xl md:text-3xl font-extrabold text-gray-800 mt-5 mb-10 leading-snug">{soal.pernyataan}</h2>

            <div className="grid grid-cols-2 gap-4">
              <button
                type="button"
                onClick={() => answer(soal.id, true)}
                disabled={submitting}
                className="text-white py-4 rounded-2xl font-bold text-lg transition-transform active:scale-95 shadow-md disabled:opacity-60"
                style={theme.gradientStyle}
              >
                YA
              </button>
              <button
                type="button"
                onClick={() => answer(soal.id, false)}
                disabled={submitting}
                className="bg-white text-gray-400 border-2 border-gray-200 py-4 rounded-2xl font-bold text-lg hover:bg-gray-50 transition-transform active:scale-95 disabled:opacity-60"
              >
                TIDAK
              </button>
            </div>
          </div>
        </div>
      )}
    </main>
  );
}
