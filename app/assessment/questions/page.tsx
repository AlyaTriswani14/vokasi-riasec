"use client";

import { useState, useEffect } from "react";
import { useRouter } from "next/navigation";
import { Clock, Check, Send, AlertCircle } from "lucide-react";

interface Soal {
  id: number;
  pernyataan: string;
  aspek: string;
  urutan: number;
}

export default function QuestionsPage() {
  const router = useRouter();

  const [soalList, setSoalList] = useState<Soal[]>([]);
  const [durasiMenit, setDurasiMenit] = useState<number>(5);
  const [timeLeft, setTimeLeft] = useState<number>(0);
  const [jawaban, setJawaban] = useState<number[]>([]);
  const [loading, setLoading] = useState(true);
  const [submitting, setSubmitting] = useState(false);
  const [error, setError] = useState("");

  useEffect(() => {
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
      .catch((err) => setError("Gagal memuat soal tes."))
      .finally(() => setLoading(false));
  }, []);

  useEffect(() => {
    if (timeLeft <= 0 || submitting) return;

    const timer = setInterval(() => {
      setTimeLeft((prev) => {
        if (prev <= 1) {
          clearInterval(timer);
          handleSubmit(true);
          return 0;
        }
        return prev - 1;
      });
    }, 1000);

    return () => clearInterval(timer);
  }, [timeLeft, submitting]);

  const toggleJawaban = (id: number) => {
    setJawaban((prev) =>
      prev.includes(id) ? prev.filter((item) => item !== id) : [...prev, id]
    );
  };

  const handleSubmit = async (auto = false) => {
    if (submitting) return;
    setSubmitting(true);

    try {
      const res = await fetch("/api/assessment/submit", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ jawaban }),
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

  const minutes = Math.floor(timeLeft / 60);
  const seconds = timeLeft % 60;

  if (loading) {
    return (
      <main className="min-h-screen bg-slate-50 flex items-center justify-center p-4">
        <div className="text-center text-slate-500 font-medium">Memuat soal tes...</div>
      </main>
    );
  }

  if (error) {
    return (
      <main className="min-h-screen bg-slate-50 flex items-center justify-center p-4">
        <div className="bg-rose-50 text-rose-600 p-4 rounded-xl text-center text-sm border border-rose-200 max-w-md">
          {error}
        </div>
      </main>
    );
  }

  return (
    <main className="min-h-screen bg-slate-50 pb-28 max-w-md mx-auto relative shadow-2xl">
      {/* Top Timer Bar */}
      <div className="sticky top-0 z-40 bg-white/90 backdrop-blur border-b border-slate-200 p-4 flex items-center justify-between shadow-sm">
        <div>
          <span className="text-[10px] font-bold text-slate-400 uppercase">Progres Pengisian</span>
          <p className="text-xs font-extrabold text-slate-800">
            {jawaban.length} dari {soalList.length} Dijawab YA
          </p>
        </div>

        <div className="flex items-center gap-1.5 bg-rose-50 text-rose-600 px-3 py-1.5 rounded-xl text-xs font-black border border-rose-200">
          <Clock className="w-4 h-4" />
          <span>
            {String(minutes).padStart(2, "0")}:{String(seconds).padStart(2, "0")}
          </span>
        </div>
      </div>

      <div className="p-4 space-y-3">
        <p className="text-xs text-slate-500 mb-2">
          Centang pernyataan yang sesuai dengan kepribadian atau kesukaanmu:
        </p>

        {soalList.map((soal, idx) => {
          const isChecked = jawaban.includes(soal.id);
          return (
            <div
              key={soal.id}
              onClick={() => toggleJawaban(soal.id)}
              className={`p-4 rounded-2xl border cursor-pointer transition-all flex items-start gap-3 ${
                isChecked
                  ? "bg-purple-50 border-purple-300 shadow-sm"
                  : "bg-white border-slate-200 hover:border-purple-200"
              }`}
            >
              <div
                className={`w-6 h-6 rounded-lg flex items-center justify-center text-xs font-bold shrink-0 mt-0.5 transition-colors ${
                  isChecked ? "bg-purple-600 text-white" : "border-2 border-slate-300 text-transparent"
                }`}
              >
                <Check className="w-4 h-4 stroke-[3px]" />
              </div>
              <div className="text-xs font-medium text-slate-800 leading-relaxed">
                <span className="font-bold text-slate-400 mr-1.5">{idx + 1}.</span>
                {soal.pernyataan}
              </div>
            </div>
          );
        })}
      </div>

      {/* Floating Submit Footer */}
      <div className="fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-slate-200 p-4 max-w-md mx-auto rounded-t-2xl shadow-xl">
        <button
          onClick={() => handleSubmit(false)}
          disabled={submitting}
          className="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3.5 px-4 rounded-xl text-sm shadow-lg shadow-purple-200 flex items-center justify-center gap-2 transition-all"
        >
          {submitting ? "Mengirim Hasil..." : "Selesai & Submit Tes"} <Send className="w-4 h-4" />
        </button>
      </div>
    </main>
  );
}
