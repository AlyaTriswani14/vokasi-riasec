import { NextRequest, NextResponse } from "next/server";
import { prisma } from "@/lib/prisma";
import bcrypt from "bcryptjs";
import crypto from "crypto";
import { createToken } from "@/lib/auth";

export async function GET(request: NextRequest) {
  const code = request.nextUrl.searchParams.get("code");
  const jenjang = request.nextUrl.searchParams.get("state") === "smk" ? "smk" : "smp";
  const origin = request.nextUrl.origin;

  if (!code) {
    return NextResponse.redirect(`${origin}/login?jenjang=${jenjang}&error=google_denied`);
  }

  const clientId = process.env.GOOGLE_CLIENT_ID;
  const clientSecret = process.env.GOOGLE_CLIENT_SECRET;
  const redirectUri = process.env.GOOGLE_REDIRECT_URI || `${origin}/auth/google/callback`;

  if (!clientId || !clientSecret) {
    return NextResponse.json(
      { error: "GOOGLE_CLIENT_ID / GOOGLE_CLIENT_SECRET belum diatur di environment." },
      { status: 500 }
    );
  }

  try {
    const tokenRes = await fetch("https://oauth2.googleapis.com/token", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({
        code,
        client_id: clientId,
        client_secret: clientSecret,
        redirect_uri: redirectUri,
        grant_type: "authorization_code",
      }),
    });

    if (!tokenRes.ok) {
      throw new Error("Gagal menukar kode otorisasi dengan Google.");
    }

    const tokenData = await tokenRes.json();

    const userInfoRes = await fetch("https://www.googleapis.com/oauth2/v3/userinfo", {
      headers: { Authorization: `Bearer ${tokenData.access_token}` },
    });

    if (!userInfoRes.ok) {
      throw new Error("Gagal mengambil profil Google.");
    }

    const googleUser = await userInfoRes.json();

    if (!googleUser.email) {
      throw new Error("Akun Google tidak memiliki email.");
    }

    let user = await prisma.user.findUnique({ where: { email: googleUser.email } });

    if (!user) {
      const randomPassword = await bcrypt.hash(crypto.randomBytes(24).toString("hex"), 10);
      user = await prisma.user.create({
        data: {
          name: googleUser.name || googleUser.given_name || "Siswa",
          email: googleUser.email,
          password: randomPassword,
          role: "siswa",
          jenjang,
        },
      });
    } else if (!user.jenjang) {
      user = await prisma.user.update({ where: { id: user.id }, data: { jenjang } });
    }

    const token = await createToken({
      userId: user.id,
      email: user.email,
      role: user.role,
      jenjang: user.jenjang,
    });

    const destination = !user.nisn || !user.asal_sekolah ? "/lengkapi-profil" : "/dashboard";
    const response = NextResponse.redirect(`${origin}${destination}`);
    response.cookies.set("token", token, {
      httpOnly: true,
      secure: process.env.NODE_ENV === "production",
      path: "/",
      maxAge: 60 * 60 * 24 * 7,
    });

    return response;
  } catch (error: any) {
    return NextResponse.redirect(
      `${origin}/login?jenjang=${jenjang}&error=${encodeURIComponent(error.message || "google_failed")}`
    );
  }
}
