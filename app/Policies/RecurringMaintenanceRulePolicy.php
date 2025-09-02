<?php

namespace App\Policies;

use App\Models\RecurringMaintenanceRule;
use App\Models\User;

class RecurringMaintenanceRulePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('rules.view');
    }

    public function view(User $user, RecurringMaintenanceRule $rule): bool
    {
        return $user->can('rules.view');
    }

    public function create(User $user): bool
    {
        return $user->can('rules.create');
    }

    public function update(User $user, RecurringMaintenanceRule $rule): bool
    {
        return $user->can('rules.update');
    }

    public function delete(User $user, RecurringMaintenanceRule $rule): bool
    {
        return $user->can('rules.delete');
    }
}


