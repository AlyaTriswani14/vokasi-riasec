"use client";

import { useState, useEffect } from "react";
import { useRouter } from "next/navigation";
import BottomNav from "@/components/BottomNav";
import TopHeader from "@/components/TopHeader";
import { getJenjangTheme } from "@/lib/theme";
import { LogOut, Save } from "lucide-react";

interface WilayahOption {
  kode: string;
  nama: string;
}

export default function ProfilPage() {
  const router = useRouter();

  const [jenjang, setJenjang] = useState<string | null | undefined>(undefined);
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [nisn, setNisn] = useState("");
  const [asalSekolah, setAsalSekolah] = useState("");
  const [kelas, setKelas] = useState("");

  const [provinsi, setProvinsi] = useState("");
  const [kabupatenKota, setKabupatenKota] = useState("");
  const [kecamatan, setKecamatan] = useState("");
  const [kelurahan, setKelurahan] = useState("");

  const [provinsiOptions, setProvinsiOptions] = useState<WilayahOption[]>([]);
  const [kabKotaOptions, setKabKotaOptions] = useState<WilayahOption[]>([]);
  const [kecamatanOptions, setKecamatanOptions] = useState<WilayahOption[]>([]);
  const [kelurahanOptions, setKelurahanOptions] = useState<WilayahOption[]>([]);

  const [loading, setLoading] = useState(true);
  const [updating, setUpdating] = useState(false);
  const [message, setMessage] = useState("");
  const [error, setError] = useState("");

  const theme = getJenjangTheme(jenjang);
  const kelasOptions = theme.isSmk ? ["10", "11", "12", "13"] : ["7", "8", "9"];

  // Load session + initial wilayah chain
  useEffect(() => {
    fetch("/api/auth/session")
      .then((res) => res.json())
      .then(async (data) => {
        if (!data.authenticated) {
          router.push("/login");
          return;
        }
        const u = data.user;
        setJenjang(u.jenjang ?? null);
        setName(u.name || "");
        setEmail(u.email || "");
        setNisn(u.nisn || "");
        setAsalSekolah(u.asal_sekolah || "");
        setKelas(u.kelas || "");
        setProvinsi(u.provinsi || "");
        setKabupatenKota(u.kabupaten_kota || "");
        setKecamatan(u.kecamatan || "");
        setKelurahan(u.kelurahan || "");

        // Load provinsi list, then cascade down to restore saved selections.
        const provRes = await fetch("/api/wilayah/provinsi").then((r) => r.json());
        setProvinsiOptions(provRes);

        const provKode = provRes.find((p: WilayahOption) => p.nama === u.provinsi)?.kode;
        if (provKode) {
          const kabRes = await fetch(`/api/wilayah/kabupaten-kota/${provKode}`).then((r) => r.json());
          setKabKotaOptions(kabRes);

          const kabKode = kabRes.find((k: WilayahOption) => k.nama === u.kabupaten_kota)?.kode;
          if (kabKode) {
            const kecRes = await fetch(`/api/wilayah/kecamatan/${kabKode}`).then((r) => r.json());
            setKecamatanOptions(kecRes);

            const kecKode = kecRes.find((k: WilayahOption) => k.nama === u.kecamatan)?.kode;
            if (kecKode) {
              const kelRes = await fetch(`/api/wilayah/kelurahan/${kecKode}`).then((r) => r.json());
              setKelurahanOptions(kelRes);
            }
          }
        }
      })
      .finally(() => setLoading(false));
  }, [router]);

  const handleProvinsiChange = async (kode: string, nama: string) => {
    setProvinsi(nama);
    setKabupatenKota("");
    setKecamatan("");
    setKelurahan("");
    setKabKotaOptions([]);
    setKecamatanOptions([]);
    setKelurahanOptions([]);
    if (!kode) return;
    const data = await fetch(`/api/wilayah/kabupaten-kota/${kode}`).then((r) => r.json());
    setKabKotaOptions(data);
  };

  const handleKabKotaChange = async (kode: string, nama: string) => {
    setKabupatenKota(nama);
    setKecamatan("");
    setKelurahan("");
    setKecamatanOptions([]);
    setKelurahanOptions([]);
    if (!kode) return;
    const data = await fetch(`/api/wilayah/kecamatan/${kode}`).then((r) => r.json());
    setKecamatanOptions(data);
  };

  const handleKecamatanChange = async (kode: string, nama: string) => {
    setKecamatan(nama);
    setKelurahan("");
    setKelurahanOptions([]);
    if (!kode) return;
    const data = await fetch(`/api/wilayah/kelurahan/${kode}`).then((r) => r.json());
    setKelurahanOptions(data);
  };

  const handleLogout = async () => {
    await fetch("/api/auth/logout", { method: "POST" });
    router.push("/login");
  };

  const handleUpdate = async (e: React.FormEvent) => {
    e.preventDefault();
    setMessage("");
    setError("");
    setUpdating(true);

    try {
      const res = await fetch("/api/auth/lengkapi-profil", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          name,
          nisn,
          asal_sekolah: asalSekolah,
          kelas,
          provinsi,
          kabupaten_kota: kabupatenKota,
          kecamatan,
          kelurahan,
        }),
      });

      const data = await res.json();
      if (!res.ok) throw new Error(data.error || "Gagal mengupdate profil.");
      setMessage("Data diri berhasil diperbarui.");
    } catch (err: any) {
      setError(err.message);
    } finally {
      setUpdating(false);
    }
  };

  if (loading) {
    return (
      <main className="min-h-screen bg-[#f8fafc] flex items-center justify-center p-4">
        <div className="text-center text-gray-500 font-medium">Memuat data profil...</div>
      </main>
    );
  }

  const selectClass =
    "w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 disabled:bg-gray-100 disabled:text-gray-400";

  return (
    <div className="min-h-screen bg-[#f8fafc] pb-24 max-w-md mx-auto relative shadow-2xl">
      <TopHeader name={name} />

      <main className="flex flex-col gap-5 px-4 pt-6 pb-12">
        {message && (
          <div className="bg-green-50 border border-green-200 text-green-700 text-xs font-bold rounded-xl p-3">{message}</div>
        )}
        {error && <div className="bg-red-50 border border-red-200 text-red-600 text-xs font-bold rounded-xl p-3">{error}</div>}

        {/* Ringkasan profil */}
        <div className="flex flex-col items-center text-center">
          <div
            className="w-20 h-20 rounded-full flex items-center justify-center text-2xl text-white font-bold shadow-sm mb-3"
            style={theme.gradientStyle}
          >
            {name.slice(0, 2).toUpperCase()}
          </div>
          <h2 className="text-xl font-extrabold text-gray-800">{name}</h2>
          <span className={`inline-block ${theme.accentBg} ${theme.accentText} text-[10px] font-bold px-2.5 py-1 rounded-full mt-1.5`}>
            {theme.badgeLabel}
          </span>
          <p className="text-xs text-gray-500 mt-2">
            NISN: {nisn || "-"} &bull; {asalSekolah || "-"}
          </p>
        </div>

        {/* Data diri */}
        <div className={`bg-white border ${theme.accentBorder} rounded-2xl p-5 shadow-sm`}>
          <p className="text-[10px] font-bold text-gray-400 tracking-wider uppercase mb-4">Data Diri</p>

          <form onSubmit={handleUpdate} className="flex flex-col gap-4">
            <div>
              <label className="block text-xs font-bold text-gray-500 mb-1.5">Nama Lengkap</label>
              <input
                type="text"
                required
                value={name}
                onChange={(e) => setName(e.target.value)}
                className="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
              />
            </div>
            <div>
              <label className="block text-xs font-bold text-gray-500 mb-1.5">Email</label>
              <input
                type="email"
                value={email}
                disabled
                className="w-full border border-gray-200 bg-gray-50 text-gray-400 rounded-xl px-4 py-2.5 text-sm"
              />
              <p className="text-[10px] text-gray-400 mt-1 italic">Terhubung dari akun Google, tidak bisa diubah.</p>
            </div>
            <div>
              <label className="block text-xs font-bold text-gray-500 mb-1.5">NISN</label>
              <input
                type="text"
                required
                maxLength={10}
                value={nisn}
                onChange={(e) => setNisn(e.target.value)}
                className="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
              />
            </div>
            <div>
              <label className="block text-xs font-bold text-gray-500 mb-1.5">Asal Sekolah</label>
              <input
                type="text"
                required
                value={asalSekolah}
                onChange={(e) => setAsalSekolah(e.target.value)}
                className="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500"
              />
            </div>
            <div>
              <label className="block text-xs font-bold text-gray-500 mb-1.5">Kelas</label>
              <select required value={kelas} onChange={(e) => setKelas(e.target.value)} className={selectClass}>
                <option value="" disabled>
                  Pilih kelas
                </option>
                {kelasOptions.map((k) => (
                  <option key={k} value={k}>
                    Kelas {k}
                  </option>
                ))}
              </select>
            </div>

            <div className="pt-1">
              <label className="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Domisili Saat Ini</label>
              <p className="text-[10px] text-gray-400 italic mb-3">
                Dipakai untuk mencocokkan rekomendasi SMK terdekat dari tempat tinggalmu.
              </p>

              <div className="flex flex-col gap-4">
                <div>
                  <label className="block text-xs font-bold text-gray-500 mb-1.5">Provinsi</label>
                  <select
                    required
                    value={provinsiOptions.find((p) => p.nama === provinsi)?.kode || ""}
                    onChange={(e) => {
                      const opt = provinsiOptions.find((p) => p.kode === e.target.value);
                      handleProvinsiChange(e.target.value, opt?.nama || "");
                    }}
                    className={selectClass}
                  >
                    <option value="" disabled>
                      Pilih Provinsi
                    </option>
                    {provinsiOptions.map((p) => (
                      <option key={p.kode} value={p.kode}>
                        {p.nama}
                      </option>
                    ))}
                  </select>
                </div>
                <div>
                  <label className="block text-xs font-bold text-gray-500 mb-1.5">Kabupaten/Kota</label>
                  <select
                    required
                    disabled={!provinsi || kabKotaOptions.length === 0}
                    value={kabKotaOptions.find((k) => k.nama === kabupatenKota)?.kode || ""}
                    onChange={(e) => {
                      const opt = kabKotaOptions.find((k) => k.kode === e.target.value);
                      handleKabKotaChange(e.target.value, opt?.nama || "");
                    }}
                    className={selectClass}
                  >
                    <option value="" disabled>
                      {provinsi ? "Pilih Kabupaten/Kota" : "Pilih provinsi dulu"}
                    </option>
                    {kabKotaOptions.map((k) => (
                      <option key={k.kode} value={k.kode}>
                        {k.nama}
                      </option>
                    ))}
                  </select>
                </div>
                <div>
                  <label className="block text-xs font-bold text-gray-500 mb-1.5">Kecamatan</label>
                  <select
                    required
                    disabled={!kabupatenKota || kecamatanOptions.length === 0}
                    value={kecamatanOptions.find((k) => k.nama === kecamatan)?.kode || ""}
                    onChange={(e) => {
                      const opt = kecamatanOptions.find((k) => k.kode === e.target.value);
                      handleKecamatanChange(e.target.value, opt?.nama || "");
                    }}
                    className={selectClass}
                  >
                    <option value="" disabled>
                      {kabupatenKota ? "Pilih Kecamatan" : "Pilih kabupaten/kota dulu"}
                    </option>
                    {kecamatanOptions.map((k) => (
                      <option key={k.kode} value={k.kode}>
                        {k.nama}
                      </option>
                    ))}
                  </select>
                </div>
                <div>
                  <label className="block text-xs font-bold text-gray-500 mb-1.5">Kelurahan/Desa</label>
                  <select
                    required
                    disabled={!kecamatan || kelurahanOptions.length === 0}
                    value={kelurahanOptions.find((k) => k.nama === kelurahan)?.kode || ""}
                    onChange={(e) => {
                      const opt = kelurahanOptions.find((k) => k.kode === e.target.value);
                      setKelurahan(opt?.nama || "");
                    }}
                    className={selectClass}
                  >
                    <option value="" disabled>
                      {kecamatan ? "Pilih Kelurahan/Desa" : "Pilih kecamatan dulu"}
                    </option>
                    {kelurahanOptions.map((k) => (
                      <option key={k.kode} value={k.kode}>
                        {k.nama}
                      </option>
                    ))}
                  </select>
                </div>
              </div>
            </div>

            <button
              type="submit"
              disabled={updating}
              className={`${theme.accentBtn} text-white font-bold text-sm py-3 rounded-xl transition-colors mt-1 flex items-center justify-center gap-1.5 disabled:opacity-60`}
            >
              <Save className="w-3.5 h-3.5" /> {updating ? "Memproses..." : "Simpan Perubahan"}
            </button>
          </form>
        </div>

        {/* Pengaturan akun */}
        <button
          onClick={handleLogout}
          className="w-full bg-white border border-red-100 hover:bg-red-50 transition-colors text-left rounded-2xl shadow-sm p-4 flex items-center gap-3"
        >
          <LogOut className="w-5 h-5 text-red-500" />
          <span className="font-bold text-red-500 text-sm">Keluar</span>
        </button>
      </main>

      <BottomNav />
    </div>
  );
}
