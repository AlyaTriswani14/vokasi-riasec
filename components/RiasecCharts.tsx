"use client";

import { useEffect, useRef } from "react";
import { Chart, type ChartConfiguration } from "chart.js/auto";
import { RiasecCode, TIPE_LABELS } from "@/lib/riasecData";

const ORDER: RiasecCode[] = ["r", "i", "a", "s", "e", "c"];
const DONUT_COLORS = ["#EF4444", "#3B82F6", "#F97316", "#06B6D4", "#F59E0B", "#10B981"];

// Faithful port of the Chart.js donut + radar pair from the original Blade
// view (resources/views/siswa/eksplorasi.blade.php), which loaded Chart.js
// 4.4.0 via CDN and rendered the same two charts with these exact configs.
export default function RiasecCharts({
  persenArr,
  gradFrom,
  accentBorder,
}: {
  persenArr: Record<RiasecCode, number>;
  gradFrom: string;
  accentBorder: string;
}) {
  const donutRef = useRef<HTMLCanvasElement>(null);
  const radarRef = useRef<HTMLCanvasElement>(null);

  useEffect(() => {
    const data = ORDER.map((k) => persenArr[k]);
    const labels = ORDER.map((k) => TIPE_LABELS[k]);
    const charts: Chart[] = [];

    if (donutRef.current) {
      charts.push(
        new Chart(donutRef.current, {
          type: "doughnut",
          data: {
            labels,
            datasets: [{ data, backgroundColor: DONUT_COLORS, borderWidth: 0 }],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: { position: "bottom", labels: { boxWidth: 10, font: { size: 10 } } },
              tooltip: { callbacks: { label: (ctx) => `${ctx.label}: ${ctx.raw}%` } },
            },
          },
        } satisfies ChartConfiguration<"doughnut">)
      );
    }

    if (radarRef.current) {
      charts.push(
        new Chart(radarRef.current, {
          type: "radar",
          data: {
            labels,
            datasets: [
              {
                label: "Skor Kamu",
                data,
                backgroundColor: "rgba(255, 122, 69, 0.2)",
                borderColor: gradFrom,
                borderWidth: 2,
                pointBackgroundColor: gradFrom,
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              r: {
                min: 0,
                max: 100,
                ticks: { stepSize: 20, font: { size: 9 }, callback: (v) => `${v}%` },
                pointLabels: { font: { size: 9 } },
              },
            },
            plugins: {
              legend: { display: false },
              tooltip: { callbacks: { label: (ctx) => `${ctx.label}: ${ctx.raw}%` } },
            },
          },
        } satisfies ChartConfiguration<"radar">)
      );
    }

    return () => charts.forEach((c) => c.destroy());
  }, [persenArr, gradFrom]);

  return (
    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div className={`bg-white border ${accentBorder} rounded-2xl p-5 shadow-sm`}>
        <p className="text-[10px] font-bold text-gray-400 tracking-wider uppercase mb-3">Sebaran RIASEC</p>
        <div className="relative" style={{ height: 240 }}>
          <canvas ref={donutRef} />
        </div>
      </div>
      <div className={`bg-white border ${accentBorder} rounded-2xl p-5 shadow-sm`}>
        <p className="text-[10px] font-bold text-gray-400 tracking-wider uppercase mb-3">Bentuk Minat</p>
        <div className="relative" style={{ height: 240 }}>
          <canvas ref={radarRef} />
        </div>
      </div>
    </div>
  );
}
