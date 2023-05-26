<?php

namespace App\Http\Controllers;

use App\Models\VersemmentParSecteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class VersemmentParSecteurController extends Controller
{
    public function index()
    {
        $versement = DB::select("SELECT * FROM `versemment_par_secteurs` WHERE 1");
        if (!isNull($versement))
            return response()->json(['response' => 'Aucun matériel disponible', 'error' => '1'], 400);
        return response()->json(['versement' => $versement, 'error' => '0'], 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'nom_secteur' => 'string|required',
            'nom_chef_secteur' => 'string|required',
            'somme_verser' => 'string|required',
            'date_versement' => 'string|required',
            'id_secteur' => 'string|required',
            'id_chef_secteur' => 'string|required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $versement = VersemmentParSecteur::create(
                [
                    'nom_secteur' => $request->nom_secteur,
                    'nom_chef_secteur' => $request->nom_chef_secteur,
                    'somme_verser' => $request->somme_verser,
                    'date_versement' => $request->date_versement,
                    'id_secteur' => $request->id_secteur,
                    'id_chef_secteur' => $request->id_chef_secteur
                ]
            );
            return response()->json(['message' => 'Versement créer avec succes', 'secteur' => $versement], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erreur lors de l\'enrégistrement. ' . $th,
                'error' => '1'
            ], 400);
        }
    }

    public function update(Request $request)
    {
        $secteur = VersemmentParSecteur::find($request->id);
        if (is_null($secteur))
            return response()->json(['message' => 'Secteur non disponible', 'error' => '1'], 400);
        $rules = ['somme_verser' => 'string|required'];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json(['message' => 'erreur 400', 'error' => '1'], 400);

        $secteur->update($request->all());

        return response()->json(['Secteur' => $secteur, "message" => "Modification effectuée", 'error' => '0'], 200);
    }


    public function destroy(Request $request)
    {

        $versement = DB::table('versemment_par_secteurs')->where([
            "id" => $request->id,
            'nom_secteur' => $request->nom_secteur,
            'nom_chef_secteur' => $request->nom_chef_secteur,
            'somme_verser' => $request->somme_verser,
            'date_versement' => $request->date_versement,
            'id_secteur' => $request->id_secteur,
            'id_chef_secteur' => $request->id_chef_secteur
        ])->get()->first();
        try {
            if ($versement != null) {
                $data = VersemmentParSecteur::find($versement->id)->delete();
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