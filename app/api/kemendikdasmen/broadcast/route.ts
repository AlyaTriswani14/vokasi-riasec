import { NextResponse } from "next/server";
import { getSession } from "@/lib/auth";
import { prisma } from "@/lib/prisma";

export async function GET() {
  try {
    const broadcasts = await prisma.broadcast.findMany({
      orderBy: { createdAt: "desc" },
    });
    return NextResponse.json({ broadcasts });
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
    const { subjek, isi, target_penerima, target_jenjang } = body;

    if (!subjek || !isi || !target_penerima || !target_jenjang) {
      return NextResponse.json({ error: "Semua field broadcast wajib diisi." }, { status: 400 });
    }

    const broadcast = await prisma.broadcast.create({
      data: {
        subjek,
        isi,
        targetPenerima: target_penerima,
        targetJenjang: target_jenjang,
      },
    });

    return NextResponse.json({ success: true, broadcast });
  } catch (error: any) {
    return NextResponse.json({ error: error.message }, { status: 500 });
  }
}
