<?php

namespace Database\Seeders;

use App\Models\RecurringMaintenanceRule;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class DefaultRecurringRulesSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = config('fleet.defaults');

        Vehicle::query()->chunk(200, function ($vehicles) use ($defaults) {
            foreach ($vehicles as $vehicle) {
                $rules = $defaults[$vehicle->type] ?? [];
                foreach ($rules as $component => $cfg) {
                    RecurringMaintenanceRule::firstOrCreate([
                        'vehicle_id' => $vehicle->id,
                        'component' => $component,
                    ], [
                        'interval_months' => $cfg['interval_months'] ?? null,
                        'interval_km' => $cfg['interval_km'] ?? null,
                        'lead_time_days' => config('fleet.lead_time_days', 14),
                        'notify' => true,
                        'active' => true,
                    ]);
                }
            }
        });
    }
}


