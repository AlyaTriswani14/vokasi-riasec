import { NextResponse } from "next/server";
import { getSession } from "@/lib/auth";
import { prisma } from "@/lib/prisma";

export async function GET() {
  const user = await getSession();
  if (!user || user.role !== "guru_bk") {
    return NextResponse.json({ error: "Akses ditolak." }, { status: 403 });
  }

  const siswaList = await prisma.user.findMany({
    where: {
      role: "siswa",
      asal_sekolah: user.nama_sekolah || "",
    },
    include: {
      results: {
        orderBy: { createdAt: "desc" },
        take: 1,
      },
    },
    orderBy: { name: "asc" },
  });

  const rows = [
    ["Nama", "Kelas", "NISN", "Email", "Status Tes", "Tanggal Tes", "Tipe Dominan"],
  ];

  for (const s of siswaList) {
    const hasil = s.results[0];
    let dominan = "-";
    if (hasil) {
      const skor: Record<string, number> = {
        R: hasil.skorR,
        I: hasil.skorI,
        A: hasil.skorA,
        S: hasil.skorS,
        E: hasil.skorE,
        C: hasil.skorC,
      };
      const sorted = Object.entries(skor).sort((a, b) => b[1] - a[1]);
      dominan = sorted[0][0];
    }

    rows.push([
      s.name,
      s.kelas || "-",
      s.nisn || "-",
      s.email,
      hasil ? "Selesai" : "Belum Tes",
      hasil ? new Date(hasil.createdAt).toLocaleDateString("id-ID") : "-",
      dominan,
    ]);
  }

  const csvContent = rows
    .map((row) => row.map((val) => `"${val.replace(/"/g, '""')}"`).join(","))
    .join("\n");

  return new NextResponse(csvContent, {
    status: 200,
    headers: {
      "Content-Type": "text/csv; charset=utf-8",
      "Content-Disposition": `attachment; filename="siswa-bina-${new Date().toISOString().slice(0, 10)}.csv"`,
    },
  });
}
