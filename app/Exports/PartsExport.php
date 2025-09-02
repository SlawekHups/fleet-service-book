<?php

namespace App\Exports;

use App\Models\Part;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PartsExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return Part::query();
    }

    public function headings(): array
    {
        return ['sku','manufacturer','name','category','unit','default_price'];
    }

    public function map($part): array
    {
        return [
            $part->sku,
            $part->manufacturer,
            $part->name,
            $part->category,
            $part->unit,
            $part->default_price,
        ];
    }
}


