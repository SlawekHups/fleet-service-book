<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { font-size: 20px; margin-bottom: 10px; }
        h2 { font-size: 16px; margin-top: 18px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #ccc; padding: 6px; }
        th { background: #f5f5f5; }
    </style>
    <title>Książka serwisowa</title>
  </head>
  <body>
    <h1>Książka serwisowa — {{ $vehicle->registration_number }} (VIN {{ $vehicle->vin }})</h1>
    <p>Marka/Model: {{ $vehicle->make }} {{ $vehicle->model }} • Rok: {{ $vehicle->year }} • Paliwo: {{ $vehicle->fuel_type }}</p>

    <h2>Przebiegi</h2>
    <table>
      <thead><tr><th>Data</th><th>Przebieg [km]</th><th>Źródło</th></tr></thead>
      <tbody>
      @foreach($vehicle->odometerLogs as $log)
        <tr><td>{{ $log->date }}</td><td>{{ number_format($log->value_km, 0, ',', ' ') }}</td><td>{{ $log->source }}</td></tr>
      @endforeach
      </tbody>
    </table>

    <h2>Historia serwisowa</h2>
    <table>
      <thead><tr>
        <th>Data</th><th>Typ</th><th>Przebieg [km]</th><th>Dostawca</th><th>Faktura</th><th>Kwota</th>
      </tr></thead>
      <tbody>
      @foreach($vehicle->maintenanceRecords as $rec)
        <tr>
          <td>{{ $rec->date }}</td>
          <td>{{ $rec->type }}</td>
          <td>{{ number_format($rec->odometer_km, 0, ',', ' ') }}</td>
          <td>{{ $rec->vendor->name ?? '—' }}</td>
          <td>{{ $rec->invoice_number ?? '—' }}</td>
          <td>{{ number_format($rec->total_cost, 2, ',', ' ') }} {{ $rec->currency }}</td>
        </tr>
        @if($rec->items->count())
          <tr>
            <td colspan="6">
              <strong>Pozycje:</strong>
              <ul>
                @foreach($rec->items as $i)
                  <li>{{ $i->category }} — {{ $i->name }} ({{ $i->qty }} {{ $i->unit }}, {{ number_format($i->unit_price, 2, ',', ' ') }} {{ $rec->currency }})</li>
                @endforeach
              </ul>
            </td>
          </tr>
        @endif
      @endforeach
      </tbody>
    </table>

    <p style="margin-top: 16px;">Wygenerowano przez Fleet Service Book, {{ now()->format('Y-m-d H:i') }}.</p>
  </body>
 </html>


