import { NextResponse } from "next/server";
import { prisma } from "@/lib/prisma";
import bcrypt from "bcryptjs";
import { createToken } from "@/lib/auth";

export async function POST(request: Request) {
  try {
    const body = await request.json();
    const { name, email, password, nama_sekolah, npsn, jenjang } = body;

    if (!name || !email || !password || !nama_sekolah || !npsn || !jenjang) {
      return NextResponse.json({ error: "Semua kolom pendaftaran Guru BK wajib diisi." }, { status: 400 });
    }

    const existingEmail = await prisma.user.findUnique({ where: { email } });
    if (existingEmail) {
      return NextResponse.json({ error: "Email sudah terdaftar." }, { status: 400 });
    }

    const hashedPassword = await bcrypt.hash(password, 10);
    const user = await prisma.user.create({
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

    const token = await createToken({
      userId: user.id,
      email: user.email,
      role: user.role,
      jenjang: user.jenjang,
    });

    const response = NextResponse.json({ success: true, user });
    response.cookies.set("token", token, {
      httpOnly: true,
      secure: process.env.NODE_ENV === "production",
      path: "/",
      maxAge: 60 * 60 * 24 * 7,
    });

    return response;
  } catch (error: any) {
    return NextResponse.json({ error: error.message || "Gagal mendaftar Guru BK" }, { status: 500 });
  }
}
