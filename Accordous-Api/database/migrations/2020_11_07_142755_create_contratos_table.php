<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrato', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipoPessoa', 1)->enum('tipoPessoa', ['Pessoa física', 'Pessoa Jurídica']);
            $table->string('documento', 18);
            $table->string('emailContratante', 200);
            $table->string('nomeContratante', 200);
            $table->timestamps();
            $table->softDeletes('deleted_at', 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contrato');
    }
}
