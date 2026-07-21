import { prisma } from "./prisma";

export interface SekolahResult {
  sekolah: {
    id: number;
    npsn: string;
    namaSekolah: string;
    jenjang: string;
    provinsi: string;
    kabupatenKota: string;
    kecamatan: string;
    kelurahan: string | null;
  };
  tingkatKecocokan: string;
}

export async function getSekolahTerdekat(user: {
  provinsi?: string | null;
  kabupaten_kota?: string | null;
  kecamatan?: string | null;
  kelurahan?: string | null;
}): Promise<SekolahResult[]> {
  if (!user.provinsi) return [];

  const results: SekolahResult[] = [];
  const usedNpsn = new Set<string>();

  const MIN_HASIL = 3;
  const MAX_HASIL = 5;

  const tahapan = [
    {
      syarat: !!user.kelurahan && !!user.kecamatan && !!user.kabupaten_kota,
      label: "Sekelurahan",
      where: {
        kelurahan: user.kelurahan || undefined,
        kecamatan: user.kecamatan || undefined,
        kabupatenKota: user.kabupaten_kota || undefined,
        provinsi: user.provinsi || undefined,
      },
    },
    {
      syarat: !!user.kecamatan && !!user.kabupaten_kota,
      label: "Sekecamatan",
      where: {
        kecamatan: user.kecamatan || undefined,
        kabupatenKota: user.kabupaten_kota || undefined,
        provinsi: user.provinsi || undefined,
      },
    },
    {
      syarat: !!user.kabupaten_kota,
      label: "Sekabupaten/Kota",
      where: {
        kabupatenKota: user.kabupaten_kota || undefined,
        provinsi: user.provinsi || undefined,
      },
    },
    {
      syarat: true,
      label: "Seprovinsi",
      where: {
        provinsi: user.provinsi || undefined,
      },
    },
  ];

  for (const t of tahapan) {
    if (results.length >= MAX_HASIL) break;
    if (!t.syarat) continue;

    const limit = MAX_HASIL - results.length;
    const sekolahList = await prisma.sekolah.findMany({
      where: {
        ...t.where,
        npsn: { notIn: Array.from(usedNpsn) },
      },
      take: limit,
      orderBy: { namaSekolah: "asc" },
    });

    for (const s of sekolahList) {
      results.push({
        sekolah: s,
        tingkatKecocokan: t.label,
      });
      usedNpsn.add(s.npsn);
    }

    if (results.length >= MIN_HASIL) break;
  }

  return results;
}
