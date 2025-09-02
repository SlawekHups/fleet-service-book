<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->string('manufacturer');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category');
            $table->string('unit')->default('szt.');
            $table->decimal('default_price', 10, 2)->nullable();
            $table->string('external_url')->nullable();
            $table->timestamps();

            $table->index(['sku', 'manufacturer']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parts');
    }
};


