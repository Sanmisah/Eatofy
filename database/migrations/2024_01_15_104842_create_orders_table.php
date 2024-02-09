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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id',11)->nullable();
            $table->date('bill_date')->nullable();
            $table->string('bill_no',50)->nullable();
            $table->string('order_type',20)->nullable();
            $table->string('mobile_no',50)->nullable();
            $table->string('customer_name', 100)->nullable();
            $table->foreignId('table_id',11)->nullable();
            $table->foreignId('server_id',11)->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->string('payment_mode',20)->nullable();
            $table->string('cheque_no',50)->nullable();
            $table->string('bank_name',20)->nullable();
            $table->string('reference_no',50)->nullable();
            $table->string('upi_no',20)->nullable();
            $table->date('payment_date')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
