<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('billings', function (Blueprint $table) {
            $table->dropColumn(['snap_token', 'midtrans_order_id', 'payment_type']);
        });
    }

    public function down(): void
    {
        Schema::table('billings', function (Blueprint $table) {
            $table->string('snap_token')->nullable();
            $table->string('midtrans_order_id')->nullable()->unique();
            $table->string('payment_type')->nullable();
        });
    }
};
