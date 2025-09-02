<?php

namespace App\Policies;

use App\Models\MaintenanceRecord;
use App\Models\User;

class MaintenanceRecordPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('maintenance.view');
    }

    public function view(User $user, MaintenanceRecord $record): bool
    {
        return $user->can('maintenance.view');
    }

    public function create(User $user): bool
    {
        return $user->can('maintenance.create');
    }

    public function update(User $user, MaintenanceRecord $record): bool
    {
        return $user->can('maintenance.update');
    }

    public function delete(User $user, MaintenanceRecord $record): bool
    {
        return $user->can('maintenance.delete');
    }
}


