<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(!Schema::hasTable('images')){
        Schema::create('images', function (Blueprint $table) {
          $table->increments('id');
          $table->string('image',255);
          $table->string('type',255);
          $table->integer('userid');
          $table->integer('charityid');
          $table->integer('postid')->references('id')->on('posts');
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
        Schema::dropIfExists('images');
    }
}
