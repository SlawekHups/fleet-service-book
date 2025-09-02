<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_record_id')->constrained('maintenance_records')->cascadeOnDelete();
            $table->foreignId('part_id')->nullable()->constrained('parts')->nullOnDelete();
            $table->string('name');
            $table->string('part_number')->nullable();
            $table->string('manufacturer')->nullable();
            $table->enum('category', [
                'oil','filter_oil','filter_air','filter_cabin','filter_fuel','brake_pads','brake_discs','coolant','spark_plug','chain','sprocket','tire','belt','wiper','labor','other'
            ]);
            $table->decimal('qty', 10, 2)->default(1);
            $table->string('unit')->default('szt.');
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('total_price', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_items');
    }
};


