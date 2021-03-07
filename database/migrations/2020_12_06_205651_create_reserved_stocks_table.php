<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservedStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserved_stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            // $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->string('reserved_lot');
            $table->float('reserved_amount');
            
            $table->boolean('reserved_is_archived')->default(false);
            
            $table->string('reservable_type');
            $table->unsignedBigInteger('reservable_id');
            
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
        Schema::dropIfExists('reserved_stocks');
    }
}
