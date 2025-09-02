<?php

namespace App\Console\Commands;

use App\Models\RecurringMaintenanceRule;
use App\Models\User;
use App\Notifications\MaintenanceDueNotification;
use App\Services\RecurringMaintenanceService;
use Illuminate\Console\Command;

class MaintenanceCheckUpcoming extends Command
{
    protected $signature = 'maintenance:check-upcoming';

    protected $description = 'Check recurring maintenance rules and notify for upcoming/due/overdue';

    public function handle(RecurringMaintenanceService $service): int
    {
        $this->info('Checking recurring maintenance rules...');

        RecurringMaintenanceRule::query()->with('vehicle')->chunk(200, function ($rules) use ($service) {
            foreach ($rules as $rule) {
                $service->recomputeNextDue($rule);

                $status = null;
                if ($rule->next_due_date && now()->isAfter($rule->next_due_date)) {
                    $status = RecurringMaintenanceService::STATUS_OVERDUE;
                } elseif ($rule->next_due_date && now()->diffInDays($rule->next_due_date, false) <= config('fleet.lead_time_days', 14)) {
                    $status = RecurringMaintenanceService::STATUS_UPCOMING;
                }
                if ($rule->next_due_km !== null && $rule->vehicle && $rule->vehicle->odometer_km >= $rule->next_due_km) {
                    $status = RecurringMaintenanceService::STATUS_DUE;
                }

                if ($status) {
                    $this->notifyRoles($rule, $status);
                }
            }
        });

        $this->info('Done.');
        return self::SUCCESS;
    }

    protected function notifyRoles(RecurringMaintenanceRule $rule, string $status): void
    {
        $users = User::query()->get(); // TODO: filter by roles Admin/Manager once permissions installed
        foreach ($users as $user) {
            $user->notify(new MaintenanceDueNotification($rule, $status));
        }
    }
}


