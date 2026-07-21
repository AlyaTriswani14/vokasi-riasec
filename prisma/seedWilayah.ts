import { PrismaClient } from "@prisma/client";
import { readFileSync } from "fs";
import path from "path";
import { fileURLToPath } from "url";

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const prisma = new PrismaClient();

// Imports the full Indonesian administrative region dataset (provinsi ->
// kabupaten/kota -> kecamatan -> kelurahan/desa), sourced from Kepmendagri
// No 300.2.2-2430 Tahun 2025 (github.com/cahyadsn/wilayah), matching the
// original Laravel WilayahSeeder.

// A handful of region names contain commas (e.g. "Lambang Sari I, II, III")
// and are CSV-quoted, so a naive split(",") isn't safe.
function parseCsvLine(line: string): string[] {
  const fields: string[] = [];
  let cur = "";
  let inQuotes = false;
  for (let i = 0; i < line.length; i++) {
    const ch = line[i];
    if (ch === '"') {
      inQuotes = !inQuotes;
    } else if (ch === "," && !inQuotes) {
      fields.push(cur);
      cur = "";
    } else {
      cur += ch;
    }
  }
  fields.push(cur);
  return fields;
}

async function main() {
  const csvPath = path.join(__dirname, "data", "wilayah.csv");
  const raw = readFileSync(csvPath, "utf-8");
  const lines = raw.split("\n").filter((l) => l.trim().length > 0);
  const [, ...rows] = lines; // skip header

  const data = rows
    .map((line) => {
      const [kode, nama, level, induk] = parseCsvLine(line);
      if (!kode || !nama || !level) return null;
      return {
        kode: kode.trim(),
        nama: nama.trim(),
        level: parseInt(level.trim(), 10),
        induk: induk && induk.trim() !== "" ? induk.trim() : "0",
      };
    })
    .filter((r): r is NonNullable<typeof r> => r !== null);

  console.log(`Mengimpor ${data.length} baris data wilayah...`);

  const batchSize = 2000;
  let total = 0;
  for (let i = 0; i < data.length; i += batchSize) {
    const batch = data.slice(i, i + batchSize);
    await prisma.wilayah.createMany({ data: batch, skipDuplicates: true });
    total += batch.length;
    console.log(`  ${total}/${data.length}`);
  }

  console.log("Selesai import data wilayah.");
}

main()
  .catch((e) => {
    console.error(e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });
