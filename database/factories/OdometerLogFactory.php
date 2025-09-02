<?php

namespace Database\Factories;

use App\Models\OdometerLog;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OdometerLog>
 */
class OdometerLogFactory extends Factory
{
    protected $model = OdometerLog::class;

    public function definition(): array
    {
        return [
            'vehicle_id' => Vehicle::factory(),
            'date' => $this->faker->date(),
            'value_km' => $this->faker->numberBetween(0, 300000),
            'source' => $this->faker->randomElement(['manual','service','import']),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}


