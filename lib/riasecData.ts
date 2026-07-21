// RIASEC content ported from the original Laravel Blade views
// (resources/views/siswa/eksplorasi.blade.php, rekomendasi.blade.php,
// jurusan-detail.blade.php at git commit 8629312).

export type RiasecCode = "r" | "i" | "a" | "s" | "e" | "c";

export const TIPE_LABELS: Record<RiasecCode, string> = {
  r: "Realistic",
  i: "Investigative",
  a: "Artistic",
  s: "Social",
  e: "Enterprising",
  c: "Conventional",
};

// Top-3 rekomendasi jurusan SMK per tipe dominan RIASEC (dipakai untuk siswa SMP).
// Slug tiap item disesuaikan dengan entri lengkap di JURUSAN_DATA di bawah.
export const REKOM_JURUSAN: Record<RiasecCode, string[]> = {
  r: ["Teknik Kendaraan Ringan", "Teknik Mesin", "Teknik Komputer dan Jaringan"],
  i: ["Rekayasa Perangkat Lunak", "Teknik Komputer dan Jaringan", "Farmasi"],
  a: ["Desain Komunikasi Visual", "Multimedia", "Tata Busana"],
  s: ["Keperawatan", "Perhotelan", "Tata Boga"],
  e: ["Bisnis Daring dan Pemasaran", "Perbankan", "Perhotelan"],
  c: ["Akuntansi", "Administrasi Perkantoran", "Perbankan"],
};

// Rekomendasi skill tambahan di luar jurusan (dipakai untuk siswa SMK).
export const REKOM_SKILL: Record<RiasecCode, string[]> = {
  r: ["K3 (Keselamatan & Kesehatan Kerja)", "Problem solving lapangan", "Public speaking dasar"],
  i: ["Analisis data", "Riset & penulisan laporan", "Berpikir kritis"],
  a: ["Desain grafis", "Videografi & editing", "Personal branding"],
  s: ["Komunikasi & kerja tim", "Customer service", "Public speaking"],
  e: ["Kewirausahaan", "Negosiasi", "Digital marketing"],
  c: ["Manajemen waktu", "Administrasi digital", "Ketelitian & akurasi data"],
};

// Prospek karier per tipe dominan (dipakai untuk siswa SMK di halaman Rekomendasi).
export const PROSPEK_KARIER: Record<RiasecCode, Array<{ karier: string; mapel: string; gaji: string }>> = {
  r: [
    { karier: "Teknisi Otomotif", mapel: "Fisika, Praktik Kerja Industri", gaji: "Rp 3,5jt – 6jt" },
    { karier: "Mekanik Industri", mapel: "Fisika, Gambar Teknik", gaji: "Rp 4jt – 7jt" },
  ],
  i: [
    { karier: "Software Engineer", mapel: "Matematika, Informatika", gaji: "Rp 5jt – 12jt" },
    { karier: "Data Analyst", mapel: "Matematika, Statistika", gaji: "Rp 5jt – 10jt" },
  ],
  a: [
    { karier: "Graphic Designer", mapel: "Seni Budaya, Desain", gaji: "Rp 4jt – 8jt" },
    { karier: "Content Creator", mapel: "Bahasa, Desain", gaji: "Rp 3jt – 9jt" },
  ],
  s: [
    { karier: "Perawat", mapel: "Biologi, Kimia", gaji: "Rp 3,5jt – 7jt" },
    { karier: "Guru/Pendidik", mapel: "Bahasa, Pedagogik", gaji: "Rp 3,5jt – 6jt" },
  ],
  e: [
    { karier: "Marketing Executive", mapel: "Ekonomi, Kewirausahaan", gaji: "Rp 4jt – 10jt" },
    { karier: "Wirausaha", mapel: "Ekonomi, Kewirausahaan", gaji: "Tidak menentu" },
  ],
  c: [
    { karier: "Staff Administrasi", mapel: "Matematika, Ekonomi", gaji: "Rp 3,5jt – 6jt" },
    { karier: "Akuntan", mapel: "Matematika, Ekonomi", gaji: "Rp 4jt – 8jt" },
  ],
};

// Palet warna sinkron dengan halaman Eksplorasi & Hasil Tes di Blade lama.
export const RIASEC_VISUAL: Record<
  RiasecCode,
  { nama: string; label: string; warna: string; teksWarna: string; bgWarna: string; deskripsi: string; rekomendasi: string }
