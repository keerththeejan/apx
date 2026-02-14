# Deploy apx.lk on cPanel

## 1. Set document root

In cPanel → **Domains** → select **apx.lk** → **Document Root**:

Set to: `public_html/apx/public` (or `/home/YOUR_USER/apx/public`)

**Important:** The document root MUST point to the `public` folder, not the project root.

---

## 2. Upload files

Upload the full Laravel project so the structure is:

```
/home/YOUR_USER/
  apx/                    ← project root (or public_html/apx)
    app/
    bootstrap/
    config/
    database/
    public/               ← document root must point here
    resources/
    routes/
    storage/
    vendor/
    .env
    ...
```

---

## 3. Configure .env on server

Create/edit `.env` in the project root:

```env
APP_NAME="apx.lk"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://apx.lk

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=your_cpanel_db
DB_USERNAME=your_cpanel_db_user
DB_PASSWORD=your_db_password
```

**Important:** Use `https://apx.lk` if you have SSL. Generate a new key:

```bash
php artisan key:generate
```

---

## 4. File permissions

In cPanel File Manager or SSH:

```bash
chmod -R 755 storage bootstrap/cache
chown -R USER:USER storage bootstrap/cache
```

(Replace `USER` with your cPanel username.)

---

## 5. Run migrations and storage link

In cPanel → **Terminal** (or SSH):

```bash
cd ~/apx   # or your project path
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
```

---

## 6. Force HTTPS (optional)

If your site has SSL, edit `public/.htaccess` and uncomment:

```apache
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

## 7. If document root cannot be changed

If you cannot point the document root to `public`:

1. Put Laravel in `public_html/apx/` (full project)
2. In cPanel, set document root to `public_html/apx/public`

Or use a subdomain/addon domain with its own document root.

---

## Troubleshooting

| Problem | Fix |
|---------|-----|
| 500 error | Check `storage/logs/laravel.log`. Ensure `storage` and `bootstrap/cache` are writable (755). |
| 404 on all routes | Document root must be `public`. Check mod_rewrite is enabled. |
| Mixed content (HTTP/HTTPS) | Set `APP_URL=https://apx.lk` and enable the HTTPS redirect in `.htaccess`. |
| CSS/images not loading | Run `php artisan storage:link`. Check `APP_URL` matches your domain. |
