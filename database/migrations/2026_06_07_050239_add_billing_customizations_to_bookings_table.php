<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('payment_type', ['sewa', 'cicilan'])->default('sewa');
            $table->integer('duration_months')->default(1);
            $table->decimal('dp_amount', 15, 2)->default(0);
            $table->integer('due_day')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['payment_type', 'duration_months', 'dp_amount', 'due_day']);
        });
    }
};
