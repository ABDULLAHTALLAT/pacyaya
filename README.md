# Pacyaya

Packaging design platform: pick a box template, customise it live in 3D, share a preview link and order prints from local print houses. Built with Laravel 12 and MySQL.

## Features
- Template catalog with categories and search
- Live 3D box editor (Three.js): size, color, text, artwork upload, open/close lid animation, drag to rotate, wheel to zoom
- Saved designs per user, public preview links
- Print house directory with pricing, minimum runs and lead times
- Orders with automatic pricing and status tracking
- Admin dashboard with stats and order status updates
- Seeders for users, categories, templates and printers

## Setup
```
composer install
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```
Requires PHP 8.2+, Composer and MySQL. Create the database first: `CREATE DATABASE pacyaya CHARACTER SET utf8mb4;` and adjust `DB_USERNAME` / `DB_PASSWORD` in `.env`.

Demo logins: `admin@pacyaya.test` / `password`, `demo@pacyaya.test` / `password`.
