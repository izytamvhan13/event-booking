<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            // 0 = tidak dibatasi jumlah (perilaku lama: sekali dipakai, langsung dianggap penuh)
            // >0 = jumlah stok total yang bisa dibagi ke beberapa booking sekaligus (misal kursi)
            $table->unsignedInteger('quantity')->default(0)->after('photo');
        });
    }

    public function down(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->dropColumn('quantity');
        });
    }
};