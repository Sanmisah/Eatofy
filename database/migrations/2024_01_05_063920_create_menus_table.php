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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_category_id',11)->nullable();
            $table->foreignId('hotel_id',11)->nullable();
            $table->string('type',10)->nullable();
            $table->string('item_name',100)->nullable();
            $table->string('item_description',255)->nullable();
            $table->string('contact_no',20)->nullable();
            $table->decimal('rate',10,2)->nullable();
            $table->string('gst_rate',10)->nullable();           
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
        Schema::dropIfExists('menus');
    }
};
