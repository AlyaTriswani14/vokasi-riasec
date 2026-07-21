import { NextRequest, NextResponse } from "next/server";

export async function GET(request: NextRequest) {
  const jenjang = request.nextUrl.searchParams.get("jenjang") === "smk" ? "smk" : "smp";
  const clientId = process.env.GOOGLE_CLIENT_ID;

  if (!clientId) {
    return NextResponse.json(
      { error: "GOOGLE_CLIENT_ID belum diatur di environment." },
      { status: 500 }
    );
  }

  const redirectUri = process.env.GOOGLE_REDIRECT_URI || `${request.nextUrl.origin}/auth/google/callback`;

  const googleUrl = new URL("https://accounts.google.com/o/oauth2/v2/auth");
  googleUrl.searchParams.set("client_id", clientId);
  googleUrl.searchParams.set("redirect_uri", redirectUri);
  googleUrl.searchParams.set("response_type", "code");
  googleUrl.searchParams.set("scope", "openid email profile");
  googleUrl.searchParams.set("state", jenjang);
  googleUrl.searchParams.set("prompt", "select_account");

  return NextResponse.redirect(googleUrl.toString());
}
