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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id',11)->nullable();
            $table->date('purchase_date')->nullable();
            $table->foreignId('supplier_id',11)->nullable();
            $table->string('invoice_no',50)->nullable();
            $table->date('invoice_date')->nullable();
            $table->decimal('total_amount',10,2)->nullable();
            $table->decimal('balace_amount',10,2)->default(0)->nullable();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
