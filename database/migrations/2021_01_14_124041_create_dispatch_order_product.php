<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispatchOrderProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispatch_order_product', function (Blueprint $table) {
            $table->id();
            $table->string('dp_lot_number');
            $table->integer('dp_amount');
            $table->unsignedBigInteger('unit_id');

            $table->unsignedBigInteger('dispatch_order_id');
            $table->unsignedBigInteger('product_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dispatch_order_product');
    }
}
