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
            $table->string('de_license_plate')->nullable();
            $table->string('de_driver_name')->nullable();
            $table->string('de_driver_phone')->nullable();
            $table->decimal('de_dispatch_expense')->nullable();
            $table->decimal('de_handling_expense')->nullable();
            
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
