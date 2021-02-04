<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispatchProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispatch_products', function (Blueprint $table) {
            $table->id();
            $table->float('dp_amount');
            $table->boolean('dp_is_ready')->default(false);
            
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('dispatch_order_id');

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
        Schema::dropIfExists('dispatch_products');
    }
}
