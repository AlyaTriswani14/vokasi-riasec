"use client";

import { useState, useEffect } from "react";
import { useRouter } from "next/navigation";
import { UserCheck, MapPin, School, Hash, BookOpen } from "lucide-react";

interface Item {
  kode: string;
  nama: string;
}

export default function LengkapiProfilPage() {
  const router = useRouter();

  const [name, setName] = useState("");
  const [nisn, setNisn] = useState("");
  const [asalSekolah, setAsalSekolah] = useState("");
  const [kelas, setKelas] = useState("9");

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

  useEffect(() => {
    // Load session user and provincial list
    fetch("/api/auth/session")
      .then((res) => res.json())
      .then((data) => {
        if (!data.authenticated) {
          router.push("/login");
        } else if (data.user) {
          setName(data.user.name || "");
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
    <main className="min-h-screen bg-slate-50 flex items-center justify-center p-4 py-8">
      <div className="w-full max-w-lg bg-white rounded-3xl shadow-xl p-8 border border-slate-100">
        <div className="text-center mb-6">
          <div className="w-12 h-12 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center mx-auto mb-3">
            <UserCheck className="w-7 h-7" />
          </div>
          <h1 className="text-2xl font-extrabold text-slate-800">Lengkapi Profil Siswa</h1>
          <p className="text-xs text-slate-500 mt-1">
            Data ini digunakan untuk merekomendasikan SMK terdekat di wilayahmu.
          </p>
        </div>

        {error && (
          <div className="bg-rose-50 text-rose-600 border border-rose-200 text-xs p-3 rounded-xl mb-4 font-medium">
            {error}
          </div>
        )}

        <form onSubmit={handleSubmit} className="space-y-4">
          <div>
            <label className="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap</label>
            <input
              type="text"
              required
              value={name}
              onChange={(e) => setName(e.target.value)}
              className="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
            />
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label className="block text-xs font-bold text-slate-700 mb-1">NISN (10 Digit)</label>
              <input
                type="text"
                required
                maxLength={10}
                value={nisn}
                onChange={(e) => setNisn(e.target.value.replace(/\D/g, ""))}
                placeholder="1234567890"
                className="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
              />
            </div>

            <div>
              <label className="block text-xs font-bold text-slate-700 mb-1">Kelas</label>
              <select
                value={kelas}
                onChange={(e) => setKelas(e.target.value)}
                className="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
              >
                <option value="7">Kelas 7 SMP</option>
                <option value="8">Kelas 8 SMP</option>
                <option value="9">Kelas 9 SMP</option>
                <option value="10">Kelas 10 SMK</option>
                <option value="11">Kelas 11 SMK</option>
                <option value="12">Kelas 12 SMK</option>
              </select>
            </div>
          </div>

          <div>
            <label className="block text-xs font-bold text-slate-700 mb-1">Asal Sekolah</label>
            <input
              type="text"
              required
              value={asalSekolah}
              onChange={(e) => setAsalSekolah(e.target.value)}
              placeholder="Contoh: SMPN 1 Jakarta"
              className="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
            />
          </div>

          <div className="border-t border-slate-100 pt-4 mt-2">
            <h3 className="text-xs font-extrabold uppercase text-purple-600 mb-3 flex items-center gap-1">
              <MapPin className="w-4 h-4" /> Domisili Tempat Tinggal
            </h3>

            <div className="space-y-3">
              <div>
                <label className="block text-xs font-semibold text-slate-600 mb-1">Provinsi</label>
                <select
                  required
                  value={selectedProv}
                  onChange={(e) => handleProvChange(e.target.value)}
                  className="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                >
                  <option value="">-- Pilih Provinsi --</option>
                  {provinsiList.map((p) => (
                    <option key={p.kode} value={p.kode}>{p.nama}</option>
                  ))}
                </select>
              </div>

              <div>
                <label className="block text-xs font-semibold text-slate-600 mb-1">Kabupaten / Kota</label>
                <select
                  required
                  disabled={!selectedProv}
                  value={selectedKab}
                  onChange={(e) => handleKabChange(e.target.value)}
                  className="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 disabled:opacity-50"
                >
                  <option value="">-- Pilih Kabupaten/Kota --</option>
                  {kabKotaList.map((k) => (
                    <option key={k.kode} value={k.kode}>{k.nama}</option>
                  ))}
                </select>
              </div>

              <div>
                <label className="block text-xs font-semibold text-slate-600 mb-1">Kecamatan</label>
                <select
                  required
                  disabled={!selectedKab}
                  value={selectedKec}
                  onChange={(e) => handleKecChange(e.target.value)}
                  className="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 disabled:opacity-50"
                >
                  <option value="">-- Pilih Kecamatan --</option>
                  {kecamatanList.map((kc) => (
                    <option key={kc.kode} value={kc.kode}>{kc.nama}</option>
                  ))}
                </select>
              </div>

              <div>
                <label className="block text-xs font-semibold text-slate-600 mb-1">Kelurahan / Desa</label>
                <select
                  required
                  disabled={!selectedKec}
                  value={selectedKel}
                  onChange={(e) => setSelectedKel(e.target.value)}
                  className="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 disabled:opacity-50"
                >
                  <option value="">-- Pilih Kelurahan/Desa --</option>
                  {kelurahanList.map((kl) => (
                    <option key={kl.kode} value={kl.kode}>{kl.nama}</option>
                  ))}
                </select>
              </div>
            </div>
          </div>

          <button
            type="submit"
            disabled={loading}
            className="w-full mt-6 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-purple-200 transition-all text-sm"
          >
            {loading ? "Memproses..." : "Simpan Profil & Lanjutkan"}
          </button>
        </form>
      </div>
    </main>
  );
}
