<?php

namespace Database\Seeders;

use App\Models\MaintenanceItem;
use App\Models\MaintenanceRecord;
use App\Models\Part;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class ExampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $v1 = Vehicle::factory()->create(['type' => 'car','registration_number' => 'WX12345','vin' => 'WAUZZZ8V5EA000001']);
        $v2 = Vehicle::factory()->create(['type' => 'car','registration_number' => 'WX54321','vin' => 'WVWZZZ1JZXW000001']);
        $v3 = Vehicle::factory()->create(['type' => 'motorcycle','registration_number' => 'WXM1234','vin' => 'JYARN231000000001']);

        $oil = Part::firstOrCreate(['sku' => 'OIL-5W30-1L','manufacturer' => 'Castrol'], [
            'name' => 'Edge 5W30','category' => 'oil','unit' => 'l','default_price' => 35.50,
        ]);
        $filter = Part::firstOrCreate(['sku' => 'FIL-OP-123','manufacturer' => 'MANN'], [
            'name' => 'Filter Oleju W712/52','category' => 'filter_oil','unit' => 'szt.','default_price' => 24.99,
        ]);

        $rec = MaintenanceRecord::create([
            'vehicle_id' => $v1->id,
            'date' => now()->subMonths(2)->toDateString(),
            'odometer_km' => $v1->odometer_km + 1000,
            'type' => 'service',
            'total_cost' => 0,
            'currency' => 'PLN',
        ]);
        MaintenanceItem::create(['maintenance_record_id' => $rec->id,'part_id' => $oil->id,'name' => 'Edge 5W30','category' => 'oil','qty' => 4,'unit' => 'l','unit_price' => 35.50,'total_price' => 142.00]);
        MaintenanceItem::create(['maintenance_record_id' => $rec->id,'part_id' => $filter->id,'name' => 'Filter Oleju','category' => 'filter_oil','qty' => 1,'unit' => 'szt.','unit_price' => 24.99,'total_price' => 24.99]);
        $rec->update(['total_cost' => 166.99]);

        MaintenanceRecord::factory()->create(['vehicle_id' => $v2->id,'type' => 'inspection']);
        MaintenanceRecord::factory()->create(['vehicle_id' => $v3->id,'type' => 'repair']);
    }
}


