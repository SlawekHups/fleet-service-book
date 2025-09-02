<?php

namespace App\Services\Imports;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;

class VehiclesCsvImporter
{
    public function import(string $path): array
    {
        $csv = Reader::createFromPath($path);
        $csv->setHeaderOffset(0);
        $records = iterator_to_array($csv->getRecords());

        $created = 0; $updated = 0; $errors = [];

        foreach ($records as $i => $row) {
            $row = array_map('trim', $row);
            $validator = Validator::make($row, [
                'type' => 'required|in:car,motorcycle',
                'vin' => 'required|string|min:11',
                'make' => 'required|string',
                'model' => 'required|string',
                'year' => 'required|integer',
                'registration_number' => 'required|string',
                'fuel_type' => 'required|in:petrol,diesel,hybrid,ev,lpg',
            ]);
            if ($validator->fails()) {
                $errors[] = ['row' => $i + 2, 'errors' => $validator->errors()->all()];
                continue;
            }

            $vehicle = Vehicle::updateOrCreate(
                ['vin' => $row['vin']],
                [
                    'type' => $row['type'],
                    'make' => $row['make'],
                    'model' => $row['model'],
                    'year' => (int) $row['year'],
                    'registration_number' => $row['registration_number'],
                    'engine_code' => $row['engine_code'] ?? null,
                    'engine_displacement_cc' => $row['engine_displacement_cc'] ?? null,
                    'fuel_type' => $row['fuel_type'],
                    'oil_spec' => $row['oil_spec'] ?? '5W30',
                    'color' => $row['color'] ?? null,
                    'purchase_date' => $row['purchase_date'] ?? null,
                    'odometer_km' => $row['odometer_km'] ?? 0,
                ]
            );
            $vehicle->wasRecentlyCreated ? $created++ : $updated++;
        }

        return compact('created','updated','errors');
    }
}


