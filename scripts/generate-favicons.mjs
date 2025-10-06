import { readFile } from 'node:fs/promises';
import { mkdir, writeFile } from 'node:fs/promises';
import path from 'node:path';
import sharp from 'sharp';

async function ensureDir(dir) {
  await mkdir(dir, { recursive: true });
}

async function generateFavicons() {
  const projectRoot = process.cwd();
  const srcSvg = path.join(projectRoot, 'public', 'images', 'BikolpoLive.svg');
  const outDir = path.join(projectRoot, 'public', 'images');

  const svgBuffer = await readFile(srcSvg);
  await ensureDir(outDir);

  const targets = [
    { size: 16,  name: 'favicon-16x16.png' },
    { size: 32,  name: 'favicon-32x32.png' },
    { size: 180, name: 'apple-touch-icon-180x180.png' }
  ];

  for (const t of targets) {
    const outPath = path.join(outDir, t.name);
    const img = sharp(svgBuffer)
      .resize(t.size, t.size, { fit: 'contain', background: { r: 0, g: 0, b: 0, alpha: 0 } })
      .png({ compressionLevel: 9, adaptiveFiltering: true });
    await img.toFile(outPath);
    // Also write a copy into build pipelines if needed later
  }

  // Optionally: generate a 512x512 for PWA use later
  const pwa512 = path.join(outDir, 'icon-512x512.png');
  await sharp(svgBuffer)
    .resize(512, 512, { fit: 'contain', background: { r: 0, g: 0, b: 0, alpha: 0 } })
    .png({ compressionLevel: 9, adaptiveFiltering: true })
    .toFile(pwa512);

  console.log('Favicons generated in', outDir);
}

generateFavicons().catch(err => {
  console.error('Failed to generate favicons:', err);
  process.exit(1);
});
