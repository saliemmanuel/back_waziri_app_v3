<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeAbonnementModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_abonnement_models', function (Blueprint $table) {
            $table->id();
            $table->string("designation_type_abonnement");
            $table->string("montant");
            $table->string("nombre_chaine");
            $table->unsignedBigInteger("id_initiateur");
            $table->foreign("id_initiateur")->references('id')->on('users')
                ->onDelete("cascade");
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
        Schema::dropIfExists('type_abonnement_models');
    }
}
