import "./globals.css";
import type { Metadata } from "next";

export const metadata: Metadata = {
  title: "Ekosistem Vokasi RIASEC - Tes Minat Bakat Holland",
  description: "Platform Tes Minat Bakat RIASEC Vokasi Kemendikdasmen untuk Siswa SMP & SMK",
};

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="id">
      <body className="antialiased min-h-screen bg-slate-50 text-slate-900">
        {children}
      </body>
    </html>
  );
}
