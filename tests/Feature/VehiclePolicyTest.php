<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehiclePolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_viewer_can_only_view(): void
    {
        if (!class_exists('Spatie\\Permission\\Models\\Permission')) {
            $this->markTestSkipped('spatie/laravel-permission not installed');
        }

        $user = User::factory()->create();
        // Grant only view permission
        app('Spatie\\Permission\\Models\\Permission')::findOrCreate('vehicles.view');
        $user->givePermissionTo('vehicles.view');

        $vehicle = Vehicle::factory()->create();

        $this->assertTrue($user->can('view', $vehicle));
        $this->assertTrue($user->can('viewAny', Vehicle::class));
        $this->assertFalse($user->can('create', Vehicle::class));
        $this->assertFalse($user->can('update', $vehicle));
        $this->assertFalse($user->can('delete', $vehicle));
    }
}


