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
            $table->string('adr_name')->unique();
            $table->string('adr_country');
            $table->string('adr_province');
            $table->string('adr_district');
            $table->string('adr_body');

            $table->string('adr_phone')->nullable();
            $table->string('adr_note')->nullable();

            $table->string('addressable_type');
            $table->bigInteger('addressable_id');
            
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
