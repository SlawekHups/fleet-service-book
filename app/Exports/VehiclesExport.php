<?php

namespace App\Exports;

use App\Models\Vehicle;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VehiclesExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return Vehicle::query();
    }

    public function headings(): array
    {
        return ['type','vin','make','model','year','registration_number','fuel_type','odometer_km'];
    }

    public function map($vehicle): array
    {
        return [
            $vehicle->type,
            $vehicle->vin,
            $vehicle->make,
            $vehicle->model,
            $vehicle->year,
            $vehicle->registration_number,
            $vehicle->fuel_type,
            $vehicle->odometer_km,
        ];
    }
}


