<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVersemmentParSecteursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('versemment_par_secteurs', function (Blueprint $table) {
            $table->id();
            $table->string("nom_secteur");
            $table->string("nom_chef_secteur");
            // $table->string("net_a_payer");
            $table->string("somme_verser");
            // $table->string("reste_a_verser");
            $table->string("date_versement");
            $table->unsignedBigInteger('id_secteur');
            $table->unsignedBigInteger("id_chef_secteur");
            $table->foreign('id_secteur')->references('id')->on('secteur_models')->onDelete('cascade');
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
        Schema::dropIfExists('versemment_par_secteurs');
    }
}
