<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbonneModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonne_models', function (Blueprint $table) {
            $table->id();
            $table->string("nom_abonne");
            $table->string("prenom_abonne");
            $table->string("cni_abonne");
            $table->string("telephone_abonne");
            $table->string("description_zone_abonne");
            $table->string("secteur_abonne");
            $table->unsignedBigInteger('id_chef_secteur');
            $table->string("type_abonnement");
            $table->unsignedBigInteger("id_type_abonnement");
            $table->foreign('id_chef_secteur')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_type_abonnement')->references('id')->on('type_abonnement_models')->onDelete('cascade');
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
        Schema::dropIfExists('abonne_models');
    }
}
