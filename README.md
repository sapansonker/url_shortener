<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Project README

A Laravel-based multi-tenant URL shortener with role-based authentication, company management, click tracking, and CSV export.

## Features

- Multi-role access: `Super_admin`, `Admin`, `Member`
- Super admin create admin
- Admin create amdin/member/url
- Member create url only
- Short URL generation and redirect tracking
- CSV URL export for admins and super admins

## Requirements

- PHP ^8.2
- Composer
- MySQL
- Node.js + npm

## Setup

```bash
git clone https://github.com/sapansonker/url_shortener.git
cd url_shortener
composer install
npm install
cp .env.example .env
```

## Environment

Update `.env` with your database credentials.
Create database name url_shortener

### Database example

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=url_shortener
DB_USERNAME=
DB_PASSWORD=
```

## Database

```bash
php artisan migrate
php artisan db:seed
```

## Build & Run

```bash
php artisan serve
```

Open `http://localhost:8000`.

## Application Flow

1. Super admin logs in.
2. Clicks **Invite Client**.
3. Sends an invitation email.
4. Client opens the invite link.
5. Client completes registration.

## Common Commands

```bash
php artisan migrate
php artisan db:seed
php artisan config:clear
php artisan optimize:clear
npm run dev
npm run build
```

## Notes

- Gmail SMTP and Test not implemented due to time issue because of office work.
- Use `php artisan optimize:clear` after changing `.env`.
