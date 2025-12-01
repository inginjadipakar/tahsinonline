# 🔧 Troubleshooting Railway Deployment Error

## Error: "Application failed to respond"

### Langkah 1: Check Deploy Logs

1. **Di Railway Dashboard**, klik tab **"Deployments"** (pojok kiri atas)
2. **Klik deployment terakhir** yang failed/running
3. **Klik "View Logs"** atau tab **"Deploy Logs"**
4. **Cari error message** berwarna merah

**Screenshot lokasi**: Tab Deployments → Latest deployment → View Logs

---

### Langkah 2: Setup Environment Variables (PALING PENTING!)

Railway **perlu environment variables** untuk Laravel bisa jalan.

#### **Di Railway Dashboard:**

1. **Klik tab "Variables"** (di sebelah Settings)
2. **Tambahkan variables berikut** (klik "+ New Variable"):

```bash
# CRITICAL - Laravel akan crash tanpa ini!
APP_KEY=base64:GENERATE_THIS_KEY_SEE_BELOW

# Basic Laravel Config
APP_NAME="Tahsin Online"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://YOUR-RAILWAY-DOMAIN.up.railway.app

# Database (Railway auto-inject, tapi tambahkan ini juga)
DB_CONNECTION=mysql
DB_HOST=${MYSQLHOST}
DB_PORT=${MYSQLPORT}
DB_DATABASE=${MYSQLDATABASE}
DB_USERNAME=${MYSQLUSER}
DB_PASSWORD=${MYSQLPASSWORD}

# Log & Session
LOG_CHANNEL=stack
LOG_LEVEL=error
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

#### **CARA GENERATE APP_KEY:**

**Opsi 1 - Via Railway Terminal (Recommended):**
1. Di Railway dashboard, klik tab **"..."** (3 titik) → **"Terminal"** atau **"Shell"**
2. Jalankan perintah:
   ```bash
   php artisan key:generate --show
   ```
3. **Copy output** yang muncul (misal: `base64:abcd1234...`)
4. **Paste di Railway Variables** dengan nama `APP_KEY`

**Opsi 2 - Via Lokal:**
1. Di komputer Anda, buka terminal di folder `tahsionline`
2. Jalankan:
   ```bash
   php artisan key:generate --show
   ```
3. Copy hasilnya dan paste ke Railway Variables

---

### Langkah 3: Setup Database (Jika Belum)

#### **Add MySQL Database:**

1. Di Railway dashboard **project** Anda
2. Klik tombol **"+ New"** di pojok kanan atas
3. Pilih **"Database"** → **"Add MySQL"**
4. Railway akan otomatis provision MySQL database
5. Database variables akan auto-inject ke service Anda

**PENTING**: Tunggu database ready (ada checkmark hijau) sebelum lanjut!

---

### Langkah 4: Redeploy Setelah Fix

Setelah setup environment variables & database:

1. **Klik tab "Deployments"**
2. **Klik "..." (3 titik)** di deployment terakhir
3. **Klik "Redeploy"** atau **"Restart Deployment"**

ATAU

1. **Push commit kosong** ke GitHub:
   ```bash
   git commit --allow-empty -m "trigger redeploy"
   git push
   ```

Railway akan otomatis redeploy.

---

### Langkah 5: Run Migrations

Setelah deployment **berhasil** (status hijau):

1. **Buka Railway Terminal**: tab **"..."** → **"Terminal"**
2. **Jalankan migrations**:
   ```bash
   php artisan migrate --force
   php artisan db:seed --force
   php artisan storage:link
   php artisan optimize
   ```

---

## Common Errors & Solutions

### ❌ "Illuminate\Encryption\MissingAppKeyException"
**Solusi**: Set `APP_KEY` di Variables (lihat Langkah 2)

### ❌ "SQLSTATE[HY000] [2002] Connection refused"
**Solusi**: 
- Pastikan MySQL database sudah ditambahkan
- Cek DB variables di tab "Variables"
- Pastikan pakai variable Railway: `${MYSQLHOST}`, bukan IP hardcoded

### ❌ "Target class [App\Http\Controllers\...] does not exist"
**Solusi**: 
```bash
composer dump-autoload
php artisan config:cache
php artisan route:cache
```

### ❌ "The stream or file could not be opened"
**Solusi**: Laravel tidak bisa write logs
```bash
php artisan cache:clear
php artisan config:clear
chmod -R 775 storage
```

---

## Checklist Deployment

Sebelum deploy berhasil, pastikan:

- [ ] **APP_KEY** sudah di-set di Variables
- [ ] **Database MySQL** sudah ditambahkan dan ready
- [ ] **Database Variables** (`MYSQLHOST`, etc) muncul di tab Variables
- [ ] **APP_URL** sesuai dengan Railway domain Anda
- [ ] **Deploy Logs** tidak ada error merah
- [ ] **Migrations** sudah dijalankan via terminal

---

## Need Help?

1. **Screenshot Deploy Logs** yang error → tunjukkan ke developer
2. **Cek Railway Status**: https://railway.app/status
3. **Railway Discord**: https://discord.gg/railway

---

**Setelah fix, website akan muncul di Railway domain! 🚀**
