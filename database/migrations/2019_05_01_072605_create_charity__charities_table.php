<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharityCharitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(!Schema::hasTable('charity__charities')){
        Schema::create('charity__charities', function (Blueprint $table) {
            $table->integer('charityid');
            $table->integer("followingid");
            $table->primary(['charityid','followingid']);
            $table->foreign('charityid')->references('id')->on('charities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('followingid')->references('id')->on('charities')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('charity__charities');
    }
}
