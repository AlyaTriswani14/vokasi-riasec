import { NextResponse } from "next/server";
import { getSession } from "@/lib/auth";
import { prisma } from "@/lib/prisma";

export async function GET() {
  try {
    const user = await getSession();
    if (!user || user.role !== "kemendikdasmen") {
      return NextResponse.json({ error: "Akses ditolak." }, { status: 403 });
    }

    const durasi = await prisma.pengaturan.findUnique({ where: { kunci: "durasi_tes_menit" } });
    const kuota = await prisma.pengaturan.findUnique({ where: { kunci: "target_kuota_nasional" } });
    const tahun = await prisma.pengaturan.findUnique({ where: { kunci: "tahun_ajaran" } });
    const status = await prisma.pengaturan.findUnique({ where: { kunci: "status_sistem" } });

    return NextResponse.json({
      durasi_tes_menit: parseInt(durasi?.nilai || "5", 10),
      target_kuota_nasional: parseInt(kuota?.nilai || "600000", 10),
      tahun_ajaran: tahun?.nilai || "2026/2027",
      status_sistem: status?.nilai || "Aktif",
    });
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
    const { durasi_tes_menit, target_kuota_nasional, tahun_ajaran, status_sistem } = body;

    const dataToSave = [
      { kunci: "durasi_tes_menit", nilai: String(durasi_tes_menit) },
      { kunci: "target_kuota_nasional", nilai: String(target_kuota_nasional) },
      { kunci: "tahun_ajaran", nilai: String(tahun_ajaran) },
      { kunci: "status_sistem", nilai: String(status_sistem) },
    ];

    for (const item of dataToSave) {
      await prisma.pengaturan.upsert({
        where: { kunci: item.kunci },
        update: { nilai: item.nilai },
        create: item,
      });
    }

    return NextResponse.json({ success: true });
  } catch (error: any) {
    return NextResponse.json({ error: error.message }, { status: 500 });
  }
}
