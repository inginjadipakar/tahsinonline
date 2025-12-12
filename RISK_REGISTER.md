# 🛡️ Risk Register - Proyek TahsinOnline

Dokumen ini berisi analisis dan rencana pengelolaan risiko untuk tim pengembang proyek TahsinOnline.

## Tabel Risk Register

| ID | Deskripsi Risiko | Kategori | Probabilitas | Dampak | Skor | PIC | Rencana Mitigasi | Status |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| 1 | **Hilangnya File Upload (Ephemeral Storage)**<br>File bukti bayar/materi hilang saat redeploy di Railway. | Teknis | High | High | **Critical** | DevOps | Konfigurasi Cloud Storage (AWS S3/Cloudinary) atau Railway Volume. | **Active** |
| 2 | **Konflik Merge Code (Git Conflict)**<br>Bentrokan kode antara fitur Admin (Main) dan fitur Guru (Branch Teman). | Teknis | High | Medium | **High** | Lead Dev | Lakukan *pull request* rutin dan review kode sebelum merge. | **Active** |
| 3 | **Bug Logika Durasi Langganan**<br>Kesalahan hitung durasi (misal: kembali ke 28 hari) saat update status pembayaran. | Quality | Medium | High | **High** | Backend | Buat Unit Test untuk kalkulasi tanggal dan validasi manual saat UAT. | **Mitigated** |
| 4 | **Kebocoran Akses Role (IDOR)**<br>Siswa bisa mengakses halaman Guru/Admin dengan memanipulasi URL. | Security | Low | Critical | **High** | Backend | Pastikan Middleware `TeacherOnly` dan `AdminOnly` terpasang di semua route sensitif. | **Mitigated** |
| 5 | **Keterlambatan Fitur LMS Guru**<br>Modul Guru belum siap saat jadwal rilis karena ketergantungan pada developer rekanan. | Proyek | Medium | High | **High** | PM | Siapkan skenario manual (Admin input data guru) sebagai *fallback plan*. | **Active** |
| 6 | **Kegagalan Pengiriman Email (SMTP)**<br>User tidak menerima email verifikasi/notifikasi karena limitasi server email. | Teknis | Medium | Medium | **Moderate** | DevOps | Gunakan layanan email transaksional terpercaya (SendGrid/Mailgun) dan monitor log. | **Active** |
| 7 | **Performa Query Database (N+1 Problem)**<br>Dashboard lambat saat data siswa/kelas bertambah banyak. | Teknis | Medium | Medium | **Moderate** | Backend | Optimasi query menggunakan Eager Loading (`with()`) pada Eloquent. | **Active** |
| 8 | **Isu Tampilan Responsif (Mobile)**<br>Layout tabel atau menu berantakan di layar HP kecil. | UI/UX | High | Low | **Moderate** | Frontend | Lakukan testing intensif di berbagai ukuran layar dan gunakan class responsive Tailwind. | **Active** |
| 9 | **Kegagalan Migrasi Database**<br>Struktur database di Local berbeda dengan Production (Railway). | Teknis | Low | High | **Moderate** | DevOps | Dilarang edit file migrasi lama. Selalu buat file migrasi baru (`add_column_...`) untuk perubahan. | **Active** |
| 10 | **Hardcoded Credentials**<br>Kunci API atau password database tidak sengaja ter-upload ke GitHub. | Security | Low | Critical | **High** | All Dev | Gunakan `.env` untuk semua rahasia dan pastikan `.gitignore` sudah benar. | **Mitigated** |

## Keterangan Matriks Skor
*   **Critical:** Harus diselesaikan SEGERA sebelum rilis.
*   **High:** Perlu penanganan prioritas dan monitoring ketat.
*   **Moderate:** Bisa dijadwalkan perbaikannya atau dimitigasi dengan SOP.
*   **Low:** Risiko dapat diterima dengan monitoring berkala.
