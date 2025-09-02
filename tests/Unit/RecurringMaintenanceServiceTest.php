<?php

namespace Tests\Unit;

use App\Models\RecurringMaintenanceRule;
use App\Models\Vehicle;
use App\Services\RecurringMaintenanceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecurringMaintenanceServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_compute_next_due_km_only(): void
    {
        $vehicle = Vehicle::factory()->create(['odometer_km' => 10000]);
        $rule = RecurringMaintenanceRule::create([
            'vehicle_id' => $vehicle->id,
            'component' => 'oil',
            'interval_km' => 15000,
        ]);
        app(RecurringMaintenanceService::class)->recomputeNextDue($rule, $vehicle);
        $this->assertEquals(25000, $rule->next_due_km);
        $this->assertNull($rule->next_due_date);
    }

    public function test_compute_next_due_months_only(): void
    {
        $vehicle = Vehicle::factory()->create();
        $rule = RecurringMaintenanceRule::create([
            'vehicle_id' => $vehicle->id,
            'component' => 'oil',
            'interval_months' => 12,
            'last_date' => now()->toDateString(),
        ]);
        app(RecurringMaintenanceService::class)->recomputeNextDue($rule, $vehicle);
        $this->assertNotNull($rule->next_due_date);
    }

    public function test_compute_next_due_both(): void
    {
        $vehicle = Vehicle::factory()->create(['odometer_km' => 20000]);
        $rule = RecurringMaintenanceRule::create([
            'vehicle_id' => $vehicle->id,
            'component' => 'oil',
            'interval_months' => 12,
            'interval_km' => 15000,
            'last_odometer_km' => 20000,
            'last_date' => now()->toDateString(),
        ]);
        app(RecurringMaintenanceService::class)->recomputeNextDue($rule, $vehicle);
        $this->assertEquals(35000, $rule->next_due_km);
        $this->assertNotNull($rule->next_due_date);
    }
}


