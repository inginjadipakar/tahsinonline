# Installing Laravel Excel Package

## For Local Development (Laragon)

Run this command in your terminal:

```bash
cd c:\laragon\www\tahsionline
composer require maatwebsite/excel
```

## For Railway (Production)

The package will be automatically installed when you push to Railway because it's added to `composer.json`.

## After Installation

1. The Excel export feature will work automatically
2. Admin can export attendance data at `/admin/attendances` → "Export Excel" button
3. File will download as: `absensi-mengajar-2024-12-27.xlsx`

## Features

- Corporate formatting with headers
- Auto-width columns  
- Filters applied (teacher, class, status, dates)
- Color-coded table headers (emerald green)
- All attendance data in one sheet

## If Composer Not Found

Make sure Composer is installed and in your PATH:
- Download from: https://getcomposer.org/download/
- Or use Laragon's terminal (it should have composer)
