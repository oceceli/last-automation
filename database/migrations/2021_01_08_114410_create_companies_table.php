<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('cmp_name');
            $table->string('cmp_current_code')->unique();
            $table->string('cmp_commercial_title')->unique();

            $table->boolean('cmp_supplier');
            $table->boolean('cmp_customer');

            $table->string('cmp_note')->nullable();
            $table->string('cmp_phone')->nullable();
            $table->string('cmp_tax_number')->unique()->nullable();
            
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
        Schema::dropIfExists('companies');
    }
}
