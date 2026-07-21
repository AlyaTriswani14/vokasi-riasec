import { NextResponse } from "next/server";
import { prisma } from "@/lib/prisma";

export async function GET() {
  try {
    const soalList = await prisma.soalRiasec.findMany({
      where: { status: "aktif" },
      orderBy: { urutan: "asc" },
    });

    const pengaturanDurasi = await prisma.pengaturan.findUnique({
      where: { kunci: "durasi_tes_menit" },
    });

    const durasiMenit = parseInt(pengaturanDurasi?.nilai || "5", 10);

    return NextResponse.json({
      soalList,
      durasiMenit,
    });
  } catch (error: any) {
    return NextResponse.json({ error: error.message }, { status: 500 });
  }
}
