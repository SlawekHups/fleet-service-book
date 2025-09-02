<?php

namespace Database\Factories;

use App\Models\MaintenanceRecord;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MaintenanceRecord>
 */
class MaintenanceRecordFactory extends Factory
{
    protected $model = MaintenanceRecord::class;

    public function definition(): array
    {
        return [
            'vehicle_id' => Vehicle::factory(),
            'date' => $this->faker->date(),
            'odometer_km' => $this->faker->numberBetween(0, 300000),
            'type' => $this->faker->randomElement(['service','repair','inspection','tire_change','accident','other']),
            'vendor_id' => null,
            'invoice_number' => $this->faker->optional()->bothify('FV######'),
            'total_cost' => $this->faker->randomFloat(2, 0, 10000),
            'currency' => 'PLN',
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}


