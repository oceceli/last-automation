<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            // $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null'); // !! null olmalı

            $table->string('prd_code')->unique();
            $table->string('prd_barcode')->unique()->nullable();
            $table->decimal('prd_cost')->nullable();
            $table->string('prd_name'); 
            $table->integer('prd_shelf_life');
            $table->boolean('prd_producible');
            $table->boolean('prd_is_active')->default(true);
            $table->integer('prd_min_threshold')->nullable();
            $table->string('prd_note')->nullable();
            // $table->softDeletes();

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
        Schema::dropIfExists('products');
    }
}
