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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id',11)->nullable();
            $table->foreignId('package_id',11)->nullable();
            $table->string('subscription_no',50)->nullable();
            $table->date('subscription_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('payment_mode',20)->nullable();
            $table->string('cheque_no',50)->nullable();
            $table->string('bank_name',50)->nullable();
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
        Schema::dropIfExists('subscriptions');
    }
};
