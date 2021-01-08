<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('adr_name');
            $table->string('adr_country');
            $table->string('adr_province');
            $table->string('adr_district');
            $table->string('adr_body');
            $table->string('adr_phone');
            $table->string('adr_note');

            $table->string('adressable_type');
            $table->bigInteger('adressable_id');
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
        Schema::dropIfExists('addresses');
    }
}
