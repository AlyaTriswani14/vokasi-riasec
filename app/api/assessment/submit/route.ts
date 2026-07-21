import { NextResponse } from "next/server";
import { getSession } from "@/lib/auth";
import { prisma } from "@/lib/prisma";

export async function POST(request: Request) {
  try {
    const user = await getSession();
    if (!user) {
      return NextResponse.json({ error: "Belum login." }, { status: 401 });
    }

    const body = await request.json();
    const { jawaban } = body; // Array of selected question IDs (jawaban YA)

    const selectedIds = Array.isArray(jawaban) ? jawaban.map((id: any) => Number(id)) : [];

    const skor: Record<string, number> = {
      R: 0,
      I: 0,
      A: 0,
      S: 0,
      E: 0,
      C: 0,
    };

    if (selectedIds.length > 0) {
      const selectedSoal = await prisma.soalRiasec.findMany({
        where: {
          id: { in: selectedIds },
        },
      });

      for (const s of selectedSoal) {
        if (s.aspek && typeof skor[s.aspek] === "number") {
          skor[s.aspek]++;
        }
      }
    }

    const result = await prisma.riasecResult.create({
      data: {
        userId: user.id,
        skorR: skor["R"],
        skorI: skor["I"],
        skorA: skor["A"],
        skorS: skor["S"],
        skorE: skor["E"],
        skorC: skor["C"],
      },
    });

    return NextResponse.json({ success: true, result, skor });
  } catch (error: any) {
    return NextResponse.json({ error: error.message || "Gagal menyimpan hasil tes" }, { status: 500 });
  }
}
