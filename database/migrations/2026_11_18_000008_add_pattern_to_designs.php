<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('designs', function (Blueprint $table) {
            $table->string('pattern')->nullable()->after('image_path');
        });
    }

    public function down(): void
    {
        Schema::table('designs', fn (Blueprint $t) => $t->dropColumn('pattern'));
    }
};
