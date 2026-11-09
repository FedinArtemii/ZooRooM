import fs from 'node:fs/promises';
import path from 'node:path';

const origin = new URL(process.env.WP_ORIGIN || 'http://127.0.0.1:8096').origin;
const base = '/' + (process.env.PAGES_BASE || 'ZooRooM').replace(/^\/+|\/+$/g, '') + '/';
const publicOrigin = 'https://fedinartemii.github.io';
const root = path.resolve('docs');
const theme = '/wp-content/themes/zooroom/';
const visited = new Set();
const assets = new Map();

function routePath(url) {
  return url.pathname.replace(/\/?$/, '/');
}

function localPath(url) {
  if (url.pathname.startsWith(theme)) return url.pathname.slice(theme.length);
  if (url.pathname.startsWith('/wp-content/uploads/') || url.pathname.startsWith('/wp-includes/')) {
    return url.pathname.slice(1);
  }
  return null;
}

function rewriteUrl(value, route, discover) {
  if (value.startsWith('#')) return value;
  const url = new URL(value.replaceAll('&#038;', '&').replaceAll('&amp;', '&'), origin + route);
  if (url.origin !== origin) return value;

  const asset = localPath(url);
  if (asset) {
    assets.set(asset, url.href);
    return base + asset + url.search.replaceAll('&', '&amp;') + url.hash;
  }

  if (url.search || /^\/(?:wp-|xmlrpc\.php)/.test(url.pathname)) {
    throw Error('Unsupported local link on ' + route + ': ' + value);
  }

  const target = routePath(url);
  if (discover && !visited.has(target)) discover.add(target);
  return base.slice(0, -1) + target + url.hash;
}

function transform(html, route, discover) {
  html = html.replace(/<link\b[^>]+rel=['"](?:EditURI|shortlink|alternate|https:\/\/api\.w\.org\/)['"][^>]*>/gi, '');
  html = html.replace(/<meta\b[^>]+name=['"]generator['"][^>]*>/gi, '');
  html = html.replace(/<script\b[^>]+id=['"](?:wp-emoji-settings|wp-emoji-loader)['"][^>]*>[\s\S]*?<\/script>/gi, '');
  html = html.replace(/(?:\/\*#|\/\/#) sourceURL=[^\r\n]+/g, '');
  html = html.replace(/(\s(?:href|src|srcset)=)(["'])([^"']*)\2/g, (full, attr, quote, value) => {
    if (attr.trim() === 'srcset=') {
      return attr + quote + value.split(/,\s+/).map((entry) => {
        const [url, size] = entry.trim().split(/\s+/);
        return rewriteUrl(url, route) + (size ? ' ' + size : '');
      }).join(', ') + quote;
    }
    const target = rewriteUrl(value, route, attr.trim() === 'href=' ? discover : null);
    return attr + quote + target + quote;
  });
  return html.replace(/[ \t]+$/gm, '').replace(/(<link\b[^>]+rel=["']canonical["'][^>]+href=["'])([^"']+)/gi,
    (_, prefix, target) => prefix + new URL(target, publicOrigin).href);
}

async function request(route, expectedStatus = 200) {
  const response = await fetch(new URL(route, origin), {signal: AbortSignal.timeout(20000)});
  if (response.status !== expectedStatus) throw Error(route + ': HTTP ' + response.status);
  return response;
}

async function write(file, contents) {
  const destination = path.resolve(root, decodeURIComponent(file));
  if (!destination.startsWith(root + path.sep)) throw Error('Invalid export path: ' + file);
  await fs.mkdir(path.dirname(destination), {recursive: true});
  await fs.writeFile(destination, contents);
}

await fs.cp('theme/zooroom/assets', path.join(root, 'assets'), {
  recursive: true,
  filter: (source) => !source.endsWith('.webp.json'),
});
const pending = new Set(['/', '/brand/', '/versions/']);
for (const route of pending) {
  visited.add(route);
  const response = await request(route);
  const html = transform(await response.text(), route, pending);
  await write(route.slice(1) + 'index.html', html);
  console.log('Exported ' + route);
}
const missing = '/missing-page-for-static-export/';
await write('404.html', transform(await (await request(missing, 404)).text(), missing));

for (const [asset, url] of assets) {
  await write(asset, Buffer.from(await (await request(url)).arrayBuffer()));
}

await write('.nojekyll', '');
await write('export-manifest.json', JSON.stringify({source: 'Local WordPress', base, pages: [...visited]}, null, 2) + '\n');
