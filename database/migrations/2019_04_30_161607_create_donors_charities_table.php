<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonorsCharitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(!Schema::hasTable('donors_charities')){
        Schema::create('donors_charities', function (Blueprint $table) {
            $table->integer('donorid')->unsigned()->index();
            $table->integer('charityid')->unsigned()->index();
            $table->primary(['donorid','charityid']);
            $table->foreign('donorid')->references('id')->on('donors')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('charityid')->references('id')->on('charities')->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();
        });
      }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donors_charities');
    }
}
