<?php

namespace App\Exports;

use App\Models\MaintenanceItem;
use App\Models\MaintenanceRecord;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MaintenanceRecordsExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return MaintenanceRecord::query()->with(['vehicle','vendor','items']);
    }

    public function headings(): array
    {
        return ['vehicle','date','odometer_km','type','vendor','invoice_number','total_cost','currency','items'];
    }

    public function map($record): array
    {
        $items = $record->items->map(function (MaintenanceItem $i) {
            return ($i->category ?: 'other') . ':' . $i->name . ' x' . $i->qty . ' @' . $i->unit_price;
        })->implode(' | ');

        return [
            $record->vehicle?->registration_number,
            $record->date,
            $record->odometer_km,
            $record->type,
            $record->vendor?->name,
            $record->invoice_number,
            $record->total_cost,
            $record->currency,
            $items,
        ];
    }
}


