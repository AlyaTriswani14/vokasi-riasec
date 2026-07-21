import { NextResponse } from "next/server";
import { getSession } from "@/lib/auth";

export async function GET() {
  const user = await getSession();
  if (!user) {
    return NextResponse.json({ authenticated: false, user: null });
  }

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
  });
}
