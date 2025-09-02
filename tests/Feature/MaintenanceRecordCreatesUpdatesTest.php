<?php

namespace Tests\Feature;

use App\Models\MaintenanceItem;
use App\Models\MaintenanceRecord;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class MaintenanceRecordCreatesUpdatesTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_record_updates_odometer_and_total(): void
    {
        $vehicle = Vehicle::factory()->create(['odometer_km' => 1000]);

        $record = MaintenanceRecord::factory()->create([
            'vehicle_id' => $vehicle->id,
            'odometer_km' => 1200,
            'total_cost' => 0,
        ]);

        MaintenanceItem::factory()->create([ 'maintenance_record_id' => $record->id, 'qty' => 2, 'unit_price' => 50 ]);
        MaintenanceItem::factory()->create([ 'maintenance_record_id' => $record->id, 'qty' => 1, 'unit_price' => 30 ]);

        $sum = $record->items()->sum(DB::raw('qty * unit_price'));
        $record->update(['total_cost' => $sum]);

        $vehicle->refresh();
        $this->assertEquals(1200, $vehicle->odometer_km);
        $this->assertEquals(130, (float) $record->total_cost);
    }
}


