<?php

namespace App\Services\Imports;

use App\Models\Part;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;

class PartsCsvImporter
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
                'sku' => 'required|string',
                'manufacturer' => 'required|string',
                'name' => 'required|string',
                'category' => 'required|string',
                'unit' => 'nullable|string',
                'default_price' => 'nullable|numeric',
            ]);
            if ($validator->fails()) {
                $errors[] = ['row' => $i + 2, 'errors' => $validator->errors()->all()];
                continue;
            }

            $part = Part::updateOrCreate(
                ['sku' => $row['sku'], 'manufacturer' => $row['manufacturer']],
                [
                    'name' => $row['name'],
                    'category' => $row['category'],
                    'unit' => $row['unit'] ?: 'szt.',
                    'default_price' => $row['default_price'] ?: null,
                    'description' => $row['description'] ?? null,
                    'external_url' => $row['external_url'] ?? null,
                ]
            );
            $part->wasRecentlyCreated ? $created++ : $updated++;
        }

        return compact('created','updated','errors');
    }
}


