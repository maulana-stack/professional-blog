#!/bin/bash

# Professional Blog Installation Script
# This script sets up the Professional Blog project

set -e

echo "🚀 Professional Blog Installation"
echo "=================================="

# Check if .env exists
if [ ! -f .env ]; then
    echo "📋 Creating .env file from .env.example..."
    cp .env.example .env
    echo "✅ .env created"
fi

# Generate application key
if grep -q "APP_KEY=$" .env; then
    echo "🔑 Generating application key..."
    php artisan key:generate
    echo "✅ Application key generated"
fi

# Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install
echo "✅ PHP dependencies installed"

# Install Node dependencies
echo "📦 Installing Node dependencies..."
npm install
echo "✅ Node dependencies installed"

# Build frontend assets
echo "🎨 Building frontend assets..."
npm run build
echo "✅ Frontend assets built"

# Run migrations
echo "🗄️  Running database migrations..."
php artisan migrate --force
echo "✅ Database migrations completed"

# Seed database (optional)
read -p "Do you want to seed the database? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo "🌱 Seeding database..."
    php artisan db:seed
    echo "✅ Database seeded"
fi

# Create storage symlink
if [ ! -L public/storage ]; then
    echo "🔗 Creating storage symlink..."
    php artisan storage:link
    echo "✅ Storage symlink created"
fi

echo ""
echo "✨ Installation Complete!"
echo ""
echo "Next steps:"
echo "1. Update .env with your database credentials"
echo "2. Run: php artisan serve"
echo "3. In another terminal, run: npm run dev"
echo "4. Visit: http://localhost:8000"
echo "5. Access admin at: http://localhost:8000/admin"
echo ""
echo "Default admin credentials:"
echo "Email: admin@example.com"
echo "Password: password"
echo ""