> = {
  r: {
    nama: "Realistic",
    label: "Praktis",
    warna: "bg-[#EF4444]",
    teksWarna: "text-[#EF4444]",
    bgWarna: "bg-red-50",
    deskripsi: "Kamu suka bekerja dengan alat, mesin, atau aktivitas fisik yang memberikan hasil nyata dan terukur.",
    rekomendasi: "Teknik Mesin, Teknik Ketenagalistrikan, Konstruksi & Properti, Otomotif, Pertanian.",
  },
  i: {
    nama: "Investigative",
    label: "Pemikir",
    warna: "bg-[#3B82F6]",
    teksWarna: "text-[#3B82F6]",
    bgWarna: "bg-blue-50",
    deskripsi: "Kamu gemar mengamati, belajar, dan menganalisis masalah kompleks untuk menemukan solusi logis.",
    rekomendasi: "Teknik Komputer & Jaringan, Kimia Analisis, Farmasi, Rekayasa Perangkat Lunak.",
  },
  a: {
    nama: "Artistic",
    label: "Kreatif",
    warna: "bg-[#F97316]",
    teksWarna: "text-[#F97316]",
    bgWarna: "bg-orange-50",
    deskripsi: "Kamu memiliki jiwa ekspresif, orisinal, dan menyukai kebebasan dalam berkreasi dan berekspresi.",
    rekomendasi: "DKV (Desain Komunikasi Visual), Multimedia, Seni Lukis, Animasi, Tata Busana.",
  },
  s: {
    nama: "Social",
    label: "Penolong",
    warna: "bg-[#06B6D4]",
    teksWarna: "text-[#06B6D4]",
    bgWarna: "bg-cyan-50",
    deskripsi: "Kamu merasa puas saat bisa berinteraksi, membantu, mendidik, atau melayani orang lain.",
    rekomendasi: "Keperawatan, Pekerjaan Sosial, Pariwisata, Perhotelan, Tata Boga.",
  },
  e: {
    nama: "Enterprising",
    label: "Pemimpin",
    warna: "bg-[#F59E0B]",
    teksWarna: "text-[#F59E0B]",
    bgWarna: "bg-amber-50",
    deskripsi: "Kamu memengaruhi orang lain, berani mengambil keputusan, dan mengejar target bisnis atau organisasi.",
    rekomendasi: "Bisnis Daring dan Pemasaran, Manajemen Perkantoran, Usaha Perjalanan Wisata.",
  },
  c: {
    nama: "Conventional",
    label: "Teratur",
    warna: "bg-[#10B981]",
    teksWarna: "text-[#10B981]",
    bgWarna: "bg-emerald-50",
    deskripsi: "Kamu senang dengan pekerjaan yang rapi, terstruktur, detail, dan bekerja dengan data atau aturan yang jelas.",
    rekomendasi: "Akuntansi dan Keuangan Lembaga, Otomatisasi Tata Kelola Perkantoran, Perbankan.",
  },
};

export function slugify(text: string): string {
  return text
    .toLowerCase()
    .trim()
    .replace(/[^a-z0-9\s-]/g, "")
    .replace(/\s+/g, "-")
    .replace(/-+/g, "-");
}

export interface JurusanDetail {
  nama: string;
  deskripsi: string;
  kompetensi: Array<{ judul: string; desc: string }>;
  karir: Array<{ jabatan: string; potensi: string }>;
}

