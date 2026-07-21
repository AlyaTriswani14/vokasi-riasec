// Jenjang-based branding used across student-facing pages, ported from the
// original Laravel Blade views (SMK = blue/teal, SMP = orange/amber).
export function getJenjangTheme(jenjang: string | null | undefined) {
  const isSmk = jenjang === "smk";

  const gradFrom = isSmk ? "#2F6FED" : "#FF7A45";
  const gradTo = isSmk ? "#22C1C3" : "#FFB13D";

  return {
    isSmk,
    gradFrom,
    gradTo,
    gradientStyle: { background: `linear-gradient(135deg, ${gradFrom}, ${gradTo})` },
    gradientBarStyle: { background: `linear-gradient(90deg, ${gradFrom}, ${gradTo})` },
    accentText: isSmk ? "text-[#2F6FED]" : "text-[#c2410c]",
    accentBg: isSmk ? "bg-blue-50" : "bg-orange-50",
    accentBorder: isSmk ? "border-blue-100" : "border-orange-100",
    accentBtn: isSmk
      ? "bg-[#2F6FED] hover:bg-[#255bc4]"
      : "bg-[#FF7A45] hover:bg-[#e8672f]",
    badgeLabel: isSmk ? "Siswa SMK" : "Siswa SMP/MTs",
  };
}

export type JenjangTheme = ReturnType<typeof getJenjangTheme>;

export const RIASEC_LABELS: Record<string, string> = {
  R: "Realistic",
  I: "Investigative",
  A: "Artistic",
  S: "Social",
  E: "Enterprising",
  C: "Conventional",
};
