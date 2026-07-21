import { NextResponse } from "next/server";
import { getSession } from "@/lib/auth";
import { prisma } from "@/lib/prisma";
import bcrypt from "bcryptjs";

export async function GET(request: Request) {
  try {
    const user = await getSession();
    if (!user || user.role !== "kemendikdasmen") {
      return NextResponse.json({ error: "Akses ditolak." }, { status: 403 });
    }

    const { searchParams } = new URL(request.url);
    const search = searchParams.get("search") || "";
    const jenjang = searchParams.get("jenjang") || "";

    const where: any = { role: "guru_bk" };

    if (jenjang === "smp" || jenjang === "smk") {
      where.jenjang = jenjang;
    }

    if (search.trim() !== "") {
      where.OR = [
        { nama_sekolah: { contains: search } },
        { npsn: { contains: search } },
        { name: { contains: search } },
        { email: { contains: search } },
      ];
    }

    const gurus = await prisma.user.findMany({
      where,
      orderBy: { nama_sekolah: "asc" },
    });

    const result = await Promise.all(
      gurus.map(async (guru: any) => {
        const jumlahSiswa = await prisma.user.count({
          where: {
            role: "siswa",
            asal_sekolah: guru.nama_sekolah || "",
          },
        });
        return {
          ...guru,
          jumlah_siswa: jumlahSiswa,
        };
      })
    );

    return NextResponse.json({ users: result });
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
    const { name, email, password, nama_sekolah, npsn, jenjang } = body;

    if (!name || !email || !password || !nama_sekolah || !npsn || !jenjang) {
      return NextResponse.json({ error: "Semua data sekolah/guru wajib diisi." }, { status: 400 });
    }

    const existingUser = await prisma.user.findFirst({
      where: {
        OR: [{ email }, { npsn }],
      },
    });

    if (existingUser) {
      return NextResponse.json({ error: "Email atau NPSN sudah terdaftar." }, { status: 400 });
    }

    const hashedPassword = await bcrypt.hash(password, 10);
    const newGuru = await prisma.user.create({
      data: {
        name,
        email,
        password: hashedPassword,
        role: "guru_bk",
        nama_sekolah,
        npsn,
        jenjang,
      },
    });

    return NextResponse.json({ success: true, user: newGuru });
  } catch (error: any) {
    return NextResponse.json({ error: error.message }, { status: 500 });
  }
}
