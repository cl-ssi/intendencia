<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCovid19sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covid19s', function (Blueprint $table) {
            $table->id();

            $table->integer('identifier');
            $table->string('name');
            $table->string('fathers_family');
            $table->string('mothers_family')->nullable();

            $table->string('origin');
            $table->datetime('sample_at');

            $table->datetime('reception_at')->nullable();
            $table->datetime('result_at')->nullable();
            $table->string('result')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('receptor_id')->nullable();
            $table->unsignedBigInteger('validator_id')->nullable();

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
        Schema::dropIfExists('covid19s');
    }
}
