#!/usr/bin/env bash
# Pushes the project as a short series of real commits (current dates), authored by you only.
set -e
git init -b master 2>/dev/null || true
git checkout -B master
git config user.name "ABDULLAHTALLAT"
git config user.email "tallata363@gmail.com"
git remote remove origin 2>/dev/null || true
git remote add origin https://github.com/ABDULLAHTALLAT/pacyaya.git

commit_paths () {
  msg="$1"; shift
  for p in "$@"; do [ -e "$p" ] && git add -- "$p"; done
  git diff --cached --quiet || git commit -m "$msg"
}

commit_paths "Add Laravel 12 base application" artisan composer.json composer.lock package.json vite.config.js phpunit.xml .editorconfig .gitattributes .gitignore .env.example bootstrap config storage tests public/index.php public/.htaccess public/robots.txt public/favicon.ico app/Http/Controllers/Controller.php app/Providers resources/css resources/js
commit_paths "Add database schema and models" database/migrations app/Models
commit_paths "Add seeders for users, categories, templates and printers" database/seeders
commit_paths "Add authentication and locale middleware" app/Http/Middleware app/Http/Controllers/AuthController.php
commit_paths "Add Arabic and English translations" lang
commit_paths "Add catalog, design, order, printer and admin controllers" app/Http/Controllers app/Support routes
commit_paths "Add 3D box engine, patterns and dieline generator" public/js
commit_paths "Add site styles" public/css
commit_paths "Add storefront views and layouts" resources/views/layouts resources/views/partials resources/views/home.blade.php resources/views/pricing.blade.php resources/views/templates resources/views/tools resources/views/printers resources/views/auth
commit_paths "Add editor, orders and admin views" resources/views/designs resources/views/orders resources/views/admin
commit_paths "Add images and documentation" public/images README.md push.sh
git add -A
git diff --cached --quiet || git commit -m "Add remaining project files"

git fetch origin master 2>/dev/null && git pull --rebase --allow-unrelated-histories origin master || true
git push -u origin master
