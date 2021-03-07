<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockMovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_moves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            // $table->unsignedBigInteger('unit_id');
            $table->string('type');
            $table->string('lot_number');
            $table->boolean('direction');
            $table->integer('base_amount');
            $table->date('datetime');

            $table->boolean('approved')->default(false);

            $table->string('stockable_type')->nullable();
            $table->bigInteger('stockable_id')->nullable();
    
            $table->softDeletes();
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
        Schema::dropIfExists('stock_moves');
    }
}
