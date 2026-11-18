<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->string('shape')->default('box')->after('slug');
        });
        Schema::table('designs', function (Blueprint $table) {
            $table->string('shape')->default('box')->after('template_id');
        });
    }

    public function down(): void
    {
        Schema::table('templates', fn (Blueprint $t) => $t->dropColumn('shape'));
        Schema::table('designs', fn (Blueprint $t) => $t->dropColumn('shape'));
    }
};
