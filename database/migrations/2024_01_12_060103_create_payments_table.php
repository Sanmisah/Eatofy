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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id',11)->nullable();
            $table->foreignId('supplier_id',11)->nullable();
            $table->string('voucher_no',50)->nullable();
            $table->date('voucher_date')->nullable();
            $table->decimal('amount',10,2)->nullable();
            $table->string('payment_mode',20)->nullable();
            $table->string('cheque_no',50)->nullable();
            $table->string('bank_name',50)->nullable();
            $table->string('reference_no',50)->nullable();
            $table->string('upi_no',20)->nullable();
            $table->date('payment_date')->nullable();
            $table->decimal('total',10,2)->nullable();
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
        Schema::dropIfExists('payments');
    }
};
