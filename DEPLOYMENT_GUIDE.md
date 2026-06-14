# 🚀 Deployment Guide - Professional Blog

Panduan lengkap untuk deploy blog Anda ke production server.

## 📋 Daftar Isi
1. [Persiapan](#persiapan)
2. [Deploy ke Hosting](#deploy-ke-hosting)
3. [Setup Server](#setup-server)
4. [Database Migration](#database-migration)
5. [Konfigurasi Web Server](#konfigurasi-web-server)
6. [SSL Certificate](#ssl-certificate)
7. [Monitoring & Maintenance](#monitoring--maintenance)
8. [Troubleshooting](#troubleshooting)

---

## 📦 Persiapan

### 1. Checklist Pre-Deployment

```
☐ Database backup lokal
☐ All code committed to git
☐ .env.example updated
☐ Tests passed locally
☐ Assets compiled (npm run build)
☐ Domain registered & pointing to server
☐ SSL certificate ready
☐ SSH access ke server
☐ FTP/Git access configured
```

### 2. Pilih Hosting Provider

**Opsi Populer untuk Laravel:**

| Provider | Harga | Fitur | Link |
|----------|-------|-------|------|
| Laravel Forge | $12/month | 1-click deploy, auto SSL | forge.laravel.com |
| Heroku | Free-$7/month | Git push to deploy | heroku.com |
| DigitalOcean | $5-60/month | VPS flexibility | digitalocean.com |
| Cloudways | $10+/month | Managed cloud hosting | cloudways.com |
| Shared Hosting | $2-10/month | Budget option | niagahoster.co.id |

---

## 🌐 Deploy ke Hosting

### Opsi 1: Laravel Forge (Recommended)

#### Step 1: Setup di Forge

1. Login ke https://forge.laravel.com
2. Klik "Create Server"
3. Pilih provider (DigitalOcean, Linode, AWS)
4. Configure server

#### Step 2: Connect Repository

1. Di Forge, klik "Create Site"
2. Masukkan domain: `yourdomain.com`
3. Pilih "Git Repository"
4. Hubungkan GitHub
5. Pilih branch: `main`

#### Step 3: Deploy

```bash
# Forge automatically deploys on git push
git push origin main
# Forge akan deploy otomatis ke production
```

---

### Opsi 2: Manual Deploy via SSH

#### Step 1: Connect ke Server

```bash
ssh user@yourdomain.com
# atau dengan port khusus
ssh -p 2222 user@yourdomain.com
```

#### Step 2: Setup Directory

```bash
# Navigate ke web root
cd /var/www

# Clone repository
git clone https://github.com/yourusername/professional-blog.git
cd professional-blog
```

#### Step 3: Install Dependencies

```bash
# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install Node dependencies
npm install
npm run build
```

#### Step 4: Setup Environment

```bash
# Copy env file
cp .env.example .env

# Generate key
php artisan key:generate

# Edit env dengan credentials
nano .env
```

Edit `.env`:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=professional_blog
DB_USERNAME=blog_user
DB_PASSWORD=secure_password_here
```

#### Step 5: Database Setup

```bash
# Create database
mysql -u root -p
CREATE DATABASE professional_blog;
CREATE USER 'blog_user'@'localhost' IDENTIFIED BY 'secure_password_here';
GRANT ALL PRIVILEGES ON professional_blog.* TO 'blog_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### Step 6: Run Migrations

```bash
php artisan migrate --force
php artisan db:seed --force
```

#### Step 7: Set Permissions

```bash
# Set proper permissions
sudo chown -R www-data:www-data /var/www/professional-blog
sudo chmod -R 755 /var/www/professional-blog
sudo chmod -R 775 /var/www/professional-blog/storage
sudo chmod -R 775 /var/www/professional-blog/bootstrap/cache
```

---

### Opsi 3: Deploy via Heroku

#### Step 1: Install Heroku CLI

```bash
# macOS
brew tap heroku/brew && brew install heroku

# Windows/Linux
# Download dari https://devcenter.heroku.com/articles/heroku-cli
```

#### Step 2: Login & Create App

```bash
heroku login
heroku create professional-blog
```

#### Step 3: Add Buildpacks

```bash
heroku buildpacks:add heroku/php
heroku buildpacks:add heroku/nodejs
```

#### Step 4: Setup Environment

```bash
heroku config:set APP_KEY=$(php artisan key:generate --show)
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set APP_URL=https://professional-blog.herokuapp.com
```

#### Step 5: Add Database

```bash
# Add ClearDB MySQL
heroku addons:create cleardb:ignite

# Get credentials
heroku config | grep CLEARDB_DATABASE_URL
```

#### Step 6: Deploy

```bash
git push heroku main

# Run migrations
heroku run php artisan migrate --force
heroku run php artisan db:seed --force
```

---

## ⚙️ Setup Server

### 1. Update System

```bash
sudo apt update
sudo apt upgrade -y
```

### 2. Install Requirements

```bash
# PHP 8.2
sudo apt install -y php8.2 php8.2-cli php8.2-fpm php8.2-mysql php8.2-zip php8.2-gd php8.2-mbstring php8.2-curl php8.2-xml

# Nginx
sudo apt install -y nginx

# MySQL
sudo apt install -y mysql-server

# Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs
```

### 3. Start Services

```bash
sudo systemctl start nginx
sudo systemctl start mysql
sudo systemctl start php8.2-fpm

# Enable auto-start
sudo systemctl enable nginx
sudo systemctl enable mysql
sudo systemctl enable php8.2-fpm
```

---

## 🗄️ Database Migration

### 1. Backup Database Lokal

```bash
# Export dari lokal
mysqldump -u root professional_blog > backup.sql
```

### 2. Import ke Production

```bash
# SSH ke server
ssh user@yourdomain.com

# Import database
mysql -u blog_user -p professional_blog < /path/to/backup.sql
```

### 3. Auto-Migration

```bash
# Atau biarkan Laravel handle migrations
cd /var/www/professional-blog
php artisan migrate --force
```

---

## 🌍 Konfigurasi Web Server

### Nginx Configuration

Buat file `/etc/nginx/sites-available/professional-blog`:

```nginx
server {
    listen 80;
    listen [::]:80;
    
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/professional-blog/public;
    index index.php;

    # Redirect HTTP to HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/professional-blog/public;
    index index.php;

    # SSL certificates
    ssl_certificate /etc/ssl/certs/your_cert.crt;
    ssl_certificate_key /etc/ssl/private/your_key.key;

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;

    # Gzip compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1000;
    gzip_types text/plain text/css text/xml text/javascript application/x-javascript application/xml+rss application/javascript;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }

    # Cache static files
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

Enable configuration:

```bash
sudo ln -s /etc/nginx/sites-available/professional-blog /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

---

## 🔒 SSL Certificate

### Option 1: Let's Encrypt (Free)

```bash
# Install Certbot
sudo apt install -y certbot python3-certbot-nginx

# Get certificate
sudo certbot certonly --nginx -d yourdomain.com -d www.yourdomain.com

# Auto-renew
sudo systemctl enable certbot.timer
```

### Option 2: Paid Certificate

Beli dari provider seperti:
- Comodo
- GlobalSign
- GoDaddy

---

## 📊 Monitoring & Maintenance

### 1. Setup Log Rotation

File `/etc/logrotate.d/professional-blog`:

```
/var/www/professional-blog/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    create 0640 www-data www-data
    sharedscripts
    postrotate
        systemctl reload nginx > /dev/null 2>&1 || true
    endscript
}
```

### 2. Monitor Disk Space

```bash
# Check disk usage
df -h

# Check folder size
du -sh /var/www/professional-blog
```

### 3. Monitor Performance

```bash
# CPU & Memory
top

# Network
netstat -tuln
```

### 4. Automatic Backups

Buat script `/home/user/backup.sh`:

```bash
#!/bin/bash

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/home/user/backups"

# Database backup
mysqldump -u blog_user -p"$DB_PASSWORD" professional_blog > $BACKUP_DIR/db_$DATE.sql

# Files backup
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/professional-blog

# Keep only last 7 backups
find $BACKUP_DIR -type f -mtime +7 -delete

echo "Backup completed: $DATE"
```

Add to crontab:

```bash
crontab -e

# Add line:
0 2 * * * /bin/bash /home/user/backup.sh >> /var/log/backup.log 2>&1
```

---

## 🔧 Troubleshooting

### Error 500 - Internal Server Error

```bash
# Check Laravel logs
tail -f /var/www/professional-blog/storage/logs/laravel.log

# Check permissions
ls -la /var/www/professional-blog/storage

# Check Nginx logs
tail -f /var/log/nginx/error.log
```

### Database Connection Error

```bash
# Test MySQL connection
mysql -u blog_user -p -h localhost professional_blog

# Check .env credentials
cat /var/www/professional-blog/.env | grep DB_
```

### High Memory Usage

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear

# Optimize composer
composer dump-autoload --optimize
```

### Slow Performance

```bash
# Enable query logging
php artisan tinker
DB::enableQueryLog();

# Check slow queries
tail -f /var/log/mysql/slow.log
```

### SSL Certificate Issues

```bash
# Check certificate validity
openssl x509 -in /etc/ssl/certs/your_cert.crt -text -noout

# Renew manually
sudo certbot renew --force-renewal
```

---

## 📋 Deployment Checklist

```
Pre-Deployment:
☐ All changes committed
☐ Tests passed
☐ .env.example updated
☐ Assets compiled

Server Setup:
☐ PHP 8.2 installed
☐ Nginx installed
☐ MySQL installed
☐ Composer installed
☐ Node.js installed

Repository:
☐ Repository cloned
☐ Composer install --no-dev
☐ npm install && npm run build
☐ Permissions set correctly

Environment:
☐ .env configured
☐ APP_KEY generated
☐ APP_URL set correctly
☐ Database credentials correct

Database:
☐ Database created
☐ User created with privileges
☐ Migrations run
☐ Seeders run

Web Server:
☐ Nginx configured
☐ SSL certificate installed
☐ Firewall configured
☐ DNS pointing to server

Monitoring:
☐ Error logs accessible
☐ Cron jobs configured
☐ Backups scheduled
☐ Monitoring tools installed

Final:
☐ Test production URL
☐ Check Google Search Console
☐ Monitor error logs
☐ Setup uptime monitoring
```

---

## 🎯 Post-Deployment Tasks

1. **Submit Sitemap to Google**
   - Go to Google Search Console
   - Submit `/sitemap.xml`

2. **Setup Email**
   - Configure SMTP for notifications

3. **Setup Cron Jobs**
   ```bash
   * * * * * cd /var/www/professional-blog && php artisan schedule:run >> /dev/null 2>&1
   ```

4. **Setup Monitoring**
   - UptimeRobot untuk monitor uptime
   - NewRelic untuk performance monitoring

5. **Security Hardening**
   - Disable admin panel dari public IPs
   - Setup rate limiting
   - Enable two-factor authentication

---

## 📞 Support

- [Laravel Deployment](https://laravel.com/docs/11.x/deployment)
- [Nginx Documentation](https://nginx.org/en/docs/)
- [MySQL Documentation](https://dev.mysql.com/doc/)

---

**Blog Anda siap untuk production! 🎉**

Jika ada pertanyaan, silakan cek logs atau hubungi support hosting Anda.

Happy deploying! 🚀
