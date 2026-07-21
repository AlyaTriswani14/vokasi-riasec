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
    const { name, nisn, asal_sekolah, kelas, provinsi, kabupaten_kota, kecamatan, kelurahan } = body;

    if (!name || !nisn || !asal_sekolah || !kelas || !provinsi || !kabupaten_kota || !kecamatan || !kelurahan) {
      return NextResponse.json({ error: "Semua kolom wajib diisi." }, { status: 400 });
    }

    // Check unique NISN
    const existingNisn = await prisma.user.findFirst({
      where: {
        nisn,
        NOT: { id: user.id },
      },
    });

    if (existingNisn) {
      return NextResponse.json({ error: "NISN sudah terdaftar oleh akun lain." }, { status: 400 });
    }

    const updatedUser = await prisma.user.update({
      where: { id: user.id },
      data: {
        name,
        nisn,
        asal_sekolah,
        kelas,
        provinsi,
        kabupaten_kota,
        kecamatan,
        kelurahan,
      },
    });

    return NextResponse.json({ success: true, user: updatedUser });
  } catch (error: any) {
    return NextResponse.json({ error: error.message || "Gagal menyimpan profil" }, { status: 500 });
  }
}
