## Fleet Service Book — Laravel 11 + Filament 4

Polska ksiąŜka serwisowa floty (auta + motocykle). Backend: Laravel 11 (PHP 8.2+). Panel administracyjny: Filament 4. Język: pl-PL, waluta: PLN, jednostki: km/litry.

### Wymagania
- PHP 8.2+
- Composer 2.x
- Node.js 18+ (Vite)
- Database: MySQL 8 / MariaDB 10.6+ / SQLite
- Opcjonalnie: Docker (Laravel Sail)

### Szybki start (lokalnie)
1. Sklonuj repo i zainstaluj zależności
```bash
composer install
npm install
```
2. Skonfiguruj środowisko
```bash
cp .env.example .env
php artisan key:generate
```
3. Ustaw dane DB w `.env`, następnie uruchom migracje i seedy (opcjonalnie)
```bash
php artisan migrate
```
4. Uruchom aplikację
```bash
php artisan serve
npm run dev
```

### Uruchomienie z Docker (Laravel Sail)
1. Zainstaluj Sail
```bash
php artisan sail:install --no-interaction
```
2. Podnieś kontenery i wygeneruj klucz
```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

### Konfiguracja i18n PL
- Domyślne `app.locale=pl`, `app.fallback_locale=pl`, `app.timezone=Europe/Warsaw`, `faker_locale=pl_PL` są ustawione.
- `AppServiceProvider` ustawia lokalizację Carbon i strefę czasową podczas bootowania aplikacji.

### Autoryzacja i role (ETAP 3)
- Laravel Breeze (auth web):
```bash
# composer require laravel/breeze --dev
# php artisan breeze:install blade --dark
# npm install && npm run build
# php artisan migrate
```
- spatie/laravel-permission (role i uprawnienia):
```bash
# composer require spatie/laravel-permission
# php artisan vendor:publish --provider="Spatie\\Permission\\PermissionServiceProvider"
# php artisan migrate
# php artisan db:seed --class=RolesAndPermissionsSeeder
```
Uwaga: ustaw w `.env` wartości `ADMIN_EMAIL` i `ADMIN_PASSWORD` dla admina.

### Proponowane pakiety (komendy instalacji w komentarzach)
- Filament 4 (panel admina)
```bash
# composer require filament/filament:"^4.0"
```
- laravel/breeze (auth)
```bash
# composer require laravel/breeze --dev
# php artisan breeze:install blade --dark
# php artisan migrate
```
- spatie/laravel-permission (role: Admin/Manager/Mechanic/Viewer)
```bash
# composer require spatie/laravel-permission
# php artisan vendor:publish --provider="Spatie\\Permission\\PermissionServiceProvider"
# php artisan migrate
# php artisan db:seed --class=RolesAndPermissionsSeeder
```
- spatie/laravel-activitylog (log zmian)
```bash
# composer require spatie/laravel-activitylog
# php artisan vendor:publish --provider="Spatie\\Activitylog\\ActivitylogServiceProvider" --tag="activitylog-migrations"
# php artisan migrate
```
- spatie/laravel-medialibrary (załączniki: faktury/zdjęcia)
```bash
# composer require spatie/laravel-medialibrary
# php artisan vendor:publish --provider="Spatie\\MediaLibrary\\MediaLibraryServiceProvider" --tag="migrations"
# php artisan migrate
```
- spatie/laravel-backup (kopie zapasowe)
```bash
# composer require spatie/laravel-backup
# php artisan vendor:publish --provider="Spatie\\Backup\\BackupServiceProvider"
```
- maatwebsite/excel (import/eksport CSV/XLSX)
```bash
# composer require maatwebsite/excel
```
- barryvdh/laravel-dompdf (PDF książki serwisowej)
```bash
# composer require barryvdh/laravel-dompdf
```

### Scheduler (cron) i Queue worker
- Uruchomienie schedulera (cron) na serwerze produkcyjnym:
```bash
# Edit crontab
crontab -e
# Dodaj wpis (uruchamia scheduler co minutę):
* * * * * cd /var/www/fleet-service-book && php artisan schedule:run >> /dev/null 2>&1
```
- Uruchomienie workerów kolejki:
```bash
php artisan queue:work --stop-when-empty
# lub w tle (supervisor w produkcji)
php artisan queue:work --daemon
```

### Uwagi
- Domyślne jednostki: km, litry; waluta: PLN.
- Kolejka domyślnie używa `database` (pamiętaj o migracji tabeli jobs — jest wstępnie dodana w Laravel 11).
