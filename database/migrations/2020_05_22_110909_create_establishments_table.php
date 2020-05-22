<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstablishmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('communes', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          
          $table->timestamps();
          $table->softDeletes();
      });

      Schema::create('establishments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('type',['HOSPITAL','CESFAM','CECOSF','PSR','CGR','SAPU','COSAM','PRAIS']);
            $table->string('deis');
            $table->unsignedInteger('commune_id');

            $table->foreign('commune_id')->references('id')->on('communes');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('establishments');
        Schema::dropIfExists('communes');
    }
}