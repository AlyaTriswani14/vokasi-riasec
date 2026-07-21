import { NextResponse } from "next/server";
import { prisma } from "@/lib/prisma";
import { seedCore } from "@/lib/seedData";

export async function GET() {
  try {
    await seedCore(prisma);

    return NextResponse.json({
      success: true,
      message: "Database berhasil di-seed di Vercel!",
      accounts: {
        admin_kemendikdasmen: "admin@kemendikdasmen.go.id / password123",
        guru_bk: "gurubk@smkn1jakarta.sch.id / password123",
      },
    });
  } catch (error: any) {
    return NextResponse.json({ error: error.message }, { status: 500 });
  }
}

export async function POST() {
  return GET();
}
