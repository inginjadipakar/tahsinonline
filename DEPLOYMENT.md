# 🚀 Panduan Deployment TahsinOnline ke Railway.app

## Prerequisites
- ✅ Repository GitHub sudah dibuat dan public
- ✅ Akun Railway.app (gratis, login dengan GitHub)
- ✅ Composer.json sudah dikonfigurasi untuk PHP 8.3+

## Langkah-Langkah Deployment

### 1️⃣ Commit & Push ke GitHub

```bash
git add .
git commit -m "feat: setup Railway deployment configuration"
git push origin main
```

> **Catatan**: Pastikan file `.env` TIDAK ter-upload (sudah tercakup di `.gitignore`)

### 2️⃣ Setup Railway.app

1. **Login ke Railway**: [railway.app](https://railway.app)
   - Klik "Login with GitHub"
   - Authorize Railway untuk akses repository

2. **Create New Project**:
   - Klik "New Project"
   - Pilih "Deploy from GitHub repo"
   - Pilih repository `tahsionline`

3. **Railway akan otomatis:**
   - Detect Laravel framework
   - Install PHP 8.3
   - Run `composer install`
   - Build assets dengan `npm run build`

### 3️⃣ Setup Database

1. **Add MySQL Database**:
   - Di Railway dashboard project Anda
   - Klik "New" → "Database" → "Add MySQL"
   - Railway akan auto-provision database

2. **Database sudah auto-connect!**
   - Railway otomatis inject environment variables:
     - `MYSQL_URL`
     - `MYSQL_HOST`
     - `MYSQL_PORT`
     - `MYSQL_DATABASE`
     - `MYSQL_USER`
     - `MYSQL_PASSWORD`

### 4️⃣ Configure Environment Variables

Klik tab "Variables" di Railway dashboard, tambahkan:

#### **Required Variables**:
```bash
APP_NAME="Tahsin Online"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.up.railway.app

# Database (Railway auto-inject, tapi bisa override)
DB_CONNECTION=mysql
DB_HOST=${MYSQL_HOST}
DB_PORT=${MYSQL_PORT}
DB_DATABASE=${MYSQL_DATABASE}
DB_USERNAME=${MYSQL_USER}
DB_PASSWORD=${MYSQL_PASSWORD}

# Laravel
LOG_CHANNEL=stack
LOG_LEVEL=error

# Session & Cache
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

#### **Generate APP_KEY**:
Railway akan otomatis generate, atau jalankan manual di terminal Railway:
```bash
php artisan key:generate --show
```

### 5️⃣ Deploy! 🎉

Railway akan **otomatis deploy** setelah:
- ✅ Environment variables dikonfigurasi
- ✅ Database ready
- ✅ Build berhasil

Monitor di tab "Deployments" untuk melihat progress.

### 6️⃣ Run Migrations & Seeders

Setelah deploy berhasil, buka **Railway Terminal**:

1. Klik project → Klik "..." → "View Logs/Terminal"
2. Jalankan:

```bash
php artisan migrate --force
php artisan db:seed --force
```

### 7️⃣ Akses Aplikasi

Aplikasi Anda akan tersedia di:
```
https://your-project-name.up.railway.app
```

Klik "Settings" → "Generate Domain" untuk mendapat public URL.

---

## 🔧 Troubleshooting

### Build Gagal?
1. Cek "Build Logs" di Railway
2. Pastikan `composer.json` valid
3. Pastikan PHP version: `^8.2` di `composer.json`

### Database Connection Error?
```bash
# Di Railway terminal
php artisan config:clear
php artisan cache:clear
```

### Asset Tidak Muncul?
```bash
php artisan storage:link
php artisan view:clear
php artisan config:cache
```

### Cek Environment Variables
```bash
php artisan tinker
>>> config('database.connections.mysql')
```

---

## 💰 Free Tier Limits

**Railway Free Tier** (dengan $5 kredit/bulan):
- ✅ ~500 jam uptime
- ✅ 1 GB RAM
- ✅ 1 GB storage
- ✅ Unlimited bandwidth
- ✅ MySQL database included

**Estimasi**: Cukup untuk development/testing & ~20,000 page views/bulan

---

## 📝 Post-Deployment Checklist

- [ ] Test login/register
- [ ] Test payment flow
- [ ] Test class schedules
- [ ] Setup custom domain (optional)
- [ ] Setup monitoring (Railway built-in)
- [ ] Configure backups (via Railway dashboard)

---

## 🆘 Need Help?

- [Railway Documentation](https://docs.railway.app/)
- [Railway Discord](https://discord.gg/railway)
- [Laravel Deployment Guide](https://laravel.com/docs/deployment)

---

**Good Luck! 🚀**
