<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterielModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materiel_models', function (Blueprint $table) {
            $table->id();
            $table->string('designation_materiel');
            $table->string('prix_materiel');
            $table->string('image_materiel');
            $table->string('date_achat_materiel');
            $table->string('facture_materiel');
            $table->string('statut_materiel');
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
        Schema::dropIfExists('materiel_models');
    }
}
