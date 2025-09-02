<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Resolve Spatie models dynamically to avoid hard dependency during scaffolding
        $roleModel = 'Spatie\\Permission\\Models\\Role';
        $permissionModel = 'Spatie\\Permission\\Models\\Permission';

        if (!class_exists($roleModel) || !class_exists($permissionModel)) {
            // Package not installed yet; skip quietly
            return;
        }

        // Define roles
        $roles = [
            'Admin', 'Manager', 'Mechanic', 'Viewer',
        ];

        foreach ($roles as $roleName) {
            $roleModel::findOrCreate($roleName);
        }

        // Define permissions
        $permissions = [
            'vehicles.view', 'vehicles.create', 'vehicles.update', 'vehicles.delete',
            'maintenance.view', 'maintenance.create', 'maintenance.update', 'maintenance.delete',
            'parts.view', 'parts.create', 'parts.update', 'parts.delete',
            'vendors.view', 'vendors.create', 'vendors.update', 'vendors.delete',
            'rules.view', 'rules.create', 'rules.update', 'rules.delete',
            'reports.view',
            'settings.manage',
            'backups.run',
        ];

        foreach ($permissions as $perm) {
            $permissionModel::findOrCreate($perm);
        }

        // Assign permissions to roles
        $viewerPerms = [
            'vehicles.view', 'maintenance.view', 'parts.view', 'vendors.view', 'rules.view', 'reports.view',
        ];

        $mechanicPerms = array_merge($viewerPerms, [
            'maintenance.create', 'maintenance.update',
            'parts.create', 'parts.update',
        ]);

        $managerPerms = array_merge($mechanicPerms, [
            'vehicles.create', 'vehicles.update', 'vehicles.delete',
            'maintenance.delete',
            'parts.delete',
            'vendors.create', 'vendors.update', 'vendors.delete',
            'rules.create', 'rules.update', 'rules.delete',
        ]);

        $adminPerms = array_merge($permissions, [
            'settings.manage', 'backups.run',
        ]);

        $roleModel::findByName('Viewer')->syncPermissions($viewerPerms);
        $roleModel::findByName('Mechanic')->syncPermissions($mechanicPerms);
        $roleModel::findByName('Manager')->syncPermissions($managerPerms);
        $roleModel::findByName('Admin')->syncPermissions($adminPerms);

        // Create Admin user
        $adminEmail = env('ADMIN_EMAIL', 'admin@example.com');
        $adminPassword = env('ADMIN_PASSWORD', 'changeme');

        $admin = User::firstOrCreate([
            'email' => $adminEmail,
        ], [
            'name' => 'Administrator',
            'password' => $adminPassword,
        ]);

        if (method_exists($admin, 'assignRole') && !$admin->hasRole('Admin')) {
            $admin->assignRole('Admin');
        }
    }
}


