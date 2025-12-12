# 📊 Laporan WBS, Penjadwalan, dan Estimasi Biaya
## Proyek: TahsinOnline - Learning Management System

---

## 👥 Sumber Daya Manusia (SDM)

| No | Nama | Jabatan | Peran |
|:---:|:---|:---|:---|
| 1 | Dadan Satria | Project Manager | Koordinator proyek, Frontend Developer |
| 2 | Abdullah Khofi | System Analyst | Analisis sistem, Backend Developer |

---

## 📋 Work Breakdown Structure (WBS)

```
1.0 Proyek TahsinOnline LMS
│
├── 1.1 Inisiasi & Perencanaan
│   ├── 1.1.1 Analisis Kebutuhan
│   ├── 1.1.2 Desain Database
│   └── 1.1.3 Desain UI/UX
│
├── 1.2 Pengembangan Backend
│   ├── 1.2.1 Setup Laravel Framework
│   ├── 1.2.2 Modul Autentikasi (Login/Register)
│   ├── 1.2.3 Modul Manajemen Kelas
│   ├── 1.2.4 Modul Langganan & Pembayaran
│   ├── 1.2.5 Modul Jadwal Kelas
│   └── 1.2.6 Modul Progress Siswa
│
├── 1.3 Pengembangan Frontend
│   ├── 1.3.1 Landing Page
│   ├── 1.3.2 Dashboard Siswa
│   ├── 1.3.3 Dashboard Admin
│   ├── 1.3.4 Halaman Kelas & Materi
│   └── 1.3.5 Responsive Mobile Design
│
├── 1.4 Pengujian & QA
│   ├── 1.4.1 Unit Testing
│   ├── 1.4.2 Integration Testing
│   └── 1.4.3 User Acceptance Testing (UAT)
│
├── 1.5 Deployment
│   ├── 1.5.1 Setup Hosting (Hostinger)
│   ├── 1.5.2 Konfigurasi Domain & SSL
│   └── 1.5.3 Go-Live
│
└── 1.6 Pemeliharaan
    ├── 1.6.1 Monitoring & Bug Fixing
    └── 1.6.2 Backup Rutin
```

---

## 📅 Jadwal Proyek (Gantt Chart)

| No | Aktivitas | Durasi | Minggu 1 | Minggu 2 | Minggu 3 | Minggu 4 | Minggu 5 | Minggu 6 | PIC |
|:---:|:---|:---:|:---:|:---:|:---:|:---:|:---:|:---:|:---|
| 1.1 | Analisis & Perencanaan | 1 minggu | ████ | | | | | | Abdullah |
| 1.2 | Pengembangan Backend | 3 minggu | | ████ | ████ | ████ | | | Abdullah |
| 1.3 | Pengembangan Frontend | 3 minggu | | ████ | ████ | ████ | | | Dadan |
| 1.4 | Pengujian & QA | 1 minggu | | | | | ████ | | Tim |
| 1.5 | Deployment | 0.5 minggu | | | | | | ██ | Tim |
| 1.6 | **Buffer** | 0.5 minggu | | | | | | ██ | - |
| - | **Meeting Progress** | - | 📍 | 📍 | 📍 | 📍 | 📍 | 📍 | Tim |

**Keterangan:**
- ████ = Periode kerja aktif
- 📍 = Meeting progress mingguan (setiap Senin)
- Total durasi: **6 minggu** (termasuk buffer)

---

## 💰 Estimasi Biaya

### A. Biaya Infrastruktur

| No | Item | Spesifikasi | Harga/Bulan | Durasi | Total |
|:---:|:---|:---|---:|:---:|---:|
| 1 | Hosting Hostinger | Single Plan (10GB SSD) | Rp 12.900 | 48 bulan | Rp 619.200 |
| 2 | Domain .com | 1 tahun (gratis tahun pertama) | Rp 0 | 1 tahun | Rp 0 |
| 3 | SSL Certificate | Let's Encrypt (Gratis) | Rp 0 | - | Rp 0 |
| | | | | **Subtotal** | **Rp 619.200** |

### B. Biaya Pengembangan (SDM)

| No | Peran | Jam Kerja | Rate/Jam | Total |
|:---:|:---|---:|---:|---:|
| 1 | Project Manager & Frontend (Dadan) | 120 jam | Rp 50.000 | Rp 6.000.000 |
| 2 | System Analyst & Backend (Abdullah) | 120 jam | Rp 50.000 | Rp 6.000.000 |
| | | | **Subtotal** | **Rp 12.000.000** |

### C. Biaya Lain-lain

| No | Item | Keterangan | Total |
|:---:|:---|:---|---:|
| 1 | Lisensi Software | Open Source (Laravel, Tailwind) | Rp 0 |
| 2 | Dokumentasi & Laporan | Alat tulis, print | Rp 100.000 |
| 3 | Transportasi Meeting | 6x meeting | Rp 300.000 |
| | | **Subtotal** | **Rp 400.000** |

### D. Buffer Biaya (10%)

| Item | Perhitungan | Total |
|:---|:---|---:|
| Cadangan tak terduga | 10% x (A + B + C) | Rp 1.301.920 |

---

## 📊 Rekapitulasi Total Biaya

| Kategori | Jumlah |
|:---|---:|
| A. Infrastruktur | Rp 619.200 |
| B. Pengembangan (SDM) | Rp 12.000.000 |
| C. Lain-lain | Rp 400.000 |
| D. Buffer (10%) | Rp 1.301.920 |
| **GRAND TOTAL** | **Rp 14.321.120** |

---

## 📍 Jadwal Meeting Progress

| Meeting | Tanggal | Agenda | Output |
|:---:|:---|:---|:---|
| 1 | Minggu ke-1 | Kick-off, pembagian tugas | Dokumen kebutuhan |
| 2 | Minggu ke-2 | Review desain database & UI | ERD, Wireframe |
| 3 | Minggu ke-3 | Demo backend (auth, kelas) | Prototype backend |
| 4 | Minggu ke-4 | Demo frontend (dashboard) | Prototype frontend |
| 5 | Minggu ke-5 | Review hasil testing | Laporan bug |
| 6 | Minggu ke-6 | Final review, deployment | Sistem live |

---

## ✅ Kesimpulan

Proyek TahsinOnline LMS diperkirakan:
- **Durasi:** 6 minggu (termasuk buffer 0.5 minggu)
- **Total Biaya:** Rp 14.321.120 (termasuk buffer 10%)
- **Tim:** 2 orang (1 PM/Frontend, 1 SA/Backend)

---

*Dokumen ini disusun sebagai bagian dari Tugas Mata Kuliah Manajemen Proyek.*
*Disusun oleh: Dadan Satria & Abdullah Khofi*
