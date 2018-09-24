<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarbecuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barbecues', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_user');
            $table->string('model');
            $table->string('description');
            $table->integer('year');
            $table->string('price');
            $table->integer('transport')->default(0);
            $table->string('cooking_area');
            $table->string('materials');
            $table->string('dimensions');
            $table->string('fuel');
            $table->string('ideal_for');
            $table->string('photo');
            $table->string('latitude');
            $table->string('longitude');
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
        //
    }
}
