import { GraduationCap } from "lucide-react";

// Sticky top bar reused across every student page in the original Blade
// layout: navy "Bakat Minat" wordmark + circular avatar with the user's
// initials (or "PP" when logged out / name unavailable).
export default function TopHeader({ name }: { name?: string | null }) {
  const initials = (name || "PP").trim().slice(0, 2).toUpperCase();

  return (
    <div className="w-full flex justify-between items-center p-4 bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
      <div className="flex items-center gap-2 text-[#003366] font-bold text-lg">
        <GraduationCap className="w-5 h-5" />
        <span>Bakat Minat</span>
      </div>
      <div className="w-8 h-8 rounded-full bg-[#00558f] text-white flex items-center justify-center font-bold text-xs">
        {initials}
      </div>
    </div>
  );
}
