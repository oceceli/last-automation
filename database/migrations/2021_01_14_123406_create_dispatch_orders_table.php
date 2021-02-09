<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispatchOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispatch_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('do_number')->unique();
            $table->string('do_status')->default('active');
            $table->datetime('do_planned_datetime');
            $table->datetime('do_actual_datetime')->nullable();
            $table->string('do_note')->nullable();

            $table->unsignedBigInteger('sales_type_id');
            // $table->string('do_sales_type');

            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('address_id');
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
        Schema::dropIfExists('dispatch_orders');
    }
}
