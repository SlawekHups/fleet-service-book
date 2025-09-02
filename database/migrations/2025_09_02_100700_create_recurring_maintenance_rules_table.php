<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recurring_maintenance_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->nullOnDelete();
            $table->enum('component', [
                'oil','filter_oil','filter_air','filter_cabin','filter_fuel','brake_pads','brake_discs','coolant','spark_plug','chain','sprocket','tire','belt','wiper','labor','other','inspection_general'
            ]);
            $table->integer('interval_km')->nullable();
            $table->integer('interval_months')->nullable();
            $table->foreignId('last_record_id')->nullable()->constrained('maintenance_records')->nullOnDelete();
            $table->date('last_date')->nullable();
            $table->integer('last_odometer_km')->nullable();
            $table->date('next_due_date')->nullable();
            $table->integer('next_due_km')->nullable();
            $table->integer('lead_time_days')->default(14);
            $table->boolean('notify')->default(true);
            $table->boolean('active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recurring_maintenance_rules');
    }
};


