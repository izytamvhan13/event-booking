<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('pic_name')->nullable()->after('event_name');
            $table->string('ktp_photo')->nullable()->after('description');
            $table->string('permohonan_file')->nullable()->after('ktp_photo');
            $table->string('proposal_file')->nullable()->after('permohonan_file');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['pic_name', 'ktp_photo', 'permohonan_file', 'proposal_file']);
        });
    }
};