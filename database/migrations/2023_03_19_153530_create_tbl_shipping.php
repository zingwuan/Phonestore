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
        Schema::create('tbl_shipping', function (Blueprint $table) {
            $table->increments('shipping_id');
            $table->string('shipping_name');
            $table->text('shipping_address');
            $table->string('shipping_phone');
            $table->string('shipping_email');
            $table->text('shipping_note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_shipping');
    }
};
