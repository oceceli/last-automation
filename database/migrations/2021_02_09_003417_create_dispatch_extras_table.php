<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispatchExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispatch_extras', function (Blueprint $table) {
            $table->id();
            $table->string('de_license_plate');
            $table->string('de_driver_name');
            $table->string('de_driver_phone');
            $table->decimal('de_dispatch_expense');
            $table->decimal('de_handling_expense');
            
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
        Schema::dropIfExists('dispatch_extras');
    }
}
