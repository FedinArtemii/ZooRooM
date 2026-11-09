import fs from 'node:fs';
import path from 'node:path';
import assert from 'node:assert/strict';
import {execFileSync} from 'node:child_process';

const root = path.resolve('docs');
const manifest = JSON.parse(fs.readFileSync(path.join(root, 'export-manifest.json'), 'utf8'));
const expected = ['/', '/brand/', '/versions/', '/journal/cat-shedding/', '/journal/shedding-results/', '/journal/yorkie-coat/'];
for (const route of expected) assert(manifest.pages.includes(route), 'Missing WordPress page: ' + route);

let links = 0;
for (const route of [...manifest.pages, '/404.html']) {
  const relative = route.endsWith('/') ? route.slice(1) + 'index.html' : route.slice(1);
  const file = path.join(root, relative);
  const html = fs.readFileSync(file, 'utf8');
  assert.match(html, /<html lang="ru-RU"/, 'Russian language metadata');
  assert.equal((html.match(/<h1\b/g) || []).length, 1, 'Expected one H1: ' + route);
  assert(!/127\.0\.0\.1|localhost|wp-config\.php|Fatal error|Parse error/.test(html), 'Local path or PHP error in ' + route);
  assert.match(html, /noindex/, 'Demo indexing metadata');
  const brandPage = route === '/brand/' || route === '/versions/';
  assert(html.includes(manifest.base + (brandPage ? 'brand.css?' : 'style.css?')), 'Unexpected design on ' + route);
  if (route === '/versions/') {
    for (const target of ['', 'brand/']) assert(html.includes('href="' + manifest.base + target + '"'), 'Missing design link to ' + target);
  }
  for (const match of html.matchAll(/\s(?:href|src|srcset)=(["'])([^"']+)\1/g)) {
    const values = match[0].includes('srcset=') ? match[2].split(/,\s+/).map(value => value.split(/\s+/)[0]) : [match[2]];
    for (const value of values) {
      const href = value.replaceAll('&amp;', '&');
      if (!href.startsWith(manifest.base) && !href.startsWith('#')) continue;
      const url = new URL(href, 'https://fedinartemii.github.io' + manifest.base + relative);
      const local = path.join(root, decodeURIComponent(url.pathname.slice(manifest.base.length)));
      const target = fs.existsSync(local) && fs.statSync(local).isDirectory() ? path.join(local, 'index.html') : local;
      assert(fs.existsSync(target), 'Broken resource ' + href + ' in ' + route);
      if (url.hash) {
        assert(fs.readFileSync(target, 'utf8').includes('id="' + url.hash.slice(1) + '"'), 'Broken anchor ' + href);
      }
      links++;
    }
  }
  for (const match of html.matchAll(/<img\b[^>]*>/g)) assert(/\balt=/.test(match[0]), 'Image without alt in ' + route);
}

for (const stylesheet of ['style.css', 'brand.css']) {
  const css = fs.readFileSync(path.join(root, stylesheet), 'utf8');
  for (const match of css.matchAll(/url\("([^"]+)"\)/g)) assert(fs.existsSync(path.join(root, match[1])), 'Missing CSS asset ' + match[1]);
}
for (const dir of ['theme/zooroom', 'tools']) {
  for (const file of fs.readdirSync(dir, {recursive: true}).filter(name => name.endsWith('.php'))) {
    execFileSync(process.env.PHP_BIN || 'php', ['-l', path.join(dir, file)]);
  }
}
console.log('PASS: ' + manifest.pages.length + ' WordPress pages, 404 and ' + links + ' links and assets.');
