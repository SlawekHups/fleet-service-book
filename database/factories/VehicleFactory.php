<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition(): array
    {
        $type = $this->faker->randomElement(['car','motorcycle']);
        $fuel = $this->faker->randomElement(['petrol','diesel','hybrid','ev','lpg']);

        return [
            'type' => $type,
            'vin' => strtoupper($this->faker->bothify('?????????????????')),
            'make' => $this->faker->randomElement(['Toyota','VW','BMW','Kia','Hyundai','Honda','Yamaha','Kawasaki']),
            'model' => $this->faker->word(),
            'year' => (int) $this->faker->numberBetween(1995, (int)date('Y')),
            'registration_number' => strtoupper($this->faker->bothify('?? ####')),
            'engine_code' => strtoupper($this->faker->bothify('??##')),
            'engine_displacement_cc' => $type === 'motorcycle' ? $this->faker->numberBetween(50, 1300) : $this->faker->numberBetween(900, 3000),
            'fuel_type' => $fuel,
            'oil_spec' => $this->faker->randomElement(['5W30','5W40','0W20','10W40']),
            'color' => $this->faker->safeColorName(),
            'purchase_date' => $this->faker->optional()->date(),
            'odometer_km' => $this->faker->numberBetween(0, 300000),
            'odometer_updated_at' => now(),
            'notes' => $this->faker->optional()->sentence(),
            'active' => true,
            'next_service_due_date' => $this->faker->optional()->dateTimeBetween('now', '+1 year'),
            'next_service_due_km' => $this->faker->optional()->numberBetween(1000, 30000),
        ];
    }
}


