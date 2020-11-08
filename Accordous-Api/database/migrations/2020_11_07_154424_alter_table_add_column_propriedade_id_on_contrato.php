<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAddColumnPropriedadeIdOnContrato extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contrato', function (Blueprint $table) {
            $table->unsignedBigInteger('propriedade_id')->after('id')->unique();
            $table->foreign('propriedade_id')->references('id')->on('propriedade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contrato', function (Blueprint $table) {
            $table->dropForeign('contrato_propriedade_id_unique');
            $table->dropColumn('propriedade_id');
        });
    }
}
