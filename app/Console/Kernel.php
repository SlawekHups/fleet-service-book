<?php

namespace App\Console;

use App\Console\Commands\MaintenanceCheckUpcoming;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('maintenance:check-upcoming')->dailyAt('07:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}