// Detail jurusan (subset yang dipakai oleh REKOM_JURUSAN di atas), diporting dari
// resources/views/siswa/jurusan-detail.blade.php.
export const JURUSAN_DATA: Record<string, JurusanDetail> = {
  "teknik-kendaraan-ringan": {
    nama: "Teknik Kendaraan Ringan",
    deskripsi:
      "Mempelajari perawatan, perbaikan, dan diagnosis kerusakan kendaraan roda empat, mulai dari mesin konvensional hingga sistem kendaraan modern berbasis sensor.",
    kompetensi: [
      { judul: "Perawatan Mesin", desc: "Servis berkala, tune-up, dan perawatan sistem mesin kendaraan." },
      { judul: "Sistem Kelistrikan", desc: "Diagnosa dan perbaikan sistem kelistrikan & elektronik kendaraan." },
      { judul: "Chassis & Suspensi", desc: "Perawatan rem, kemudi, dan sistem suspensi kendaraan." },
    ],
    karir: [
      { jabatan: "Teknisi Otomotif", potensi: "High Demand" },
      { jabatan: "Service Advisor", potensi: "Growing" },
      { jabatan: "Wirausaha Bengkel", potensi: "Stabil" },
    ],
  },
  "teknik-mesin": {
    nama: "Teknik Mesin",
    deskripsi:
      "Fokus pada perancangan, pembuatan, dan pemeliharaan komponen mesin industri, termasuk proses pemesinan (CNC), pengelasan, dan fabrikasi logam.",
    kompetensi: [
      { judul: "Pemesinan CNC", desc: "Mengoperasikan mesin bubut & frais berbasis komputer." },
      { judul: "Pengelasan", desc: "Teknik las yang aman dan sesuai standar industri." },
      { judul: "Gambar Teknik", desc: "Membaca dan membuat gambar kerja komponen mesin." },
    ],
    karir: [
      { jabatan: "Operator CNC", potensi: "High Demand" },
      { jabatan: "Teknisi Manufaktur", potensi: "Growing" },
      { jabatan: "Quality Control", potensi: "Stabil" },
    ],
  },
  "teknik-komputer-dan-jaringan": {
    nama: "Teknik Komputer dan Jaringan",
    deskripsi:
      "Mempelajari cara instalasi jaringan LAN/WAN, keamanan siber, hingga administrasi server, membekali siswa dengan pemahaman arsitektur jaringan modern dan protokol keamanan data.",
    kompetensi: [
      { judul: "Perancangan Jaringan", desc: "Arsitektur LAN/WAN, routing, switching, dan optimasi trafik data." },
      { judul: "Troubleshooting Hardware", desc: "Diagnosa kerusakan perangkat keras dan pemeliharaan server." },
      { judul: "Administrasi Linux", desc: "Manajemen sistem operasi server berbasis open-source." },
    ],
    karir: [
      { jabatan: "Network Engineer", potensi: "High Demand" },
      { jabatan: "IT Support", potensi: "Growing" },
      { jabatan: "Cybersecurity Analyst", potensi: "Specialist" },
    ],
  },
  "rekayasa-perangkat-lunak": {
    nama: "Rekayasa Perangkat Lunak",
    deskripsi:
      "Mempelajari cara merancang, membangun, dan menguji aplikasi/website, mulai dari logika pemrograman dasar hingga pengembangan produk digital siap pakai.",
    kompetensi: [
      { judul: "Pemrograman Web", desc: "Membangun website dan aplikasi berbasis web." },
      { judul: "Basis Data", desc: "Merancang dan mengelola struktur data aplikasi." },
      { judul: "Pengembangan Mobile", desc: "Membuat aplikasi untuk perangkat Android/iOS." },
    ],
    karir: [
      { jabatan: "Software Engineer", potensi: "High Demand" },
      { jabatan: "Web Developer", potensi: "High Demand" },
      { jabatan: "QA Tester", potensi: "Growing" },
    ],
  },
  farmasi: {
    nama: "Farmasi",
    deskripsi:
      "Mempelajari cara meracik, mengelola, dan mendistribusikan obat-obatan dengan aman, termasuk dasar-dasar kimia farmasi dan pelayanan kefarmasian.",
    kompetensi: [
      { judul: "Peracikan Obat", desc: "Teknik dasar meracik dan mengemas sediaan farmasi." },
      { judul: "Kimia Farmasi", desc: "Analisis kandungan dan kualitas bahan obat." },
      { judul: "Pelayanan Kefarmasian", desc: "Standar pelayanan obat di apotek dan rumah sakit." },
    ],
    karir: [
      { jabatan: "Asisten Apoteker", potensi: "High Demand" },
      { jabatan: "Staf Gudang Farmasi", potensi: "Stabil" },
      { jabatan: "Sales Farmasi", potensi: "Growing" },
    ],
  },
  "desain-komunikasi-visual": {
    nama: "Desain Komunikasi Visual",
    deskripsi:
      "Mempelajari cara menyampaikan pesan lewat visual: logo, poster, kemasan, hingga materi digital, memadukan kreativitas dengan prinsip desain dan software desain profesional.",
    kompetensi: [
      { judul: "Desain Grafis", desc: "Olah visual menggunakan software desain profesional." },
      { judul: "Tipografi & Layout", desc: "Menyusun tata letak dan huruf yang komunikatif." },
      { judul: "Branding", desc: "Membangun identitas visual sebuah merek/produk." },
    ],
    karir: [
      { jabatan: "Graphic Designer", potensi: "High Demand" },
      { jabatan: "Content Creator", potensi: "High Demand" },
      { jabatan: "UI/UX Designer", potensi: "Growing" },
    ],
  },
  multimedia: {
    nama: "Multimedia",
    deskripsi:
      "Mempelajari produksi konten audio-visual: videografi, animasi, dan editing, untuk kebutuhan hiburan, promosi, hingga media digital.",
    kompetensi: [
      { judul: "Videografi", desc: "Teknik pengambilan gambar bergerak yang sinematik." },
      { judul: "Editing Video", desc: "Menyunting footage jadi konten video yang menarik." },
      { judul: "Animasi 2D/3D", desc: "Membuat animasi untuk iklan, film, atau game." },
    ],
    karir: [
      { jabatan: "Video Editor", potensi: "High Demand" },
      { jabatan: "Animator", potensi: "Growing" },
      { jabatan: "Motion Graphic Designer", potensi: "Specialist" },
    ],
  },
  "tata-busana": {
    nama: "Tata Busana",
    deskripsi:
      "Mempelajari proses merancang, membuat pola, hingga menjahit pakaian, memadukan kreativitas mode dengan keterampilan teknis produksi busana.",
    kompetensi: [
      { judul: "Desain Busana", desc: "Merancang model pakaian sesuai tren dan kebutuhan." },
      { judul: "Pembuatan Pola", desc: "Teknik membuat pola dasar hingga pola siap potong." },
      { judul: "Menjahit", desc: "Teknik menjahit busana rapi dan sesuai standar." },
    ],
    karir: [
      { jabatan: "Fashion Designer", potensi: "Growing" },
      { jabatan: "Penjahit Profesional", potensi: "Stabil" },
      { jabatan: "Wirausaha Konveksi", potensi: "Stabil" },
    ],
  },
  keperawatan: {
    nama: "Keperawatan",
    deskripsi:
      "Mempelajari dasar-dasar perawatan pasien, pertolongan pertama, dan prosedur medis dasar untuk membantu tenaga medis dalam pelayanan kesehatan.",
    kompetensi: [
      { judul: "Perawatan Dasar", desc: "Prosedur perawatan pasien sehari-hari." },
      { judul: "Pertolongan Pertama", desc: "Penanganan awal kondisi darurat medis." },
      { judul: "Komunikasi Terapeutik", desc: "Cara berkomunikasi efektif dengan pasien." },
    ],
    karir: [
      { jabatan: "Asisten Perawat", potensi: "High Demand" },
      { jabatan: "Caregiver", potensi: "Growing" },
      { jabatan: "Staf Puskesmas", potensi: "Stabil" },
    ],
  },
  "tata-boga": {
    nama: "Tata Boga",
    deskripsi:
      "Mempelajari seni mengolah makanan, dari teknik memasak dasar hingga manajemen dapur profesional dan penyajian hidangan.",
    kompetensi: [
      { judul: "Teknik Memasak", desc: "Metode olah pangan dari dasar hingga lanjutan." },
      { judul: "Pastry & Bakery", desc: "Pembuatan roti, kue, dan produk pastry." },
      { judul: "Manajemen Dapur", desc: "Pengelolaan operasional dapur profesional." },
    ],
    karir: [
      { jabatan: "Chef / Juru Masak", potensi: "High Demand" },
      { jabatan: "Baker/Pastry Chef", potensi: "Growing" },
      { jabatan: "Wirausaha Kuliner", potensi: "Stabil" },
    ],
  },
  perhotelan: {
    nama: "Perhotelan",
    deskripsi:
      "Mempelajari standar pelayanan tamu, operasional hotel, dan manajemen akomodasi untuk industri pariwisata dan perhotelan.",
    kompetensi: [
      { judul: "Front Office", desc: "Standar pelayanan resepsionis dan reservasi tamu." },
      { judul: "Housekeeping", desc: "Standar kebersihan dan kerapian kamar hotel." },
      { judul: "Food & Beverage Service", desc: "Pelayanan makanan & minuman untuk tamu." },
    ],
    karir: [
      { jabatan: "Front Office Staff", potensi: "High Demand" },
      { jabatan: "Housekeeping Staff", potensi: "Stabil" },
      { jabatan: "Event Coordinator", potensi: "Growing" },
    ],
  },
  "bisnis-daring-dan-pemasaran": {
    nama: "Bisnis Daring dan Pemasaran",
    deskripsi:
      "Mempelajari strategi pemasaran modern termasuk pemasaran digital, pengelolaan toko online, dan analisis perilaku konsumen.",
    kompetensi: [
      { judul: "Digital Marketing", desc: "Strategi promosi produk lewat media digital." },
      { judul: "E-Commerce", desc: "Pengelolaan toko online dan transaksi digital." },
      { judul: "Riset Pasar", desc: "Analisis tren dan perilaku konsumen." },
    ],
    karir: [
      { jabatan: "Digital Marketer", potensi: "High Demand" },
      { jabatan: "Admin Toko Online", potensi: "High Demand" },
      { jabatan: "Social Media Specialist", potensi: "Growing" },
    ],
  },
  perbankan: {
    nama: "Perbankan",
    deskripsi:
      "Mempelajari operasional dasar lembaga keuangan/perbankan, termasuk layanan nasabah, transaksi, dan produk-produk perbankan.",
    kompetensi: [
      { judul: "Layanan Nasabah", desc: "Standar pelayanan transaksi & keluhan nasabah." },
      { judul: "Transaksi Perbankan", desc: "Prosedur transaksi tunai dan non-tunai." },
      { judul: "Produk Keuangan", desc: "Pemahaman produk tabungan, kredit, dan investasi dasar." },
    ],
    karir: [
      { jabatan: "Teller Bank", potensi: "Stabil" },
      { jabatan: "Customer Service Bank", potensi: "Growing" },
      { jabatan: "Staf Administrasi Keuangan", potensi: "Stabil" },
    ],
  },
  akuntansi: {
    nama: "Akuntansi",
    deskripsi:
      "Mempelajari pencatatan, pengelolaan, dan pelaporan keuangan suatu usaha atau lembaga secara akurat dan sesuai standar akuntansi.",
    kompetensi: [
      { judul: "Pembukuan", desc: "Pencatatan transaksi keuangan secara sistematis." },
      { judul: "Laporan Keuangan", desc: "Penyusunan neraca dan laporan laba rugi." },
      { judul: "Software Akuntansi", desc: "Penggunaan aplikasi akuntansi digital." },
    ],
    karir: [
      { jabatan: "Staf Akuntansi", potensi: "High Demand" },
      { jabatan: "Bookkeeper", potensi: "Growing" },
      { jabatan: "Auditor Junior", potensi: "Specialist" },
    ],
  },
  "administrasi-perkantoran": {
    nama: "Administrasi Perkantoran",
    deskripsi:
      "Mempelajari pengelolaan administrasi kantor modern, termasuk kearsipan, korespondensi, dan penggunaan aplikasi perkantoran digital.",
    kompetensi: [
      { judul: "Kearsipan Digital", desc: "Pengelolaan dan penyimpanan dokumen secara digital." },
      { judul: "Korespondensi", desc: "Penulisan surat dan komunikasi bisnis formal." },
      { judul: "Aplikasi Perkantoran", desc: "Penggunaan software pengolah kata & spreadsheet." },
    ],
    karir: [
      { jabatan: "Staf Administrasi", potensi: "High Demand" },
      { jabatan: "Sekretaris", potensi: "Stabil" },
      { jabatan: "Admin Kantor", potensi: "Growing" },
    ],
  },
};

export const POTENSI_WARNA: Record<string, string> = {
  "High Demand": "bg-[#a7f3d0] text-[#047857]",
  Growing: "bg-[#e0e7ff] text-[#4f46e5]",
  Specialist: "bg-[#ffedd5] text-[#c2410c]",
  Stabil: "bg-[#e0f2fe] text-[#0284c7]",
};
