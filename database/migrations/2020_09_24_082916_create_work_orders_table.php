<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('unit_id');
            $table->string('wo_lot_no');
            $table->integer('wo_amount');
            $table->dateTime('wo_datetime');
            $table->string('wo_code');
            $table->integer('wo_queue');
            
            $table->string('wo_status')->default('active');
            $table->dateTime('wo_started_at')->nullable();
            $table->dateTime('wo_completed_at')->nullable();

            $table->string('wo_note')->nullable();

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
        Schema::dropIfExists('work_orders');
    }
}
