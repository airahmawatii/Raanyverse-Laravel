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
        Schema::create('parcels', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_name');
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
            $table->string('courier_name'); // Cth: JNE, Grab, dll
            $table->string('tracking_number')->nullable();
            $table->string('status')->default('received'); // received, taken
            $table->timestamp('received_at')->useCurrent();
            $table->timestamp('taken_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcels');
    }
};
