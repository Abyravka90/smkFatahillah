# Agent Guide: smkfatahillah (Laravel)

High-signal guidance for agents working in this repository.

## Developer Commands

- **Development:** `php artisan serve` & `npm run dev` (or `composer dev` to run concurrently)
- **Tests:** `php artisan test` or `composer test`
- **Linting:** `vendor/bin/pint` (Laravel Pint is used)
- **Migrations:** `php artisan migrate`
- **Seeders:** `php artisan db:seed`

## Architecture & Structure

- **Framework:** Laravel 12.x with PHP 8.2+
- **Frontend:** Vite, Tailwind CSS 4.0, Sass, and Bootstrap 5.2
- **Auth:** Laravel UI (Bootstrap-based) and Sanctum for API
- **Permissions:** `spatie/laravel-permission`
- **Helpers:** Custom helper at `app/Helpers/helpers.php` (auto-loaded)
- **Controllers:** 
    - `app/Http/Controllers/Admin/`: Back-end management logic
    - `app/Http/Controllers/Api/`: RESTful API endpoints
- **Models:** Standard Eloquent models in `app/Models/`
- **Views:** Blade templates in `resources/views/`, organized by `admin` and `auth`

## Key Conventions

- **Migrations:** Some migrations are stored in `database/migrations/old/`. Always check both locations before creating new ones.
- **API Documentation:** API docs are served via `resources/views/docs/api.blade.php`.
- **Naming:** Follows standard Laravel PSR-4 naming conventions.
- **Business Logic:** Primarily located in Controllers, though some logic exists in Models.

## Operational Gotchas

- **Environment:** Requires a `.env` file (copy from `.env.example`).
- **Database:** Uses MySQL/MariaDB (see `database/schema/mysql-schema.sql`).
- **Vite:** Vite is used for asset bundling. Ensure `npm run dev` is running for local asset compilation.
