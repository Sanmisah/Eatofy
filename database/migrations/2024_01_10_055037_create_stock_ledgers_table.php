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
        Schema::create('stock_ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id',11)->nullable();
            $table->foreignId('item_id',11)->nullable();
            $table->decimal('received',10,2)->nullable();
            $table->decimal('issued',10,2)->nullable();
            $table->string('model', 50)->nullable();
            $table->foreignId('foreign_key',11)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_ledgers');
    }
};
