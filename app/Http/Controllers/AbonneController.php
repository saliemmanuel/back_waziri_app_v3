<?php

namespace App\Http\Controllers;

use App\Models\AbonneModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class AbonneController extends Controller
{
    public function index(Request $request)
    {
        if ($request->role_utilisateur == 'admin') {
            $abonne = AbonneModel::all();
            if (!isNull($abonne))
                return response()->json(['response' => 'Aucun abonnée disponible', 'error' => '1'], 400);
            return response()->json(['abonne' => $abonne, 'error' => '0'], 200);
        } else {
            $abonne = DB::table('abonne_models')->where([
                "id_chef_secteur" => $request->id_chef_secteur
            ])->get()->all();
            if (!isNull($abonne))
                return response()->json(['response' => 'Aucun abonnée disponible', 'error' => '1'], 400);
            return response()->json(['abonne' => $abonne, 'error' => '0'], 200);
        }
    }


    public function store(Request $request)
    {
        $rules = [
            'nom_abonne' => 'string|required',
            'prenom_abonne' => 'string|required',
            'cni_abonne' => 'string|required',
            'telephone_abonne' => 'string|required',
            'description_zone_abonne' => 'string|required',
            'secteur_abonne' => 'string|required',
            'id_chef_secteur' => 'string|required',
            'type_abonnement' => 'string|required',
            'id_type_abonnement' => 'string|required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $abonne = AbonneModel::create(
                [
                    'nom_abonne' => $request->nom_abonne,
                    'prenom_abonne' => $request->prenom_abonne,
                    'cni_abonne' => $request->cni_abonne,
                    'telephone_abonne' => $request->telephone_abonne,
                    'description_zone_abonne' => $request->description_zone_abonne,
                    'secteur_abonne' => $request->secteur_abonne,
                    'id_chef_secteur' => $request->id_chef_secteur,
                    'type_abonnement' => $request->type_abonnement,
                    'id_type_abonnement' => $request->id_type_abonnement
                ]
            );
            return response()->json(
                ['message' => 'Abonné créer avec succes', 'abonne' => $abonne],
                200
            );
        } catch (\Throwable $th) {
            return response()->json([
                'message' =>  'Désignation type existant.' . $th, 'error' => '1'
            ], 400);
        }
    }

    public function show($id)
    {
        $abonne = AbonneModel::find($id);
        if (is_null($abonne))
            return response()->json(['message' => 'abonne non disponible', 'error' => '1'], 400);
        return response()->json(['abonne' => $abonne, 'error' => '1']);
    }

    public function update(Request $request)
    {
        $abonne = AbonneModel::find($request->id);
        if (is_null($abonne))
            return response()->json(['message' => 'abonne non disponible', 'error' => '1'], 400);
        $rules = [
            'nom_abonne' => 'string|required',
            'prenom_abonne' => 'string|required',
            'cni_abonne' => 'string|required',
            'telephone_abonne' => 'string|required',
            'description_zone_abonne' => 'string|required',
            'secteur_abonne' => 'string|required',
            'id_chef_secteur' => 'string|required',
            'type_abonnement' => 'string|required',
            'id_type_abonnement' => 'string|required',

        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json(['message' => 'erreur 400', 'error' => '1'], 400);
        $abonne->update($request->all());

        return response()->json(['abonne' => $abonne,'message' => 'Modification effectuée', 'error' => '0'], 200);
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
                $data =  AbonneModel::find($type->id)->delete();
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
}
