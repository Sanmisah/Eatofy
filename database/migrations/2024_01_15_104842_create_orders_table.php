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
            $table->foreignId('bill_no',11)->nullable();
            $table->string('mobile_no',50)->nullable();
            $table->string('customer_name', 100)->nullable();
            $table->foreignId('table_id',11)->nullable();
            $table->foreignId('server_id',11)->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
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
