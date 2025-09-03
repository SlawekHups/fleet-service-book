<?php

namespace App\Services;

use App\Models\MaintenanceRecord;
use App\Models\RecurringMaintenanceRule;
use App\Models\Vehicle;
use Carbon\CarbonImmutable;
use App\Models\AppSetting;

class RecurringMaintenanceService
{
    public const STATUS_UPCOMING = 'UPCOMING';
    public const STATUS_DUE = 'DUE';
    public const STATUS_OVERDUE = 'OVERDUE';

    public function recomputeNextDue(RecurringMaintenanceRule $rule, ?Vehicle $vehicle = null): RecurringMaintenanceRule
    {
        $vehicle = $vehicle ?: $rule->vehicle;
        $leadDays = (int) (AppSetting::query()->value('lead_time_days') ?? config('fleet.lead_time_days', 14));

        $lastDate = $rule->last_date ? CarbonImmutable::parse($rule->last_date) : null;
        $lastKm = $rule->last_odometer_km;

        $nextDate = null;
        $nextKm = null;

        if ($rule->interval_months) {
            $baseDate = $lastDate ?: CarbonImmutable::now();
            $nextDate = $baseDate->addMonthsNoOverflow((int) $rule->interval_months);
        }

        if ($rule->interval_km && $vehicle) {
            $baseKm = $lastKm ?? $vehicle->odometer_km;
            $nextKm = (int) $baseKm + (int) $rule->interval_km;
        }

        $rule->next_due_date = $nextDate?->toDateString();
        $rule->next_due_km = $nextKm;

        // Determine status
        $status = null;
        $now = CarbonImmutable::now();

        $isOverdueDate = $nextDate && $nextDate->isPast();
        $isOverdueKm = $nextKm !== null && $vehicle && $vehicle->odometer_km > $nextKm;

        if ($isOverdueDate || $isOverdueKm) {
            $status = self::STATUS_OVERDUE;
        } elseif ($nextDate && $nextDate->diffInDays($now, false) >= -$leadDays) {
            $status = self::STATUS_UPCOMING; // within lead window
        } elseif ($nextKm !== null && $vehicle) {
            $kmRemaining = $nextKm - $vehicle->odometer_km;
            if ($kmRemaining <= 0) {
                $status = self::STATUS_DUE;
            } elseif ($kmRemaining <= ($rule->interval_km ?? 0) * 0.1) {
                $status = self::STATUS_UPCOMING;
            }
        }

        $rule->save();

        return $rule;
    }

    public function onRecordSaved(MaintenanceRecord $record): void
    {
        // Find rules for this vehicle and component type, update last_* and recompute
        $rules = RecurringMaintenanceRule::query()
            ->where(function ($q) use ($record) {
                $q->whereNull('vehicle_id')->orWhere('vehicle_id', $record->vehicle_id);
            })
            ->get();

        foreach ($rules as $rule) {
            // If component matches record.type or items category, update last values
            if ($rule->component === $record->type) {
                $rule->last_record_id = $record->id;
                $rule->last_date = $record->date;
                $rule->last_odometer_km = $record->odometer_km;
                $rule->save();
                $this->recomputeNextDue($rule, $record->vehicle);
            }
        }
    }
}


