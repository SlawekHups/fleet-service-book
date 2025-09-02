<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Carbon\CarbonImmutable;
use Carbon\Carbon;
use App\Models\MaintenanceRecord;
use App\Observers\MaintenanceRecordObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Default string length for older MySQL versions (InnoDB index length)
        Schema::defaultStringLength(191);

        // Set app locale and Carbon locale
        $locale = config('app.locale', 'pl');
        app()->setLocale($locale);
        Carbon::setLocale($locale);
        CarbonImmutable::setLocale($locale);

        // Set default timezone
        date_default_timezone_set(config('app.timezone', 'Europe/Warsaw'));

        // Observe maintenance records to update recurring rules
        MaintenanceRecord::observe(MaintenanceRecordObserver::class);
    }
}
