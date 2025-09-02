<?php

namespace Database\Factories;

use App\Models\Part;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Part>
 */
class PartFactory extends Factory
{
    protected $model = Part::class;

    public function definition(): array
    {
        return [
            'sku' => strtoupper($this->faker->bothify('PN####')),
            'manufacturer' => $this->faker->randomElement(['Bosch','Mann','NGK','Denso','ATE','Textar']),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->optional()->sentence(),
            'category' => $this->faker->randomElement(['oil','filter_oil','filter_air','filter_cabin','filter_fuel','brake_pads','brake_discs','coolant','spark_plug','chain','sprocket','tire','belt','wiper','labor','other']),
            'unit' => 'szt.',
            'default_price' => $this->faker->optional()->randomFloat(2, 10, 1000),
            'external_url' => $this->faker->optional()->url(),
        ];
    }
}


