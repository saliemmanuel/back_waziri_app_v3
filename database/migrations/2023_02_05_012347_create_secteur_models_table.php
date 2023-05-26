<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecteurModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secteur_models', function (Blueprint $table) {
            $table->id();
            $table->string("designation_secteur")->unique();
            $table->string("description_secteur");
            $table->string("nom_chef_secteur")->unique();
            $table->unsignedBigInteger("id_chef_secteur");
            $table->foreign("id_chef_secteur")->references('id')->on('users')
            ->onDelete('cascade');

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
        Schema::dropIfExists('secteur_models');
    }
}
