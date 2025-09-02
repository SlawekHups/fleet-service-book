<?php

namespace App\Providers;

use App\Models\MaintenanceRecord;
use App\Models\Part;
use App\Models\RecurringMaintenanceRule;
use App\Models\Vehicle;
use App\Models\Vendor;
use App\Policies\MaintenanceRecordPolicy;
use App\Policies\PartPolicy;
use App\Policies\RecurringMaintenanceRulePolicy;
use App\Policies\VehiclePolicy;
use App\Policies\VendorPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Vehicle::class => VehiclePolicy::class,
        MaintenanceRecord::class => MaintenanceRecordPolicy::class,
        Part::class => PartPolicy::class,
        Vendor::class => VendorPolicy::class,
        RecurringMaintenanceRule::class => RecurringMaintenanceRulePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}


