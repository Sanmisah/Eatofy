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
        Schema::create('hotel_staffs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id',11)->nullable();
            $table->string('staff_name',100)->nullable();
            $table->string('contact_no',20)->nullable();
            $table->string('address',255)->nullable();
            $table->string('type',20)->nullable();
            $table->string('salary',20)->nullable();
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
        Schema::dropIfExists('hotel_staffs');
    }
};
