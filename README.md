## Fleet Service Book — Laravel 11 + Filament 4

Polska i wielojęzyczna (PL/EN) książka serwisowa floty dla aut i motocykli. Backend: Laravel 11 (PHP 8.2+). Panel: Filament 4. Domyślnie język PL, waluta PLN, jednostki km/litry.

### Najważniejsze funkcje
- Zarządzanie pojazdami (auta, motocykle), przebiegami i historią serwisową
- Części i dostawcy, powiązania z pojazdami
- Reguły serwisowe cykliczne (interwały km/miesiące), statusy: zbliżające się, termin, przeterminowane
- Powiadomienia mailowe i w panelu o nadchodzących/przeterminowanych czynnościach
- Panel admina Filament 4 (PL/EN), role i uprawnienia (Spatie Permission)
- Załączniki (faktury/zdjęcia) i log aktywności (Spatie Media Library, Activitylog)
- Eksporty CSV/XLSX oraz PDF „Książka serwisowa pojazdu”
- Kopie zapasowe (Spatie Backup) i strona „Wykonaj backup”
- Strona „Ustawienia” (lead time, globalne interwały, e‑mail nadawcy, powiadomienia)

### Stos technologiczny
- Laravel 11, PHP 8.2+
- Filament 4 (Livewire 3)
- Spatie: Permission, Activitylog, Media Library, Backup
- Maatwebsite Excel, barryvdh DomPDF

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
3. Ustaw DB w `.env`, następnie migracje i seedy (opcjonalnie dane przykładowe)
```bash
php artisan migrate
php artisan db:seed --class=RolesAndPermissionsSeeder
php artisan db:seed --class=DefaultRecurringRulesSeeder # opcjonalnie po dodaniu pojazdów
php artisan db:seed --class=ExampleDataSeeder          # dane demo
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
2. Podniesienie kontenerów i first-run
```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed --class=RolesAndPermissionsSeeder
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

### .env.example (wzorzec)
```env
APP_NAME="Fleet Service Book"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=pl
APP_FALLBACK_LOCALE=pl
APP_TIMEZONE=Europe/Warsaw

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fleet
DB_USERNAME=fleet
DB_PASSWORD=secret

QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="Fleet Service Book"

ADMIN_EMAIL=admin@example.com
ADMIN_PASSWORD=changeme
```

### Konfiguracja i18n
- Domyślnie `app.locale=pl`, `fallback_locale=pl`, `timezone=Europe/Warsaw`, `faker_locale=pl_PL`.
- Middleware `App\Http\Middleware\SetLocale` ustawia język z sesji. Na dashboardzie jest akcja „Język” zapisująca wybór do sesji i robiąca redirect na bieżącą stronę.

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
- Kolejka domyślnie używa `database`.

### Model danych (skrót)
- `vehicles`: parametry pojazdu, przebieg, terminy serwisu (+ indeksy VIN unikalny, rejestracja indeks)
- `odometer_logs`: historia przebiegów
- `vendors`, `parts`, pivot `part_vehicle` (preferowane części dla pojazdu)
- `maintenance_records` + `maintenance_items`: historia serwisu i pozycje kosztowe
- `recurring_maintenance_rules`: reguły cykliczne (interwał km/miesiące, ostatnie wartości, kolejne terminy)
- `media` (Spatie), `activity_log` (Spatie), `jobs` (kolejka), `app_settings`
- Fabryki i seedy: przykładowe pojazdy, części, serwisy (patrz `ExampleDataSeeder`)
- Soft deletes: opcjonalne dla `vehicles` i `parts` (zalety: odzysk; wady: złożoność filtrów i raportów)

### Panel Filament (ścieżka `/admin`)
- Grupy nawigacji: Pojazdy, Serwis, Części, Dostawcy, Reguły, Raporty, Ustawienia
- Zasoby: `Vehicle`, `MaintenanceRecord`, `Part`, `Vendor`, `RecurringMaintenanceRule`
- Formularze i tabele ze zlokalizowanymi etykietami (PL/EN), waluta PLN, km/litry
- Relacje w zasobach pojazdu: serwisy, przebiegi, części
- Akcje szybkie na dashboardzie: „Dodaj serwis”, „Dodaj przebieg”, „Dodaj część”, przełącznik języka

### Reguły serwisowe i powiadomienia
- `RecurringMaintenanceService` liczy `next_due_date`/`next_due_km`, określa status (UPCOMING/DUE/OVERDUE) i aktualizuje po zapisaniu `MaintenanceRecord`
- Ustawienie wyprzedzenia `lead_time_days` znajduje się w `AppSetting` (z fallbackiem do `config/fleet.php`)
- Komenda `maintenance:check-upcoming` (cron, codziennie) wysyła notyfikacje do ról Admin/Manager (mail + baza + powiadomienie Filament)
- Domyślne reguły w `config/fleet.php`; seeder `DefaultRecurringRulesSeeder` może je dodać per pojazd/typ

### Eksporty i PDF
- Eksporty CSV/XLSX dla: Pojazdów, Części, Serwisów
- PDF „Książka serwisowa pojazdu” – kontroler `VehiclePdfController`, widok `resources/views/pdf/vehicle_service_book.blade.php`

### Kopie zapasowe
- Strona Filament „Wykonaj backup” (tylko Admin) uruchamia `backup:run`
- Wymagane narzędzie `mysqldump` dla MySQL. Na macOS (Homebrew): `brew install mysql` lub `brew install mariadb`

### Ustawienia aplikacji
- Strona „Ustawienia” pozwala zarządzać: `lead_time_days`, domyślnymi interwałami, adresem nadawcy e‑mail, przełącznikiem powiadomień

### Scheduler (cron) i Queue
- Cron (produkcyjnie):
```bash
crontab -e
* * * * * cd /var/www/fleet-service-book && php artisan schedule:run >> /dev/null 2>&1
```
- Worker kolejki lokalnie:
```bash
php artisan queue:work
```
- Supervisor (produkcyjnie – przykład):
```
[program:fleet-queue]
command=php /var/www/fleet-service-book/artisan queue:work --sleep=3 --tries=3 --max-time=3600
numprocs=1
autostart=true
autorestart=true
redirect_stderr=true
stdout_logfile=/var/log/supervisor/fleet-queue.log
```

### Deploy (produkcyjny)
1. Skopiuj kod na serwer, ustaw uprawnienia do `storage` i `bootstrap/cache`
2. Zainstaluj zależności bez dev i zbuduj assety
```bash
composer install --no-dev --prefer-dist --optimize-autoloader
php artisan config:cache && php artisan route:cache && php artisan view:cache
npm ci && npm run build
php artisan migrate --force
php artisan storage:link
```
3. Skonfiguruj `.env` (DB, MAIL, APP_URL, APP_LOCALE, QUEUE_CONNECTION=database)
4. Uruchom cron i supervisor dla kolejki (sekcje wyżej)

### Konfiguracja poczty (Mailtrap przykład)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_user
MAIL_PASSWORD=your_pass
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="Fleet Service Book"
```

### Troubleshooting
- „GET /livewire/update Method Not Allowed” – przełącznik języka wykonuje teraz zwykły redirect na Referer, aby nie wywoływać endpointu Livewire update
- „mysqldump: command not found” przy backupie – doinstaluj klienta MySQL/MariaDB, albo w `config/backup.php` wyłącz dump bazy
- Brak tabeli `media` – uruchom migracje dla Media Library
- Cache po aktualizacjach Filament/Laravel: `php artisan optimize:clear`

### Licencja hUps
Projekt edukacyjny – użycie wg potrzeb własnych.
