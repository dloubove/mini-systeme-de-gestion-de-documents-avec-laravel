[🇫🇷 Français](README.md) | 🇬🇧 English

# GED: Electronic Document Management

Solution to **Workshop 6 (Prosit 6): Laravel Framework**. A document management web application built with **Laravel 12**, **Breeze** (authentication, Blade + Tailwind + Alpine) and **MySQL** (or SQLite).

## Features

- Registration, login, logout, profile (Laravel Breeze)
- **User** CRUD
- **Document** CRUD with file upload (pdf, doc, docx, txt, png, jpg, 2 MB max)
- A document **belongs to a user**: only its owner can edit or delete it
- Document **search** by title
- Routes protected by the `auth` middleware
- Validation messages in French, displayed under each field
- Dashboard with counters, automated tests

## Requirements

| Tool | Version | Check |
|---|---|---|
| PHP | 8.2 or higher (extensions `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `xml`, `ctype`, `curl`) | `php -v` |
| Composer | 2.x | `composer -V` |
| Node.js + npm | 18 or higher | `node -v` |
| MySQL | 5.7+ / MariaDB (WAMP, XAMPP, Laragon) | phpMyAdmin reachable |

> SQLite can be used instead of MySQL (see below).

## Installation

Open a terminal **in the project folder** (the one containing the `artisan` file).

**1. Install PHP dependencies**
```bash
composer install
```

**2. Create the environment file**
```bash
# Windows (cmd)
copy .env.example .env

# Linux / macOS / Git Bash
cp .env.example .env
```

**3. Generate the application key**
```bash
php artisan key:generate
```

**4. Create the database**

In phpMyAdmin, create a database named **`ged`** (collation `utf8mb4_unicode_ci`).
Then check `.env` (WAMP/XAMPP defaults):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ged
DB_USERNAME=root
DB_PASSWORD=
```

**5. Create the tables and a demo account**
```bash
php artisan migrate --seed
```

**6. Make uploaded files accessible**
```bash
php artisan storage:link
```

**7. Install and build the front end**
```bash
npm install
npm run build
```

**8. Start the application**
```bash
php artisan serve
```
Open **http://127.0.0.1:8000**.

### Demo account

| Email | Password |
|---|---|
| `test@example.com` | `password` |

You can also create your own account with "Register".

## Using SQLite (no MySQL)

In `.env`, comment out the six MySQL `DB_*` lines and uncomment `DB_CONNECTION=sqlite`. Then:
```bash
# Windows (cmd)
type nul > database\database.sqlite
# Linux / macOS / Git Bash
touch database/database.sqlite

php artisan migrate --seed
```
The rest of the installation is identical.

## Development mode (automatic CSS/JS reload)

In a second terminal, instead of `npm run build`:
```bash
npm run dev
```

## Automated tests

```bash
php artisan test
```
Tests use an **in-memory** SQLite database (`pdo_sqlite` extension required): your `ged` database is never touched.

## Mapping to the workshop

| Step | Where the solution is |
|---|---|
| 1-2. Project and `.env` | `.env.example` |
| 3. Migrations and models | `database/migrations/2026_10_16_000000_create_documents_table.php`, `app/Models/Document.php`, `app/Models/User.php` |
| 4. Authentication (Breeze) | `app/Http/Controllers/Auth/`, `routes/auth.php`, `resources/views/auth/` |
| 5. CRUD controllers | `app/Http/Controllers/UserController.php`, `DocumentController.php` |
| 6 and 9. Routes and `auth` middleware | `routes/web.php` |
| 7. Views | `resources/views/documents/`, `resources/views/users/` |
| 8. Search | `DocumentController::search()`, route `documents.search`, form in `documents/index.blade.php` |
| 10. Error handling | `lang/fr/validation.php`, `@error` / `<x-input-error>` in the views |

## Main routes

| Method | URL | Purpose |
|---|---|---|
| GET | `/documents` | List documents |
| GET | `/documents/search?query=...` | Search by title |
| GET / POST | `/documents/create`, `/documents` | Form and save |
| GET / PUT / DELETE | `/documents/{id}`, `/documents/{id}/edit` | Show, update, delete |
| GET ... | `/users`, `/users/create`, `/users/{id}`, `/users/{id}/edit` | User CRUD |

Full list: `php artisan route:list`.

## Troubleshooting

| Message / symptom | Fix |
|---|---|
| `Vite manifest not found` | Run `npm install` then `npm run build` (or `npm run dev`). |
| `Unknown database 'ged'` (1049) | Create the `ged` database in phpMyAdmin. |
| `Access denied for user` (1045) | Fix `DB_USERNAME` and `DB_PASSWORD` in `.env`. |
| `could not find driver` | Enable `pdo_mysql` (or `pdo_sqlite`) in `php.ini`, then restart Apache/the terminal. |
| `No application encryption key has been specified` | Run `php artisan key:generate`. |
| An uploaded file gives a 404 error | Run `php artisan storage:link` (first delete any existing `public/storage` folder). |
| Upload fails without a clear message | Check `upload_max_filesize` and `post_max_size` in `php.ini` (the application limit is 2 MB). |
| `.env` changed but no effect | Run `php artisan config:clear`. |
| 419 "Page Expired" error | Reload the page and always use the same address (`127.0.0.1` or `localhost`). |
| Port 8000 is already in use | `php artisan serve --port=8001`. |
| `composer install` refuses because of the PHP version | Switch to PHP 8.2 or higher (WAMP/XAMPP menu). |

## License

Educational project. Laravel and Breeze are MIT licensed.
