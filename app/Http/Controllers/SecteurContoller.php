<?php

namespace App\Http\Controllers;

use App\Models\SecteurModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class SecteurContoller extends Controller
{

    public function index()
    {
        $secteur = SecteurModel::all();
        if (!isNull($secteur))
            return response()->json(['response' => 'Aucun secteur disponible', 'error' => '1'], 400);
        return response()->json(['secteurs' => $secteur, 'error' => '0'], 200);
    }


    public function store(Request $request)
    {
        $rules = [
            'designation_secteur' => 'string|required',
            'description_secteur' => 'string|required',
            'nom_chef_secteur' => 'string|required',
            'id_chef_secteur' => 'string|required'

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $secteur = SecteurModel::create(
                [
                    'designation_secteur' => $request->designation_secteur,
                    'description_secteur' => $request->description_secteur,
                    'nom_chef_secteur' => $request->nom_chef_secteur,
                    'id_chef_secteur' => $request->id_chef_secteur
                ]
            );
            return response()->json(['message' => 'secteur créer avec succes', 'secteur' => $secteur], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erreur lors de la création.',
                'error' => '1'
            ], 400);
        }
    }

    public function show($id)
    {
        $secteur = SecteurModel::find($id);
        if (is_null($secteur))
            return response()->json(['message' => 'Utilisateur non disponible', 'error' => '1'], 400);
        return response()->json(['Utilisateur' => $secteur, 'error' => '1']);
    }

    public function update(Request $request)
    {
        $secteur = SecteurModel::find($request->id);
        if (is_null($secteur))
            return response()->json(['message' => 'Secteur non disponible', 'error' => '1'], 400);
        $rules = [
            'designation_secteur' => 'string|required',
            'description_secteur' => 'string|required',
            'nom_chef_secteur' => 'string|required',
            'id_chef_secteur' => 'string|required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json(['message' => 'erreur 400 222' . $request->description_secteur, 'error' => '1'], 400);

        $secteur->update($request->all());

        return response()->json(['Secteur' => $secteur, "message" => "Modification effectuée", 'error' => '0'], 200);
    }

    public function destroy(Request $request)
    {

        $secteur = DB::table('secteur_models')->where([
            "id" => $request->id,
            "designation_secteur" => $request->designation_secteur,
        ])->get()->first();
        try {
            if ($secteur != null) {
                $data = SecteurModel::find($secteur->id)->delete();
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