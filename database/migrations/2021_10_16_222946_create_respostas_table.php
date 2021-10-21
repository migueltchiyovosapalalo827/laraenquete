<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespostasTable extends Migration
{
    /**
     * Run the migrations.
     *perguntas
     * @return void
     */
    public function up()
    {
        Schema::create('respostas', function (Blueprint $table) {
            $table->id();
            $table->string("nome",255);
            $table->integer("qtdvotos")->default(0);
            $table->unsignedBigInteger("pergunta_id");
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
        Schema::dropIfExists('respostas');
    }
}
