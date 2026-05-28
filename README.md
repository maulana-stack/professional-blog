# 📝 Professional Blog

A modern, professional blog platform built with **Laravel 11**, **Filament 3**, **Livewire 3**, and **Tailwind CSS**.

Perfect for personal blogs, news portals, and other content management needs!

## ✨ Features

### 🚀 Core Features
- ✅ Multi-user author system dengan role-based access control
- ✅ Rich post editor dengan markdown support
- ✅ Category dan tag management system
- ✅ Featured posts functionality
- ✅ Post scheduling (publish/unpublish dates)
- ✅ Image optimization dan management
- ✅ SEO-friendly URLs dengan automatic slug generation
- ✅ Real-time search dan filtering dengan Livewire
- ✅ Comment system dengan moderation
- ✅ Reading time estimation
- ✅ View counter untuk setiap post

### 🎨 Admin Panel
- ✅ Filament 3 admin dashboard yang powerful
- ✅ CRUD management untuk posts, categories, users
- ✅ Media manager dengan upload optimization
- ✅ User dan role management
- ✅ Analytics dashboard
- ✅ Settings management

### 🌐 Frontend
- ✅ Responsive design dengan Tailwind CSS
- ✅ Blog listing dengan pagination
- ✅ Single post view dengan related posts
- ✅ Archive by date
- ✅ Category pages
- ✅ Author profiles
- ✅ Real-time search functionality
- ✅ Social sharing buttons
- ✅ Newsletter subscription form

## 📋 Requirements

- **PHP** 8.2 atau lebih tinggi
- **Composer** (untuk manage PHP dependencies)
- **Node.js** 16 atau lebih tinggi (untuk manage JavaScript)
- **MySQL** 8.0 atau lebih tinggi

## 🚀 Installation

### Step 1: Clone Repository
```bash
git clone https://github.com/maulana-stack/professional-blog.git
cd professional-blog
```

### Step 2: Install PHP Dependencies
```bash
composer install
```

### Step 3: Install JavaScript Dependencies
```bash
npm install
```

### Step 4: Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### Step 5: Configure Database
Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=professional_blog
DB_USERNAME=root
DB_PASSWORD=
```

Kemudian jalankan migration:
```bash
php artisan migrate
php artisan db:seed
```

### Step 6: Build Frontend Assets
```bash
npm run build
```

### Step 7: Start Development Server
Buka 2 terminal:

**Terminal 1** - Start Laravel server:
```bash
php artisan serve
```

**Terminal 2** - Watch untuk CSS/JS changes:
```bash
npm run dev
```

## 🌐 Access Points

| URL | Purpose |
|-----|---------|
| `http://localhost:8000` | Frontend Blog |
| `http://localhost:8000/admin` | Admin Panel (Filament) |
| `admin@example.com` | Default Admin Email |
| `password` | Default Admin Password |

## 📁 Project Structure

```
professional-blog/
├── app/
│   ├── Models/                      # Database models
│   │   ├── Post.php                # Post model
│   │   ├── Category.php            # Category model
│   │   ├── User.php                # User model
│   │   └── Comment.php             # Comment model
│   ├── Filament/                   # Filament admin resources
│   ├── Livewire/                   # Livewire components
│   │   ├── SearchPosts.php        # Search component
│   │   └── PostComments.php        # Comments component
│   └── Http/Controllers/
│       └── BlogController.php       # Frontend controller
├── database/
│   ├── migrations/                 # Database migrations
│   ├── seeders/                    # Database seeders
│   └── factories/                  # Model factories
├── resources/
│   ├── css/
│   │   └── app.css                # Tailwind CSS
│   ├── js/
│   │   └── app.js                 # Alpine.js & Livewire
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php      # Main layout
│       ├── blog/
│       │   ├── index.blade.php    # Blog listing
│       │   └── show.blade.php     # Single post
│       ├── home.blade.php          # Homepage
│       └── livewire/               # Livewire views
├── routes/
│   └── web.php                     # Web routes
└── storage/
    └── uploads/                    # Uploaded files
```

## ⚙️ Configuration

### Database
Update `.env` dengan credentials database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=professional_blog
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Mail Configuration
```env
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@example.com
```

### Storage (Upload Files)
Pastikan folder `storage` writable:
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

## 🛠️ Technologies Used

