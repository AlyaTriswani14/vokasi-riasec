import { NextResponse } from "next/server";
import { getSession } from "@/lib/auth";
import { prisma } from "@/lib/prisma";

export async function GET() {
  const user = await getSession();
  if (!user) {
    return NextResponse.json({ authenticated: false, user: null });
  }

  const hasilTes = await prisma.riasecResult.findFirst({
    where: { userId: user.id },
    orderBy: { createdAt: "desc" },
  });

  return NextResponse.json({
    authenticated: true,
    user: {
      id: user.id,
      name: user.name,
      email: user.email,
      role: user.role,
      jenjang: user.jenjang,
      nisn: user.nisn,
      asal_sekolah: user.asal_sekolah,
      kelas: user.kelas,
      provinsi: user.provinsi,
      kabupaten_kota: user.kabupaten_kota,
      kecamatan: user.kecamatan,
      kelurahan: user.kelurahan,
      npsn: user.npsn,
      nama_sekolah: user.nama_sekolah,
    },
    hasilTes: hasilTes
      ? {
          createdAt: hasilTes.createdAt,
          skorR: hasilTes.skorR,
          skorI: hasilTes.skorI,
          skorA: hasilTes.skorA,
          skorS: hasilTes.skorS,
          skorE: hasilTes.skorE,
          skorC: hasilTes.skorC,
        }
      : null,
  });
}
