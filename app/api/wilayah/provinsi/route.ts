import { NextResponse } from "next/server";
import { prisma } from "@/lib/prisma";

export async function GET() {
  try {
    const data = await prisma.wilayah.findMany({
      where: { level: 1 },
      orderBy: { nama: "asc" },
      select: { kode: true, nama: true },
    });
    return NextResponse.json(data);
  } catch (error: any) {
    return NextResponse.json({ error: error.message }, { status: 500 });
  }
}