| Technology | Version | Purpose |
|------------|---------|---------|
| Laravel | 11.x | Backend framework |
| Filament | 3.x | Admin panel |
| Livewire | 3.x | Real-time components |
| Tailwind CSS | 3.x | Styling |
| Alpine.js | 3.x | Lightweight JS |
| MySQL | 8.0+ | Database |
| Vite | 5.x | Frontend bundler |

## 📝 Common Artisan Commands

```bash
# Database
php artisan migrate              # Run migrations
php artisan migrate:rollback     # Rollback migration
php artisan db:seed              # Seed database
php artisan tinker               # Interactive shell

# Make Commands
php artisan make:model Post -m   # Create model with migration
php artisan make:controller PostController
php artisan make:filament-resource Post
php artisan make:livewire SearchPosts
php artisan make:mail SendNewsletter

# Cache & Config
php artisan cache:clear
php artisan config:cache
php artisan view:clear
php artisan route:clear

# Serve
php artisan serve                # Start dev server (port 8000)
php artisan serve --port=8001    # Custom port
```

## 🎯 Usage Examples

### Create a New Post (via Admin)
1. Login ke admin panel (`/admin`)
2. Pergi ke Posts
3. Klik "Create Post"
4. Isi form dengan:
   - Title
   - Category
   - Content (Markdown supported)
   - Image
   - Excerpt
5. Set publish date
6. Mark sebagai Featured jika ingin
7. Submit

### View Posts
- **Homepage:** Lihat featured dan latest posts
- **Blog Page:** Browse semua posts dengan filter
- **By Category:** Filter posts berdasarkan kategori
- **Search:** Real-time search dengan Livewire

### Comment System
Visitors bisa membuat comment, akan di-moderate sebelum tampil di frontend.

## 🚀 Deployment

### Prerequisites
- Server dengan PHP 8.2+
- Composer
- Node.js
- MySQL database
- Git (opsional)

### Deployment Steps

1. **Clone repository**
```bash
git clone https://github.com/maulana-stack/professional-blog.git
cd professional-blog
```

2. **Install dependencies**
```bash
composer install --no-dev
npm install
npm run build
```

3. **Setup environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure database di .env**
```bash
nano .env
```

5. **Run migrations**
```bash
php artisan migrate --force
```

6. **Set permissions**
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

7. **Configure web server** (Nginx example)
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/professional-blog/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

8. **Restart web server**
```bash
sudo systemctl restart nginx
# or
sudo systemctl restart apache2
```

## 📊 Database Schema

### Posts Table
- id
- title
- slug (unique)
- excerpt
- content
- image
- category_id (FK)
- author_id (FK)
- published_at
- featured (boolean)
- reading_time
- views (counter)
- timestamps
- soft deletes

### Categories Table
- id
- name
- slug (unique)
- description
- timestamps

### Comments Table
- id
- post_id (FK)
- name
- email
- content
- approved (boolean)
- timestamps

### Users Table
- id
- name
- email
- password
- avatar
- bio
- role (admin/author)
- email_verified_at
- timestamps

## 🔒 Security Features

- ✅ CSRF protection
- ✅ SQL injection prevention dengan Eloquent ORM
- ✅ XSS protection dengan Blade escaping
- ✅ Password hashing dengan bcrypt
- ✅ Role-based access control
- ✅ Comment moderation
- ✅ Rate limiting untuk form submissions

## 🐛 Troubleshooting

### Migration Errors
```bash
# Reset database
php artisan migrate:refresh

# Seed after reset
php artisan db:seed
```

### Permission Issues
```bash
# Fix storage permissions
chmod -R 755 storage bootstrap/cache
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Vite Build Issues
```bash
# Rebuild assets
npm run build

# Watch for changes
npm run dev
```

## 📚 Useful Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Filament Documentation](https://filamentphp.com)
- [Livewire Documentation](https://livewire.laravel.com)
- [Tailwind CSS](https://tailwindcss.com)

## 📄 License

MIT License - Bebas digunakan untuk project personal atau commercial

## 👨‍💻 Author

**Maulana Stack** - Professional Laravel Developer

## 🤝 Contributing

Contributions welcome! Silakan fork repository dan submit pull requests.

## 💬 Support

Jika ada pertanyaan atau issue, silakan:
- Buat issue di GitHub
- Email: support@example.com

---

**Happy Blogging! 🎉**

Dibuat dengan ❤️ menggunakan Laravel, Filament, Livewire, dan Tailwind CSS
