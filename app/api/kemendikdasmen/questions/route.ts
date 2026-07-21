import { NextResponse } from "next/server";
import { getSession } from "@/lib/auth";
import { prisma } from "@/lib/prisma";

export async function GET() {
  try {
    const user = await getSession();
    if (!user || user.role !== "kemendikdasmen") {
      return NextResponse.json({ error: "Akses ditolak." }, { status: 403 });
    }

    const soalList = await prisma.soalRiasec.findMany({
      orderBy: { urutan: "asc" },
    });

    return NextResponse.json({ soalList });
  } catch (error: any) {
    return NextResponse.json({ error: error.message }, { status: 500 });
  }
}

export async function POST(request: Request) {
  try {
    const user = await getSession();
    if (!user || user.role !== "kemendikdasmen") {
      return NextResponse.json({ error: "Akses ditolak." }, { status: 403 });
    }

    const body = await request.json();
    const { pernyataan, aspek } = body;

    if (!pernyataan || !aspek) {
      return NextResponse.json({ error: "Pernyataan dan Aspek wajib diisi." }, { status: 400 });
    }

    const maxUrutan = await prisma.soalRiasec.aggregate({
      _max: { urutan: true },
    });

    const nextUrutan = (maxUrutan._max.urutan || 0) + 1;

    const soal = await prisma.soalRiasec.create({
      data: {
        pernyataan,
        aspek,
        urutan: nextUrutan,
        status: "aktif",
      },
    });

    return NextResponse.json({ success: true, soal });
  } catch (error: any) {
    return NextResponse.json({ error: error.message }, { status: 500 });
  }
}
