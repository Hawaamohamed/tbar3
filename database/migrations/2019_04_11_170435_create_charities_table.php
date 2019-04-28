<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(!Schema::hasTable('charities')){
        Schema::create('charities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',191);
            $table->string('email',191)->unique();
            $table->string('phone',191)->unique();
            $table->string('address',191)->nullable();
            $table->string('visa',191)->unique()->nullable();
            $table->string('password',191);
            $table->string('profile',191)->nullable()->default('pro.jpg');
            $table->string('cover',191)->nullable()->default('cover.jpg');
            $table->string('advertising',191)->nullable();
            $table->string('lat',191)->nullable();
            $table->string('long',191)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('charities');
    }
}
