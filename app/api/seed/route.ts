import { NextResponse } from "next/server";
import { prisma } from "@/lib/prisma";
import bcrypt from "bcryptjs";

export async function GET() {
  try {
    // 1. Seed Pengaturan
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

    // 2. Seed Admin Kemendikdasmen & Guru BK default accounts
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

    // 3. Seed Soal RIASEC (30 Soal)
    const defaultSoal = [
      { pernyataan: "Saya suka merakit, memperbaiki, atau mengoperasikan mesin & peralatan mekanik.", aspek: "R", urutan: 1 },
      { pernyataan: "Saya senang bekerja di luar ruangan dan melakukan kegiatan fisik praktis.", aspek: "R", urutan: 2 },
      { pernyataan: "Saya lebih paham instruksi yang berbentuk gambar teknik atau skema visual.", aspek: "R", urutan: 3 },
      { pernyataan: "Saya tertarik menggunakan alat perkakas kayu, listrik, atau konstruksi.", aspek: "R", urutan: 4 },
      { pernyataan: "Saya menikmati kegiatan memperbaiki perangkat elektronik atau kendaraan.", aspek: "R", urutan: 5 },

      { pernyataan: "Saya gemar melakukan eksperimen sains atau menganalisis fenomena alam.", aspek: "I", urutan: 6 },
      { pernyataan: "Saya suka menyelesaikan teka-teki logika, pemrogramaan, atau matematika rumit.", aspek: "I", urutan: 7 },
      { pernyataan: "Saya senang meneliti sebab-akibat dari suatu masalah secara mendalam.", aspek: "I", urutan: 8 },
      { pernyataan: "Saya tertarik membaca jurnal, artikel ilmiah, atau data riset.", aspek: "I", urutan: 9 },
      { pernyataan: "Saya menyukai tugas menguji hipotesis atau mengolah sampel data.", aspek: "I", urutan: 10 },

      { pernyataan: "Saya senang membuat karya seni visual seperti menggambar, merancang logo, atau fotografi.", aspek: "A", urutan: 11 },
      { pernyataan: "Saya memiliki ide-ide unik dan suka mengekspresikan diri lewat media kreatif.", aspek: "A", urutan: 12 },
      { pernyataan: "Saya lebih menyukai lingkungan kerja yang fleksibel tanpa aturan kaku.", aspek: "A", urutan: 13 },
      { pernyataan: "Saya tertarik pada bidang desain fashion, musik, seni drama, atau menulis cerita.", aspek: "A", urutan: 14 },
      { pernyataan: "Saya senang mengubah tampilan visual agar lebih estetis dan menarik.", aspek: "A", urutan: 15 },

      { pernyataan: "Saya senang membantu teman yang sedang mengalami kendala atau masalah emosional.", aspek: "S", urutan: 16 },
      { pernyataan: "Saya menikmati peran sebagai pengajar, mentor, atau konselor bagi sesama.", aspek: "S", urutan: 17 },
      { pernyataan: "Saya mudah berempati dan peduli pada kesejahteraan masyarakat sekitar.", aspek: "S", urutan: 18 },
      { pernyataan: "Saya menyukai kegiatan sukarela atau pelayanan sosial kemanusiaan.", aspek: "S", urutan: 19 },
      { pernyataan: "Saya merasa puas ketika bisa memberikan dukungan positif kepada orang lain.", aspek: "S", urutan: 20 },

      { pernyataan: "Saya percaya diri untuk berbicara di depan umum dan memimpin suatu organisasi.", aspek: "E", urutan: 21 },
      { pernyataan: "Saya berani mengambil risiko untuk mengejar peluang bisnis atau target penjualan.", aspek: "E", urutan: 22 },
      { pernyataan: "Saya senang bernegosiasi dan meyakinkan orang lain agar menyetujui ide saya.", aspek: "E", urutan: 23 },
      { pernyataan: "Saya memiliki ambisi tinggi untuk mengelola proyek dan mencapai posisi kepemimpinan.", aspek: "E", urutan: 24 },
      { pernyataan: "Saya tertarik mempromosikan produk, ide baru, atau strategist pemasaran.", aspek: "E", urutan: 25 },

      { pernyataan: "Saya sangat menyukai keteraturan, kerapian berkas, dan ketelitian angka.", aspek: "C", urutan: 26 },
      { pernyataan: "Saya bekerja dengan baik sesuai prosedur operasional standar (SOP) yang jelas.", aspek: "C", urutan: 27 },
      { pernyataan: "Saya terbiasa mencatat laporan keuangan, mengorganisir tabel, atau mengelola basis data.", aspek: "C", urutan: 28 },
      { pernyataan: "Saya lebih memilih pekerjaan yang terstruktur ketimbang pekerjaan acak.", aspek: "C", urutan: 29 },
      { pernyataan: "Saya teliti dalam memeriksa ulang detail pekerjaan agar bebas dari kesalahan.", aspek: "C", urutan: 30 },
    ];

    const existingCount = await prisma.soalRiasec.count();
    if (existingCount === 0) {
      for (const soal of defaultSoal) {
        await prisma.soalRiasec.create({
          data: {
            ...soal,
            status: "aktif",
          },
        });
      }
    }

    // 4. Seed Wilayah dasar (DKI Jakarta & Jawa Barat)
    const wilayahData = [
      { kode: "31", nama: "DKI JAKARTA", level: 1, induk: "0" },
      { kode: "31.71", nama: "KOTA JAKARTA SELATAN", level: 2, induk: "31" },
      { kode: "31.71.01", nama: "TEBET", level: 3, induk: "31.71" },
      { kode: "31.71.01.1001", nama: "TEBET BARAT", level: 4, induk: "31.71.01" },

      { kode: "32", nama: "JAWA BARAT", level: 1, induk: "0" },
      { kode: "32.73", nama: "KOTA BANDUNG", level: 2, induk: "32" },
      { kode: "32.73.01", nama: "SUMUR BANDUNG", level: 3, induk: "32.73" },
      { kode: "32.73.01.1001", nama: "MERDEKA", level: 4, induk: "32.73.01" },
    ];

    for (const w of wilayahData) {
      await prisma.wilayah.upsert({
        where: { kode: w.kode },
        update: {},
        create: w,
      });
    }

    // 5. Seed Sekolah contoh
    const sekolahData = [
      { npsn: "20100001", namaSekolah: "SMKN 1 Jakarta", jenjang: "smk", provinsi: "DKI JAKARTA", kabupatenKota: "KOTA JAKARTA SELATAN", kecamatan: "TEBET", kelurahan: "TEBET BARAT" },
      { npsn: "20100002", namaSekolah: "SMKN 2 Jakarta", jenjang: "smk", provinsi: "DKI JAKARTA", kabupatenKota: "KOTA JAKARTA SELATAN", kecamatan: "TEBET", kelurahan: "TEBET BARAT" },
      { npsn: "20100003", namaSekolah: "SMKN 3 Jakarta", jenjang: "smk", provinsi: "DKI JAKARTA", kabupatenKota: "KOTA JAKARTA SELATAN", kecamatan: "TEBET", kelurahan: "TEBET TIMUR" },
      { npsn: "20200001", namaSekolah: "SMKN 1 Bandung", jenjang: "smk", provinsi: "JAWA BARAT", kabupatenKota: "KOTA BANDUNG", kecamatan: "SUMUR BANDUNG", kelurahan: "MERDEKA" },
      { npsn: "20200002", namaSekolah: "SMKN 2 Bandung", jenjang: "smk", provinsi: "JAWA BARAT", kabupatenKota: "KOTA BANDUNG", kecamatan: "SUMUR BANDUNG", kelurahan: "MERDEKA" },
    ];

    for (const s of sekolahData) {
      await prisma.sekolah.upsert({
        where: { npsn: s.npsn },
        update: {},
        create: s,
      });
    }

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
