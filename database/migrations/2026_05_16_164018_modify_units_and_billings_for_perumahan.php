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
        Schema::table('units', function (Blueprint $table) {
            $table->foreignId('estate_id')->nullable()->constrained()->nullOnDelete();
            // In SQLite changing enum is not supported directly without workarounds, 
            // but we can just use string since Laravel handles enum as string in DB
            $table->string('property_type')->default('rumah')->after('type'); // type was used for room type, let's add property_type
        });

        Schema::table('billings', function (Blueprint $table) {
            $table->string('snap_token')->nullable();
            $table->string('midtrans_order_id')->nullable()->unique();
            $table->string('payment_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropForeign(['estate_id']);
            $table->dropColumn(['estate_id', 'property_type']);
        });

        Schema::table('billings', function (Blueprint $table) {
            $table->dropColumn(['snap_token', 'midtrans_order_id', 'payment_type']);
        });
    }
};
