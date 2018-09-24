<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarbecuerentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barbecue_renters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_user');
            $table->string('id_barbecue');
            $table->string('date_from');
            $table->string('date_to');
            $table->string('amount');
            $table->string('address')->nullable();
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
