"use client";

import { useState, useEffect } from "react";
import { useRouter } from "next/navigation";
import { GraduationCap, ArrowRight } from "lucide-react";

interface Item {
  kode: string;
  nama: string;
}

export default function LengkapiProfilPage() {
  const router = useRouter();

  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [jenjang, setJenjang] = useState<"smp" | "smk">("smp");
  const [nisn, setNisn] = useState("");
  const [asalSekolah, setAsalSekolah] = useState("");
  const [kelas, setKelas] = useState("");
  const [setuju, setSetuju] = useState(false);

  const [provinsiList, setProvinsiList] = useState<Item[]>([]);
  const [kabKotaList, setKabKotaList] = useState<Item[]>([]);
  const [kecamatanList, setKecamatanList] = useState<Item[]>([]);
  const [kelurahanList, setKelurahanList] = useState<Item[]>([]);

  const [selectedProv, setSelectedProv] = useState("");
  const [selectedKab, setSelectedKab] = useState("");
  const [selectedKec, setSelectedKec] = useState("");
  const [selectedKel, setSelectedKel] = useState("");

  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);

  const kelasOptions = jenjang === "smk" ? [10, 11, 12, 13] : [7, 8, 9];

  useEffect(() => {
    fetch("/api/auth/session")
      .then((res) => res.json())
      .then((data) => {
        if (!data.authenticated) {
          router.push("/login");
        } else if (data.user) {
          setName(data.user.name || "");
          setEmail(data.user.email || "");
          setJenjang(data.user.jenjang === "smk" ? "smk" : "smp");
          setNisn(data.user.nisn || "");
          setAsalSekolah(data.user.asal_sekolah || "");
          if (data.user.kelas) setKelas(data.user.kelas);
        }
      });

    fetch("/api/wilayah/provinsi")
      .then((res) => res.json())
      .then((data) => {
        if (Array.isArray(data)) setProvinsiList(data);
      });
  }, [router]);

  const handleProvChange = async (kode: string) => {
    setSelectedProv(kode);
    setSelectedKab("");
    setSelectedKec("");
    setSelectedKel("");
    setKabKotaList([]);
    setKecamatanList([]);
    setKelurahanList([]);

    if (!kode) return;
    const res = await fetch(`/api/wilayah/kabupaten-kota/${kode}`);
    const data = await res.json();
    if (Array.isArray(data)) setKabKotaList(data);
  };

  const handleKabChange = async (kode: string) => {
    setSelectedKab(kode);
    setSelectedKec("");
    setSelectedKel("");
    setKecamatanList([]);
    setKelurahanList([]);

    if (!kode) return;
    const res = await fetch(`/api/wilayah/kecamatan/${kode}`);
    const data = await res.json();
    if (Array.isArray(data)) setKecamatanList(data);
  };

  const handleKecChange = async (kode: string) => {
    setSelectedKec(kode);
    setSelectedKel("");
    setKelurahanList([]);

    if (!kode) return;
    const res = await fetch(`/api/wilayah/kelurahan/${kode}`);
    const data = await res.json();
    if (Array.isArray(data)) setKelurahanList(data);
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError("");

    if (nisn.length !== 10) {
      setError("NISN harus berisi tepat 10 digit.");
      return;
    }

    if (!setuju) {
      setError("Kamu harus menyetujui bahwa data di atas benar.");
      return;
    }

    const provObj = provinsiList.find((p) => p.kode === selectedProv);
    const kabObj = kabKotaList.find((k) => k.kode === selectedKab);
    const kecObj = kecamatanList.find((kc) => kc.kode === selectedKec);
    const kelObj = kelurahanList.find((kl) => kl.kode === selectedKel);

    if (!provObj || !kabObj || !kecObj || !kelObj) {
      setError("Silakan lengkapi pilihan domisili (Provinsi, Kab/Kota, Kecamatan, Kelurahan).");
      return;
    }

    setLoading(true);

    try {
      const res = await fetch("/api/auth/lengkapi-profil", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          name,
          nisn,
          asal_sekolah: asalSekolah,
          kelas,
          provinsi: provObj.nama,
          kabupaten_kota: kabObj.nama,
          kecamatan: kecObj.nama,
          kelurahan: kelObj.nama,
        }),
      });

      const data = await res.json();
      if (!res.ok) {
        throw new Error(data.error || "Gagal memperbarui profil.");
      }

      router.push("/dashboard");
    } catch (err: any) {
      setError(err.message);
    } finally {
      setLoading(false);
    }
  };

  return (
    <main className="bg-[#f8fafc] font-sans text-gray-800 min-h-screen flex items-center justify-center relative overflow-x-hidden py-10 px-4">
      <div className="absolute w-72 h-72 bg-gradient-to-br from-[#7C3AED] to-[#EC4899] opacity-20 rounded-full -top-16 -left-16 pointer-events-none" />
      <div className="absolute w-72 h-72 bg-gradient-to-br from-[#22C1C3] to-[#2F6FED] opacity-20 rounded-full -bottom-16 -right-10 pointer-events-none" />

      <div className="w-full max-w-lg relative z-10">
        <div className="flex items-center justify-center gap-2 text-[#003366] font-bold text-lg mb-8">
          <GraduationCap className="w-5 h-5" />
          <span>Bakat Minat</span>
        </div>

        <div className="bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 p-6 md:p-10">
          <div className="flex items-center gap-2 mb-4">
            <div className="w-10 h-1.5 rounded-full bg-gradient-to-r from-[#7C3AED] to-[#EC4899]" />
            <div className="w-10 h-1.5 rounded-full bg-gradient-to-r from-[#7C3AED] to-[#EC4899]" />
            <div className="w-10 h-1.5 rounded-full bg-gradient-to-r from-[#7C3AED] to-[#EC4899]" />
          </div>

          <p
            className={`text-[10px] font-bold uppercase tracking-widest text-white inline-block px-4 py-1.5 rounded-full mb-4 ${
              jenjang === "smk"
                ? "bg-gradient-to-r from-[#2F6FED] to-[#22C1C3]"
                : "bg-gradient-to-r from-[#FF7A45] to-[#FFB13D]"
            }`}
          >
            Langkah 3 dari 3
          </p>
          <h1 className="text-xl md:text-2xl font-extrabold text-[#003366] mb-2">Lengkapi profilmu</h1>
          <p className="text-gray-500 text-sm mb-8">
            Data ini dipakai untuk mencocokkan hasil tesmu dengan sekolah dan rekomendasi jurusan.
          </p>

          {error && (
            <div className="mb-4 bg-red-50 border border-red-200 text-red-600 text-xs rounded-xl p-3">{error}</div>
          )}

          <form onSubmit={handleSubmit} className="space-y-4">
            <div className="space-y-1.5">
              <label className="block text-xs font-bold text-gray-500 uppercase tracking-wider">Nama lengkap</label>
              <input
                type="text"
                required
                value={name}
                onChange={(e) => setName(e.target.value)}
                className="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm transition"
              />
              <p className="text-[10px] text-gray-400 italic">Diambil dari akun Google, sesuaikan jika belum lengkap.</p>
            </div>

            <div className="space-y-1.5">
              <label className="block text-xs font-bold text-gray-500 uppercase tracking-wider">Email (dari Google)</label>
              <input
                type="text"
                value={email}
                disabled
                className="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-sm text-gray-500"
              />
            </div>

            <div className="space-y-1.5">
              <label className="block text-xs font-bold text-gray-500 uppercase tracking-wider">NISN</label>
              <input
                type="text"
                required
                maxLength={10}
                placeholder="10 digit Nomor Induk Siswa Nasional"
                value={nisn}
                onChange={(e) => setNisn(e.target.value.replace(/\D/g, ""))}
                className="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm transition"
              />
            </div>

            <div className="space-y-1.5">
              <label className="block text-xs font-bold text-gray-500 uppercase tracking-wider">Asal sekolah</label>
              <input
                type="text"
                required
                placeholder={jenjang === "smk" ? "Contoh: SMK Negeri 1 Jakarta" : "Contoh: SMP Negeri 1 Jakarta"}
                value={asalSekolah}
                onChange={(e) => setAsalSekolah(e.target.value)}
                className="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm transition"
              />
            </div>

            <div className="space-y-1.5">
              <label className="block text-xs font-bold text-gray-500 uppercase tracking-wider">Kelas</label>
              <select
                required
                value={kelas}
                onChange={(e) => setKelas(e.target.value)}
                className="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm transition"
              >
                <option value="" disabled>Pilih kelas</option>
                {kelasOptions.map((k) => (
                  <option key={k} value={k}>Kelas {k}</option>
                ))}
              </select>
            </div>

            <div className="pt-1">
              <label className="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Domisili Saat Ini</label>
              <p className="text-[10px] text-gray-400 italic mb-3">
                Dipakai untuk mencocokkan rekomendasi SMK terdekat dari tempat tinggalmu.
              </p>

              <div className="space-y-3">
                <div className="space-y-1.5">
                  <label className="block text-xs font-bold text-gray-500 uppercase tracking-wider">Provinsi</label>
                  <select
                    required
                    value={selectedProv}
                    onChange={(e) => handleProvChange(e.target.value)}
                    className="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm transition"
                  >
                    <option value="" disabled>Memuat provinsi...</option>
                    {provinsiList.map((p) => (
                      <option key={p.kode} value={p.kode}>{p.nama}</option>
                    ))}
                  </select>
                </div>

                <div className="space-y-1.5">
                  <label className="block text-xs font-bold text-gray-500 uppercase tracking-wider">Kabupaten/Kota</label>
                  <select
                    required
                    disabled={!selectedProv}
                    value={selectedKab}
                    onChange={(e) => handleKabChange(e.target.value)}
                    className="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm transition disabled:bg-gray-100 disabled:text-gray-400"
                  >
                    <option value="" disabled>Pilih provinsi dulu</option>
                    {kabKotaList.map((k) => (
                      <option key={k.kode} value={k.kode}>{k.nama}</option>
                    ))}
                  </select>
                </div>

                <div className="space-y-1.5">
                  <label className="block text-xs font-bold text-gray-500 uppercase tracking-wider">Kecamatan</label>
                  <select
                    required
                    disabled={!selectedKab}
                    value={selectedKec}
                    onChange={(e) => handleKecChange(e.target.value)}
                    className="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm transition disabled:bg-gray-100 disabled:text-gray-400"
                  >
                    <option value="" disabled>Pilih kabupaten/kota dulu</option>
                    {kecamatanList.map((kc) => (
                      <option key={kc.kode} value={kc.kode}>{kc.nama}</option>
                    ))}
                  </select>
                </div>

                <div className="space-y-1.5">
                  <label className="block text-xs font-bold text-gray-500 uppercase tracking-wider">Kelurahan/Desa</label>
                  <select
                    required
                    disabled={!selectedKec}
                    value={selectedKel}
                    onChange={(e) => setSelectedKel(e.target.value)}
                    className="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm transition disabled:bg-gray-100 disabled:text-gray-400"
                  >
                    <option value="" disabled>Pilih kecamatan dulu</option>
                    {kelurahanList.map((kl) => (
                      <option key={kl.kode} value={kl.kode}>{kl.nama}</option>
                    ))}
                  </select>
                </div>
              </div>
            </div>

            <label className="flex items-start gap-2 text-xs text-gray-500 pt-2">
              <input
                type="checkbox"
                required
                checked={setuju}
                onChange={(e) => setSetuju(e.target.checked)}
                className="mt-0.5"
              />
              Saya menyetujui bahwa data di atas benar dan digunakan untuk keperluan asesmen ini.
            </label>

            <button
              type="submit"
              disabled={loading}
              className="w-full bg-[#003E70] hover:bg-[#002B4E] text-white py-3.5 px-6 rounded-full font-bold text-sm flex items-center justify-center gap-2 shadow-lg shadow-blue-900/10 transition duration-200 mt-2 disabled:opacity-60"
            >
              {loading ? "Memproses..." : "Simpan dan Lanjutkan"} <ArrowRight className="w-4 h-4" />
            </button>
          </form>
        </div>
      </div>
    </main>
  );
}
