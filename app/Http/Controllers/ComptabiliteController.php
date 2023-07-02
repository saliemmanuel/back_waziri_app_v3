<?php

namespace App\Http\Controllers;

use App\Models\comptabilite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isNull;

class ComptabiliteController extends Controller
{
    public function index()
    {

        $comptabilites = DB::select("SELECT * FROM `comptabilites` WHERE 1");
        if (!isNull($comptabilites))
            return response()->json(['message' => 'Aucune donnée disponible', 'error' => '1'], 400);
        return response()->json(['message' => $comptabilites, 'error' => '0'], 200);

    }


    public function create()
    {
        // Recette : Entre - sortie
        $recette = 0;
        // Sorite : somme des charge et materiel
        $sortie = 0;
        // Entrees : somme versé paiement et versement secteur
        $entre = 0;
        // Dettes : somme impayer par les client 
        $dettes = 0;

        $prix_materiel = DB::select("SELECT `prix_materiel` FROM `materiel_models`");
        $somme_verser_charge = DB::select("SELECT `somme_verser` FROM  `charge_models`");
        $sum_somme_verser_charge = 0;
        $sum_prix_materiel = 0;

        for ($i = 0; $i < count($somme_verser_charge); $i++) {
            $sum_somme_verser_charge = $sum_somme_verser_charge + $somme_verser_charge[$i]->somme_verser;
        }

        for ($i = 0; $i < count($prix_materiel); $i++) {
            $sum_prix_materiel = $sum_prix_materiel + $prix_materiel[$i]->prix_materiel;
        }


        $somme_verser_par_sec = DB::select("SELECT `somme_verser` FROM `versemment_par_secteurs`");
        $somme_montant_verser = DB::select("SELECT `montant_verser` FROM `facture_models`");
        $sum_somme_verser_par_sec = 0;
        $sum_somme_montant_verser = 0;

        for ($i = 0; $i < count($somme_verser_par_sec); $i++) {
            $sum_somme_verser_par_sec = $sum_somme_verser_par_sec + $somme_verser_par_sec[$i]->somme_verser;
        }

        for ($i = 0; $i < count($somme_montant_verser); $i++) {
            $sum_somme_montant_verser = $sum_somme_montant_verser + $somme_montant_verser[$i]->montant_verser;
        }


        $somme_impayes = DB::select("SELECT `impayes`,`montant_verser` FROM `facture_models`");
        $sum_somme_impayes = 0;
        $sum_montant_verser = 0;


        for ($i = 0; $i < count($somme_impayes); $i++) {
            $sum_somme_impayes = $sum_somme_impayes + $somme_impayes[$i]->impayes;
            $sum_montant_verser = $sum_montant_verser + $somme_impayes[$i]->montant_verser;
        }

        // resultat sortie 
        $sortie = $sum_somme_verser_charge + $sum_prix_materiel;

        // resultat entrees
        $entre = $sum_somme_verser_par_sec + $sum_somme_montant_verser;

        // resultat dette 
        $dettes = $sum_montant_verser - $sum_somme_impayes;

        // resultat recette 
        $recette = $entre - $sortie;
        comptabilite::query()->truncate();
        $comptabilites = comptabilite::create([
            'recette' => $recette,
            'sorties' => $sortie,
            'entrees' => $entre,
            'dettes' => $dettes
        ]);
        return response()->json(['comptabilites' => $comptabilites, 'error' => '1'], 400);

    }



    public function update(Request $request)
    {

        $update = DB::table('comptabilites')->where("id", 1)
            ->update([
                "recette" => 0,
                "sorties" => 0,
                "entrees" => 0
            ]);

        return response()->json(['comptabilites' => $update, 'message' => 'Rénitialisation effectuée', 'error' => '0'], 200);

    }


}