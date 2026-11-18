<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('printers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('city');
            $table->string('country');
            $table->text('description')->nullable();
            $table->decimal('price_per_unit', 8, 2);
            $table->unsignedInteger('min_qty')->default(50);
            $table->unsignedSmallInteger('lead_days')->default(7);
            $table->decimal('rating', 2, 1)->default(4.5);
            $table->string('color', 9)->default('#a5f3fc');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('printers');
    }
};
