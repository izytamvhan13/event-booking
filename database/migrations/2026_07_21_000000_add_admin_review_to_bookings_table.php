<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // null   = belum ditinjau admin
            // forwarded = admin loloskan & teruskan ke pimpinan
            // rejected  = ditolak admin di tahap penyaringan awal (tidak sampai ke pimpinan)
            $table->string('admin_status')->nullable()->after('status');
            $table->text('admin_note')->nullable()->after('admin_status');
            $table->foreignId('reviewed_by')->nullable()->after('admin_note')->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reviewed_by');
            $table->dropColumn(['admin_status', 'admin_note', 'reviewed_at']);
        });
    }
};