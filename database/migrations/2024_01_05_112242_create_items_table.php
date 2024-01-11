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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_category_id',11)->nullable();
            $table->foreignId('hotel_id',11)->nullable();
            $table->string('name',100)->nullable();
            $table->string('unit',10)->nullable();
            $table->decimal('opening_qty',10,2)->nullable();
            $table->decimal('closing_qty',10,2)->nullable();           
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
        Schema::dropIfExists('items');
    }
};
