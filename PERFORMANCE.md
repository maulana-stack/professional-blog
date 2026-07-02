# Performance & Optimization Guide - Professional Blog

Panduan untuk meningkatkan performa dan responsivitas blog Anda di production.

## 📌 Ringkasan
- Fokus pada: caching, optimasi database, optimasi asset, server tuning, monitoring.
- Target: TTFB rendah, First Contentful Paint cepat, Lighthouse score tinggi.

---

## 1. Laravel Build & Caching

- Gunakan config, route, dan view cache di production:

```bash
php artisan config:cache
php artisan route:cache   # only if routes have no Closures
php artisan view:cache
php artisan optimize
```

- Autoloader optimized:

```bash
composer install --no-dev --optimize-autoloader
composer dump-autoload -o
```

- Enable OPcache (PHP): pastikan opcache.enabled=1 dan memory_size sesuai.

---

## 2. HTTP Caching & CDN

- Gunakan CDN untuk file statis (images, css, js). Contoh: Cloudflare, BunnyCDN, DigitalOcean CDN.
- Atur cache headers di Nginx:

```nginx
location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
  expires 30d;
  add_header Cache-Control "public, immutable";
}
```

- Gunakan conditional requests (ETag, Last-Modified) untuk mengurangi bandwidth.

---

## 3. Asset Optimization

- Build & minify assets via Vite:

```bash
npm run build
```

- Enable HTTP/2 or HTTP/3 on server for multiplexing.
- Preload critical CSS & fonts, defer non-critical JS.

```html
<link rel="preload" href="/css/app.css" as="style">
<link rel="preload" href="/fonts/Inter.woff2" as="font" type="font/woff2" crossorigin>
<script defer src="/js/app.js"></script>
```

- Use Brotli or Gzip compression (Brotli preferred for HTTPS).

---

## 4. Image Optimization

- Use responsive images (srcset) and WebP where possible.
- Lazy-load images: `loading="lazy"`.
- Compress images on upload (Spatie Image Optimizer or Imgix/Cloudinary):

```bash
composer require spatie/image-optimizer
php artisan storage:optimize-images
```

- Serve optimized images via CDN with auto-webp conversion.

---

## 5. Database Optimization

- Add indexes to columns used in WHERE, ORDER BY, JOIN (e.g., published_at, slug, category_id, author_id).

- Use EXPLAIN for slow queries and refactor:

```sql
EXPLAIN SELECT * FROM posts WHERE published_at IS NOT NULL ORDER BY published_at DESC LIMIT 10;
```

- Eager load relationships to prevent N+1:

```php
$posts = Post::with(['author','category','tags'])->published()->paginate(10);
```

- Use pagination rather than loading all records.
- Offload heavy queries to background jobs (queues).

---

## 6. Queues & Background Jobs

- Use queues for email sending, image processing, view counting batching, analytics jobs.
- Recommended drivers: Redis or Beanstalkd.
- Use Laravel Horizon for monitoring (with Redis):

```bash
composer require laravel/horizon
php artisan horizon:install
php artisan horizon
```

- Configure supervisor to keep workers alive in production.

---

## 7. Caching Strategies

- Cache views, fragments, and heavy queries:

```php
// Cache query
$posts = Cache::remember('home_posts', 60, fn() => Post::published()->take(6)->get());

// Cache fragment
@cache(['key' => "post_{$post->id}", 'ttl' => 60])
  @include('partials.post-card')
@endcache
```

- Use Redis for fast in-memory caching.
- Use cache tags (Redis/Database) for selective invalidation.

---

## 8. Full Page Caching (Optional)

- Proxy caching via Varnish or Nginx microcaching for anonymous users.
- Example Nginx microcache config pattern:

```nginx
fastcgi_cache_path /var/cache/nginx levels=1:2 keys_zone=MICROCACHE:10m inactive=60m;

server {
  set $no_cache 0;
  if ($request_method = POST) { set $no_cache 1; }
  if ($query_string != "") { set $no_cache 1; }

  location / {
    fastcgi_cache_bypass $no_cache;
    fastcgi_no_cache $no_cache;
    fastcgi_cache MICROCACHE;
    fastcgi_cache_valid 200 60s;
    try_files $uri $uri/ /index.php?$query_string;
  }
}
```

- Ensure cache is bypassed for logged-in users and admin routes.

---

## 9. PHP-FPM & Nginx Tuning

- PHP-FPM: tune `pm.max_children`, `pm.start_servers`, `pm.min_spare_servers`, `pm.max_spare_servers` according to server memory.
- Use separate pools for CLI vs web if needed.
- Nginx: worker_processes auto; worker_connections 1024+.

---

## 10. Monitoring & Profiling

- Use New Relic, Blackfire, or Tideways for profiling.
- Use Laravel Telescope (dev) for local debugging.
- Monitor logs and metrics: CPU, memory, response times.
- Set up alerting for error spikes and high latency.

---

## 11. Security & Performance

- Enable HTTPS and HSTS:

```nginx
add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
```

- Rate-limit endpoints that are expensive (search, feed generation).
- Use request throttling via Laravel `ThrottleRequests` middleware.

---

## 12. Performance Testing

- Use Lighthouse, WebPageTest, and PageSpeed Insights.
- Load test with `k6`, `wrk`, or `locust` to simulate traffic.

Example k6 script:

```js
import http from 'k6/http';
import { sleep } from 'k6';

export default function () {
  http.get('https://yourdomain.com/');
  sleep(1);
}
```

Run:
```bash
k6 run script.js
```

---

## 13. Recommended Production Commands

```bash
# On deploy
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan queue:restart

# Clear cache if debugging
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

---

## 14. Quick Checklist

```
☐ Composer optimized install
☐ Assets built and minified
☐ OPcache enabled
☐ Redis configured for cache & queues
☐ DB indexes for heavy queries
☐ Eager loading implemented
☐ CDN configured for static assets
☐ Image optimization & lazy loading
☐ Microcaching or full-page cache for anonymous users
☐ Monitoring & alerting set up
```

---

Jika Anda mau, saya bisa:
- Membuat PR yang menambahkan header cache, meta preload, dan schema di layout
- Membuat contoh konfigurasi Supervisor & systemd untuk worker
- Membuat skrip deploy otomatis yang menjalankan perintah di atas

Mau saya kerjakan mana dulu?