import { PrismaClient } from "@prisma/client";
import { seedCore } from "../lib/seedData";

const prisma = new PrismaClient();

async function main() {
  console.log("Seeding database...");
  await seedCore(prisma);
  console.log("Seeding complete!");
}

main()
  .catch((e) => {
    console.error(e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });
