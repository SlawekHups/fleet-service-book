<?php

namespace Database\Factories;

use App\Models\MaintenanceItem;
use App\Models\MaintenanceRecord;
use App\Models\Part;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MaintenanceItem>
 */
class MaintenanceItemFactory extends Factory
{
    protected $model = MaintenanceItem::class;

    public function definition(): array
    {
        $category = $this->faker->randomElement([
            'oil','filter_oil','filter_air','filter_cabin','filter_fuel','brake_pads','brake_discs','coolant','spark_plug','chain','sprocket','tire','belt','wiper','labor','other'
        ]);

        return [
            'maintenance_record_id' => MaintenanceRecord::factory(),
            'part_id' => $this->faker->boolean(70) ? Part::factory() : null,
            'name' => $this->faker->words(3, true),
            'part_number' => $this->faker->optional()->bothify('PN-####'),
            'manufacturer' => $this->faker->optional()->company(),
            'category' => $category,
            'qty' => $category === 'labor' ? 1 : $this->faker->randomFloat(2, 1, 8),
            'unit' => $category === 'labor' ? 'h' : 'szt.',
            'unit_price' => $this->faker->randomFloat(2, 0, 1000),
            'total_price' => 0, // can be calculated in model/observer later
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}


