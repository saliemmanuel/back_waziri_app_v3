<?php

namespace App\Http\Controllers;

use App\Models\AbonneModel;
use App\Models\FactureModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class FactureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->role_utilisateur == 'admin') {
            // Recupérer les facture des differents zones
            // Si admin toute les factures 
            // Si non les factures d'une zone seulement.

            // maintenant je dois recupérer 
            // de manière unique la facture d'un abonnée tout en 
            $facture = DB::select('SELECT 
            fm.id as id_facture, 
            fm.created_at as create_fm, 
            fm.*, 
            am.id as id_abonnee, 
            am.*, 
            tm.* FROM 
            `abonne_models` am, 
            `type_abonnement_models` tm ,
            `facture_models` fm
            WHERE fm.id_abonne = am.id AND am.id_type_abonnement = tm.id  ORDER BY id_facture DESC');


            // $facture = DB::table('abonne_models')
            // ->leftJoin('type_abonnement_models', 'abonne_models.id_type_abonnement', 'type_abonnement_models.id')
            // ->orderBy('abonne_models.created_at', 'asc')
            // ->leftJoin('facture_models', 'facture_models.id_abonne', 'abonne_models.id')
            // ->groupBy("cni_abonne")
            // ->get(['facture_models.id as id_facture', 'facture_models.created_at as create_fm', 'facture_models.*', 
            // 'abonne_models.id as id_abonnee',  'abonne_models.*', 'type_abonnement_models.*'])

            // ;

            if (!isNull($facture))
                return response()->json(['response' => 'Aucune facture disponible', 'error' => '1'], 400);
            return response()->json(['facture' => $facture, 'error' => '0'], 200);
        } else {
            $facture = DB::select('SELECT fm.id as id_facture ,fm.*,  fm.created_at as create_fm,
            am.id as id_abonnee, am.*, tm.*
            FROM `facture_models` fm ,`abonne_models` am, `type_abonnement_models` tm WHERE
            fm.id_abonne = am.id  AND am.id_type_abonnement = tm.id AND 
            fm.id_chef_secteur = am.id_chef_secteur AND 
            am.id_chef_secteur =' . $request->id_chef_secteur);

            if (!isNull($facture))
                return response()->json(['response' => 'Aucune facture disponible', 'error' => '1'], 400);
            return response()->json(['facture' => $facture, 'error' => '0'], 200);
        }
    }



    public function etablireFacture(Request $request)
    {

        // je recupère les abonnées avec leur types d'abonnement
        $abonnes = DB::select("SELECT am.id as id_adonne, am.*,
         ta.* FROM `abonne_models` as am , `type_abonnement_models` as ta 
         WHERE am.id_type_abonnement = ta.id");
        // je parcours tous les abonnees
        // je recupère les factures propre à un abonnée et je fait les opération 
        for ($j = 0; $j < count($abonnes); $j++) {
            $facture = DB::select("SELECT SUM(`mensualite_facture`) as mensualite_facture, 
            SUM(`montant_verser`) as montant_verser FROM `facture_models` 
            WHERE `id_abonne` = " . $abonnes[$j]->id_adonne);
            // 
            for ($i = 0; $i < count($facture); $i++) {
                $impayes = $facture[$i]->mensualite_facture - $facture[$i]->montant_verser;
                FactureModel::create(
                    [
                        'numero_facture' => count(FactureModel::all()) . rand(0, 1000000),
                        'mensualite_facture' => $abonnes[$j]->montant,
                        'montant_verser' => 0,
                        'reste_facture' => 0,
                        'statut_facture' => 'impayer',
                        'impayes' => $impayes < 0 ? 0 : $impayes,
                        'id_abonne' => $abonnes[$j]->id_adonne,
                        'id_type_abonnement' => $abonnes[$j]->id_type_abonnement,
                        'id_chef_secteur' => $abonnes[$j]->id_chef_secteur
                    ]
                );
            }
        }

        $list_facture = DB::select("SELECT * FROM `facture_models` ORDER BY id DESC LIMIT " . count($abonnes));
        return response()->json(
            [
                'message' => 'Facture effectué avec succès avec succes',
                'list_facture' => $list_facture
            ],
            200
        );
    }

    public function show($id)
    {
        $facture = FactureModel::find($id);
        if (is_null($facture))
            return response()->json(['message' => 'Facture abonné non disponible', 'error' => '1'], 400);
        return response()->json(['abonne' => $facture, 'error' => '1']);
    }

    public function update(Request $request)
    {
        $facture = FactureModel::find($request->id_facture);
        if (is_null($facture))
            return response()->json(['message' => 'abonne non disponible', 'error' => '1'], 400);
        $rules = [
            'id_facture' => 'string|required',
            'numero_facture' => 'string|required',
            'mensualite_facture' => 'string|required',
            'montant_verser' => 'string|required',
            'reste_facture' => 'string|required',
            'statut_facture' => 'string|required',
            'impayes' => 'string|required',
            'id_abonne' => 'string|required'
        ];
        $validator = Validator::make($request->all(), $rules);

        try {
            if ($validator->fails())
                return response()->json(['message' => 'erreur 400', 'error' => '1'], 400);

            $facture->update([
                'mensualite_facture' => $request->mensualite_facture,
                'montant_verser' => $request->montant_verser,
                'reste_facture' => $request->reste_facture,
                'statut_facture' => $request->statut_facture,
                'impayes' => $request->impayes
            ]);
            return response()->json(['facture' => $facture, 'message' => 'Paiement effectué', 'error' => '0'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => '1', 'message' => 'erreur 400'], 200);
        }
    }

    public function destroy(Request $request)
    {

        $type = DB::table('abonne_models')->where([
            "id" => $request->id,
            'prenom_abonne' => $request->prenom_abonne,
            'cni_abonne' => $request->cni_abonne,
            'telephone_abonne' => $request->telephone_abonne,
        ])->get()->first();
        try {
            if ($type != null) {
                $data = FactureModel::find($type->id)->delete();
                return response()->json([
                    "message" => "Suppréssion effectuée",
                    "statut" => $data
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Suppréssion non effectuée" . $th,
                "statut" => false
            ]);
        }
    }

    public function detailFactureAbonne(Request $request)
    {
        $abonne = AbonneModel::find($request->id_abonne);
        if (is_null($abonne))
            return response()->json(['message' => 'Erreur id abonné non disponible ', 'error' => '1'], 400);
        else {
            $facture = DB::select('SELECT fm.id as id_facture, fm.created_at as create_fm, fm.*, 
        am.id as id_abonnee, am.*, tm.* FROM `abonne_models` am, `type_abonnement_models` tm , 
        `facture_models` fm WHERE am.id = ' . $abonne->id . ' AND fm.id_abonne = am.id AND 
        am.id_type_abonnement = tm.id ORDER BY id_facture DESC');

            if (!isNull($facture))
                return response()->json(['response' => 'Aucune facture disponible', 'error' => '1'], 400);
            return response()->json(['facture' => $facture, 'error' => '0'], 200);
        }

    }
}