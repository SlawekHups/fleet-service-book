<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('part_vehicle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('part_id')->constrained('parts')->cascadeOnDelete();
            $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
            $table->boolean('preferred')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['part_id', 'vehicle_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('part_vehicle');
    }
};


