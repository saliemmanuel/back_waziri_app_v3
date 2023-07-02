<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactureModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facture_models', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_facture');
            $table->string('mensualite_facture');
            $table->string('montant_verser');
            $table->string('reste_facture');
            $table->string('statut_facture');
            $table->string('impayes');

            $table->unsignedBigInteger('id_abonne');
            $table->unsignedBigInteger('id_type_abonnement');
            $table->unsignedBigInteger('id_chef_secteur');
            $table->foreign('id_abonne')->references('id')->on('abonne_models')->onDelete('cascade');
            $table->foreign('id_type_abonnement')->references('id')->on('type_abonnement_models')->onDelete('cascade');
            $table->foreign('id_chef_secteur')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('facture_models');
    }
}
