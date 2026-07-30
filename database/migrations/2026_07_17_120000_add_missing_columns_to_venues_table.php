<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('venues', function (Blueprint $table) {
            if (!Schema::hasColumn('venues', 'capacity')) {
                $table->integer('capacity')->nullable();
            }
            if (!Schema::hasColumn('venues', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('venues', 'gmaps_url')) {
                $table->text('gmaps_url')->nullable();
            }
            if (!Schema::hasColumn('venues', 'indoor_photo')) {
                $table->string('indoor_photo')->nullable();
            }
            if (!Schema::hasColumn('venues', 'outdoor_photo')) {
                $table->string('outdoor_photo')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('venues', function (Blueprint $table) {
            $table->dropColumn(['capacity', 'description', 'gmaps_url', 'indoor_photo', 'outdoor_photo']);
        });
    }
};