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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('hotel_name',100)->nullable();
            $table->string('branch_name',100)->nullable();
            $table->string('address',255)->nullable();
            $table->string('state',50)->nullable();
            $table->string('city',50)->nullable();
            $table->string('contact_no',20)->nullable();
            $table->string('website_url',255)->nullable();
            $table->string('owner_name',50)->nullable();
            $table->string('owner_contact_no',20)->nullable();  
            $table->string('gstin',20)->nullable(); 
            $table->string('fssai_no',20)->nullable();
            $table->date('expiry_date')->nullable(); 
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
        Schema::dropIfExists('hotels');
    }
};
