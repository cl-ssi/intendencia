<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFkInstitutionIdInHelpBasket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('help_baskets', function (Blueprint $table) {
            //
            $table->foreignId('institution_id')->after('commune_id')->nullable();
            $table->foreign('institution_id')->references('id')->on('institutions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('help_baskets', function (Blueprint $table) {
            //
            $table->dropForeign(['institution_id']);

        });

        //drop the column
        Schema::table('help_baskets', function (Blueprint $table) {
            //
            $table->dropColumn('institution_id');

        });
    }
}
