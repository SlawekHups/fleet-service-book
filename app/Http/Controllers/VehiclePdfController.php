<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Barryvdh\DomPDF\Facade\Pdf;

class VehiclePdfController extends Controller
{
    public function __invoke(Vehicle $vehicle)
    {
        $vehicle->load(['maintenanceRecords.vendor', 'maintenanceRecords.items', 'odometerLogs']);

        $pdf = Pdf::loadView('pdf.vehicle_service_book', [
            'vehicle' => $vehicle,
        ])->setPaper('a4');

        return $pdf->download('ksiazka-serwisowa-' . $vehicle->registration_number . '.pdf');
    }
}


