import type { PrismaClient } from "@prisma/client";
import bcrypt from "bcryptjs";

// Shared by prisma/seed.ts (CLI) and app/api/seed/route.ts (1-click HTTP
// seeder) so the two never drift out of sync again. Does NOT touch the
// `wilayah` table: that's a one-time 91.599-row bulk import handled
// separately by `prisma/seedWilayah.ts`, too large to run inside an HTTP
// request.
export async function seedCore(prisma: PrismaClient) {
  // 1. Pengaturan
  const settings = [
    { kunci: "durasi_tes_menit", nilai: "5" },
    { kunci: "target_kuota_nasional", nilai: "600000" },
    { kunci: "tahun_ajaran", nilai: "2026/2027" },
    { kunci: "status_sistem", nilai: "Aktif" },
  ];

  for (const s of settings) {
    await prisma.pengaturan.upsert({
      where: { kunci: s.kunci },
      update: { nilai: s.nilai },
      create: s,
    });
  }

  // 2. Admin Kemendikdasmen & Guru BK default accounts
  const hashedPassword = await bcrypt.hash("password123", 10);

  await prisma.user.upsert({
    where: { email: "admin@kemendikdasmen.go.id" },
    update: {},
    create: {
      name: "Administrator Kemendikdasmen",
      email: "admin@kemendikdasmen.go.id",
      password: hashedPassword,
      role: "kemendikdasmen",
    },
  });

  await prisma.user.upsert({
    where: { email: "gurubk@smkn1jakarta.sch.id" },
    update: {},
    create: {
      name: "Budi Santoso, S.Pd",
      email: "gurubk@smkn1jakarta.sch.id",
      password: hashedPassword,
      role: "guru_bk",
      jenjang: "smk",
      nama_sekolah: "SMKN 1 Jakarta",
      npsn: "20100001",
    },
  });

  // 3. Soal RIASEC (42 soal, dipulihkan dari data production Laravel lama)
  const defaultSoal = [
    { pernyataan: "Saya suka mengulik peralatan", aspek: "R" },
    { pernyataan: "Saya suka mengerjakan puzzle", aspek: "I" },
    { pernyataan: "Saya suka bekerja mandiri", aspek: "A" },
    { pernyataan: "Saya suka bekerja dalam kelompok", aspek: "S" },
    { pernyataan: "Saya suka membuat target untuk diri saya sendiri", aspek: "E" },
    { pernyataan: "Saya suka merapikan barang-barang (buku, alat tulis, kamar)", aspek: "C" },
    { pernyataan: "Saya suka menyusun balok/LEGO", aspek: "R" },
    { pernyataan: "Saya suka membaca buku tentang seni dan musik", aspek: "A" },
    { pernyataan: "Saya suka mengerjakan hal-hal dengan instruksi yang jelas", aspek: "C" },
    { pernyataan: "Saya suka meyakinkan teman untuk mengikuti cara saya", aspek: "E" },
    { pernyataan: "Saya suka melakukan percobaan/eksperimen", aspek: "I" },
    { pernyataan: "Saya suka menjelaskan sesuatu kepada teman", aspek: "S" },
    { pernyataan: "Saya suka membantu orang lain memecahkan persoalan", aspek: "S" },
    { pernyataan: "Saya suka memperbaiki alat-alat mekanik (sepeda, dll.)", aspek: "R" },
    { pernyataan: "Saya tidak keberatan kalau bekerja melebihi waktu yang ditentukan", aspek: "C" },
    { pernyataan: "Saya suka menjual sesuatu", aspek: "E" },
    { pernyataan: "Saya suka membuat karya berbentuk tulisan", aspek: "A" },
    { pernyataan: "Saya suka sains", aspek: "I" },
    { pernyataan: "Saya suka mendapatkan tantangan baru", aspek: "E" },
    { pernyataan: "Saya suka menghibur teman", aspek: "S" },
    { pernyataan: "Saya suka mencari tahu cara kerja sebuah alat", aspek: "I" },
    { pernyataan: "Saya suka merangkai atau merakit benda", aspek: "R" },
    { pernyataan: "Saya adalah orang yang kreatif", aspek: "A" },
    { pernyataan: "Saya suka memperhatikan detail", aspek: "C" },
    { pernyataan: "Saya suka merapikan catatan atau LKS", aspek: "C" },
    { pernyataan: "Saya suka mencari tahu penyebab suatu kejadian", aspek: "I" },
    { pernyataan: "Saya suka memainkan alat musik atau bernyanyi", aspek: "A" },
    { pernyataan: "Saya suka mempelajari budaya berbagai daerah", aspek: "S" },
    { pernyataan: "Saya ingin membuka usaha sendiri suatu saat nanti", aspek: "E" },
    { pernyataan: "Saya suka memasak", aspek: "R" },
    { pernyataan: "Saya suka bermain peran atau drama", aspek: "A" },
    { pernyataan: "Saya suka mempraktikkan hal-hal yang sudah dipelajari", aspek: "R" },
    { pernyataan: "Saya suka mengerjakan soal matematika atau grafik", aspek: "I" },
    { pernyataan: "Saya suka mendiskusikan hal-hal yang terjadi di sekitar saya", aspek: "S" },
    { pernyataan: "Saya suka merapikan kamar saya", aspek: "C" },
    { pernyataan: "Saya suka memimpin kelompok atau kelas", aspek: "E" },
    { pernyataan: "Saya suka berkegiatan di luar ruangan", aspek: "R" },
    { pernyataan: "Saya suka berkegiatan di dalam ruangan dengan meja-kursi", aspek: "C" },
    { pernyataan: "Saya suka menghitung", aspek: "I" },
    { pernyataan: "Saya suka menolong orang", aspek: "S" },
    { pernyataan: "Saya suka menggambar", aspek: "A" },
    { pernyataan: "Saya suka berbicara di depan umum", aspek: "E" },
  ].map((soal, i) => ({ ...soal, urutan: i + 1 }));

  await prisma.soalRiasec.deleteMany({});
  for (const soal of defaultSoal) {
    await prisma.soalRiasec.create({
      data: {
        ...soal,
        status: "aktif",
      },
    });
  }

  // 4. Sekolah contoh
  const sekolahData = [
    { npsn: "20100001", namaSekolah: "SMKN 1 Jakarta", jenjang: "smk", provinsi: "Daerah Khusus Ibukota Jakarta", kabupatenKota: "Kota Administrasi Jakarta Selatan", kecamatan: "Tebet", kelurahan: "Tebet Barat" },
    { npsn: "20100002", namaSekolah: "SMKN 2 Jakarta", jenjang: "smk", provinsi: "Daerah Khusus Ibukota Jakarta", kabupatenKota: "Kota Administrasi Jakarta Selatan", kecamatan: "Tebet", kelurahan: "Tebet Barat" },
    { npsn: "20100003", namaSekolah: "SMKN 3 Jakarta", jenjang: "smk", provinsi: "Daerah Khusus Ibukota Jakarta", kabupatenKota: "Kota Administrasi Jakarta Selatan", kecamatan: "Tebet", kelurahan: "Tebet Timur" },
    { npsn: "20200001", namaSekolah: "SMKN 1 Bandung", jenjang: "smk", provinsi: "Jawa Barat", kabupatenKota: "Kota Bandung", kecamatan: "Sumur Bandung", kelurahan: "Merdeka" },
    { npsn: "20200002", namaSekolah: "SMKN 2 Bandung", jenjang: "smk", provinsi: "Jawa Barat", kabupatenKota: "Kota Bandung", kecamatan: "Sumur Bandung", kelurahan: "Merdeka" },
  ];

  for (const s of sekolahData) {
    await prisma.sekolah.upsert({
      where: { npsn: s.npsn },
      update: s,
      create: s,
    });
  }
}
