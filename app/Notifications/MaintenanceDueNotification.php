<?php

namespace App\Notifications;

use App\Models\RecurringMaintenanceRule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MaintenanceDueNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly RecurringMaintenanceRule $rule, private readonly string $status)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $vehicle = $this->rule->vehicle;
        $lineStatus = match ($this->status) {
            'OVERDUE' => 'ZADŁOŻONE',
            'DUE' => 'DO WYKONANIA',
            default => 'NADCHODZĄCE',
        };

        $mail = (new MailMessage)
            ->subject('Przypomnienie serwisowe: ' . $this->rule->component)
            ->greeting('Cześć!')
            ->line("Pojazd: {$vehicle?->registration_number} ({$vehicle?->vin})")
            ->line("Element: {$this->rule->component}")
            ->line("Status: {$lineStatus}")
            ->line('Termin: ' . ($this->rule->next_due_date ?: '—'))
            ->line('Przebieg docelowy [km]: ' . ($this->rule->next_due_km !== null ? (string) $this->rule->next_due_km : '—'))
            ->line('Pozdrawiamy, Fleet Service Book');

        return $mail;
    }

    public function toDatabase(object $notifiable): array
    {
        $vehicle = $this->rule->vehicle;
        return [
            'rule_id' => $this->rule->id,
            'vehicle_id' => $vehicle?->id,
            'component' => $this->rule->component,
            'status' => $this->status,
            'next_due_date' => $this->rule->next_due_date,
            'next_due_km' => $this->rule->next_due_km,
            'registration_number' => $vehicle?->registration_number,
            'vin' => $vehicle?->vin,
        ];
    }
}


