<?php

return [
    'lead_time_days' => 14,

    'defaults' => [
        'car' => [
            'oil' => ['interval_months' => 12, 'interval_km' => 15000],
            'filter_oil' => ['interval_months' => 12, 'interval_km' => 15000],
            'filter_air' => ['interval_months' => 24, 'interval_km' => 30000],
            'filter_cabin' => ['interval_months' => 12, 'interval_km' => 15000],
            'inspection_general' => ['interval_months' => 12, 'interval_km' => null],
            'brake_inspection' => ['interval_months' => 12, 'interval_km' => null],
        ],
        'motorcycle' => [
            'oil' => ['interval_months' => 12, 'interval_km' => 6000],
            'filter_oil' => ['interval_months' => 12, 'interval_km' => 6000],
            'filter_air' => ['interval_months' => 24, 'interval_km' => 12000],
            'chain' => ['interval_months' => 6, 'interval_km' => 6000],
            'inspection_general' => ['interval_months' => 12, 'interval_km' => null],
        ],
    ],
];


