<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('designs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('template_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->decimal('width', 6, 1);
            $table->decimal('height', 6, 1);
            $table->decimal('depth', 6, 1);
            $table->string('color', 9)->default('#c4b5fd');
            $table->string('text')->nullable();
            $table->string('text_color', 9)->default('#ffffff');
            $table->unsignedSmallInteger('font_size')->default(48);
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('designs');
    }
};
