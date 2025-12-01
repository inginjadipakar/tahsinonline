# 📖 Tahsinku - Platform Belajar Al-Qur'an

Platform belajar mengaji online yang menghubungkan santri dengan ustadz/ustadzah bersertifikat untuk pembelajaran Al-Qur'an dari tingkat Iqra hingga Tahsin lanjutan.

## 🚀 Tech Stack

- **Backend:** Laravel 12.39.0
- **Frontend:** Alpine.js + Tailwind CSS
- **Build Tool:** Vite
- **Database:** MySQL 8.0
- **PHP:** 8.3.26

## ✨ Features

### Landing Page
- 🎨 Modern hero section dengan carousel
- 💡 FAQ accordion dengan smooth animations
- 📱 Fully responsive design
- 🌙 Dark mode support
- 🔍 SEO optimized

### Student Dashboard
- 📚 Kelas Saya (My Classes) dengan progress tracking
- 📅 Jadwal kelas interaktif
- 💰 Payment & subscription management
- 👤 Profile management
- 📊 Learning progress visualization

### Admin Panel
- 👥 User management (Students & Teachers)
- 🏫 Class & schedule management
- 📝 Lesson content management
- 💳 Subscription & payment tracking

### 🚧 Coming Soon
- 👨‍🏫 **Teacher Dashboard** (In Development)
  - Student progress tracking
  - Schedule management
  - Lesson completion updates
  - Attendance marking

## 📦 Installation

### Prerequisites
- PHP >= 8.3
- Composer
- Node.js >= 18
- MySQL >= 8.0

### Setup Steps

1. **Clone repository**
```bash
git clone https://github.com/inginjadipakar/Tahsinku.git
cd Tahsinku
```

2. **Install dependencies**
```bash
composer install
npm install
```

3. **Environment configuration**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database setup**
Update `.env` with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tahsinku
DB_USERNAME=root
DB_PASSWORD=your_password
```

Then run migrations:
```bash
php artisan migrate --seed
```

5. **Build assets**
```bash
npm run dev
```

6. **Start development server**
```bash
php artisan serve
```

Visit: `http://localhost:8000`

## 👥 Default Credentials

After running seeders:
- **Admin:** admin@tahsinku.com / password
- **Student:** Register via landing page

## 📂 Project Structure

```
tahsionline/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin controllers
│   │   │   ├── Student/        # Student controllers
│   │   │   └── Teacher/        # Teacher controllers (WIP)
│   │   └── Middleware/
│   │       └── AdminOnly.php
│   └── Models/
├── config/
│   └── landing.php             # Landing page content
├── database/
│   └── migrations/
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   ├── student/
│   │   ├── components/
│   │   │   └── landing/        # Modular landing components
│   │   └── layouts/
│   └── css/
│       └── app.css
└── routes/
    └── web.php
```

## 🎨 Customization

### Landing Page Content
Edit `config/landing.php` to update:
- Hero section text & images
- FAQ questions
- Testimonials
- CTA buttons
- Feature descriptions

### Brand Colors
Configure in `tailwind.config.js`:
```js
colors: {
  'islamic-emerald': '#10B981',
  'islamic-gold': '#D4AF37',
  'islamic-navy': '#0F172A'
}
```

## 🔧 Development

### Running Development Servers
```bash
# Terminal 1 - Laravel
php artisan serve

# Terminal 2 - Vite
npm run dev
```

### Clear Cache
```bash
php artisan optimize:clear
```

### Build for Production
```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🤝 Contributing

We welcome contributions! Please follow these guidelines:

1. **Branch naming:**
   - `feature/` for new features
   - `bugfix/` for bug fixes
   - `hotfix/` for urgent fixes

2. **Commit messages:**
   - `feat:` for new features
   - `fix:` for bug fixes
   - `docs:` for documentation
   - `style:` for formatting
   - `refactor:` for code refactoring

3. **Pull Requests:**
   - Create PR to `develop` branch
   - Add clear description
   - Link related issues

## 📝 Database Schema

### Key Tables
- `users` - All users (admin, student, teacher)
- `tahsin_classes` - Class definitions with prices
- `subscriptions` - User class enrollments
- `lessons` - Lesson content
- `user_progress` - Student learning progress
- `class_schedules` - Class meeting schedules
- `payments` - Payment transactions

## 🛠️ Troubleshooting

### Common Issues

**Migration errors:**
```bash
php artisan migrate:fresh --seed
```

**Assets not loading:**
```bash
npm run build
php artisan storage:link
```

**Permission errors:**
```bash
chmod -R 775 storage bootstrap/cache
```

## 📞 Contact & Support

- **Alamat:** Pelem II, Pelem, Kec. Ngawi, Kabupaten Ngawi, Jawa Timur
- **Instagram:** [@masjidjamisosrohadisewoyo](https://www.instagram.com/masjidjamisosrohadisewoyo)

## 📄 License

This project is proprietary software. All rights reserved.

## 🙏 Acknowledgments

- Masjid Jami Sosrohadisewoyo - Ngawi
- All contributors and testers

---

Made with ❤️ for the Muslim community
