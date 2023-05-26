<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePremarationEnvoiMessageModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premaration_envoi_message_models', function (Blueprint $table) {
            $table->id();
            $table->string("designation_message");
            $table->string("corps_message");
            $table->string("numeros");
            $table->string("statut_message");
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
        Schema::dropIfExists('premaration_envoi_message_models');
    }
}
