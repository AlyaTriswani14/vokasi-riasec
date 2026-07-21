# Ekosistem Vokasi RIASEC (Next.js & Vercel Ready)

Platform Asesmen Minat Bakat Holland (RIASEC) Vokasi Kementerian Pendidikan Dasar dan Menengah RI. Project ini dibangun menggunakan **Next.js (App Router)**, **React 19**, **Tailwind CSS**, dan **Prisma ORM** yang fully compatible dengan deployment **Vercel**.

---

## 🔑 Default Credentials (Akses Admin)

### 1. Admin Direktorat SMK (Kemendikdasmen)
- **URL Login**: `/kemendikdasmen/login`
- **Email**: `admin@kemendikdasmen.go.id`
- **Password**: `password123`
- **Akses**: Kelola User Management Sekolah, Bank Soal RIASEC, Pengaturan Durasi/Kuota Sistem, Broadcast Pengumuman Massal.

### 2. Admin Sekolah (Guru BK Binaan)
- **URL Login**: `/guru-bk/login`
- **Email**: `gurubk@smkn1jakarta.sch.id`
- **Password**: `password123`
- **Akses**: Pantau daftar siswa binaan sekolah, status tes RIASEC, breakdown persentase minat siswa, Export CSV hasil tes.

---

## 🌱 Skrip Seeder (Pertama Kali Install di Vercel / Lokal)

Tersedia **3 Cara** untuk menjalankan skrip seeder saat pertama kali melakukan instalasi di Vercel atau environment lokal:

### Cara 1: Via Endpoint HTTP 1-Click (Rekomendasi Utama di Vercel)
Setelah aplikasi di-deploy di Vercel, Anda dapat membuka URL endpoint berikut di browser atau cURL:
```text
https://DOMAIN-VERCEL-ANDA.vercel.app/api/seed
```
Endpoint ini menggunakan `upsert` aman sehingga dapat dipanggil kapan saja tanpa merusak data yang sudah ada.

### Cara 2: Skrip CLI Lokal
```bash
npm run prisma:seed
# atau
npx prisma db seed
```

### Cara 3: Otomatisasi Build Command Vercel (Opsi)
Jika Anda menggunakan database serverless (seperti Vercel Postgres, Neon, atau Supabase), Anda bisa menyetel **Build Command** pada Vercel Settings menjadi:
```bash
prisma generate && prisma db push --accept-data-loss && npm run prisma:seed && next build
```

---

## 🚀 Cara Menjalankan Aplikasi Secara Lokal

1. **Install Dependensi**:
   ```bash
   npm install
   ```

2. **Migrasi Database & Seed Data**:
   ```bash
   npx prisma db push
   npm run prisma:seed
   ```

3. **Jalankan Development Server**:
   ```bash
   npm run dev
   ```
   Buka [http://localhost:3000](http://localhost:3000) pada browser.

---

## ☁️ Deployment ke Vercel

1. Push repository ke GitHub / GitLab / Bitbucket.
2. Import repository di [Vercel Dashboard](https://vercel.com).
3. Set Environment Variable pada Vercel Settings:
   - `DATABASE_URL`: `file:./dev.db` (atau URL Vercel Postgres / Neon / Supabase untuk produksi serverless)
   - `JWT_SECRET`: `vokasi-riasec-secret-key-2026-super-secure`
4. Klik **Deploy**.
5. Akses `https://DOMAIN-VERCEL-ANDA.vercel.app/api/seed` untuk inisialisasi awal data seeder di Vercel.

---

## 🌟 Fitur Utama

- **Siswa**:
  - Pemilihan Jenjang (SMP / SMK).
  - Autentikasi & Pengisian Profil Domisili bertingkat (Provinsi -> Kabupaten/Kota -> Kecamatan -> Kelurahan).
  - Tes RIASEC dengan Timer Countdown interaktif.
  - Hasil & Rekomendasi Jurusan Vokasi beserta pencarian **SMK Terdekat** bertingkat (*Sekelurahan -> Sekecamatan -> Sekabupaten/Kota -> Seprovinsi*).
  - Eksplorasi Keahlian & Detail Jurusan Vokasi.

- **Guru BK**:
  - Dashboard pemantauan siswa binaan.
  - Detail breakdown poin & persentase aspek RIASEC siswa.
  - Export data hasil tes ke format CSV.

- **Admin Kemendikdasmen**:
  - Analytics Nasional.
  - User Management (Kelola Sekolah & Guru BK).
  - Bank Soal RIASEC (CRUD & Status Soal).
  - System Settings (Durasi Timer Tes, Target Kuota, Tahun Ajaran).
  - Broadcast Center.
