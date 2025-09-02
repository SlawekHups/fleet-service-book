<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['car', 'motorcycle']);
            $table->string('vin')->unique();
            $table->string('make');
            $table->string('model');
            $table->integer('year');
            $table->string('registration_number')->index();
            $table->string('engine_code')->nullable();
            $table->integer('engine_displacement_cc')->nullable();
            $table->enum('fuel_type', ['petrol','diesel','hybrid','ev','lpg']);
            $table->string('oil_spec');
            $table->string('color')->nullable();
            $table->date('purchase_date')->nullable();
            $table->integer('odometer_km')->default(0);
            $table->dateTime('odometer_updated_at')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('active')->default(true);
            $table->date('next_service_due_date')->nullable();
            $table->integer('next_service_due_km')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};


