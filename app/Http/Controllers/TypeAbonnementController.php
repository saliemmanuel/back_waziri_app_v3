<?php

namespace App\Http\Controllers;

use App\Models\TypeAbonnementModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class TypeAbonnementController extends Controller
{
    public function index()
    {
        $type = TypeAbonnementModel::all();
        if (!isNull($type))
            return response()->json(['response' => 'Aucun type disponible', 'error' => '1'], 400);
        return response()->json(['type_abonnement' => $type, 'error' => '0'], 200);
    }


    public function store(Request $request)
    {
        $rules = [
            'designation_type_abonnement' => 'string|required',
            'montant' => 'string|required',
            'nombre_chaine' => 'string|required',
            'id_initiateur' => 'string|required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $type = TypeAbonnementModel::create(
                [
                    'designation_type_abonnement' =>  $request->designation_type_abonnement,
                    'montant' => $request->montant,
                    'nombre_chaine' => $request->nombre_chaine,
                    'id_initiateur' => $request->id_initiateur,
                ]
            );
            return response()->json(['message' => 'Type abonnement créer avec succes', 'type' => $type], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' =>  'Désignation type existant.', 'error' => '1'
            ], 400);
        }
    }

    public function show($id)
    {
        $type = TypeAbonnementModel::find($id);
        if (is_null($type))
            return response()->json(['message' => 'Utilisateur non disponible', 'error' => '1'], 400);
        return response()->json(['Utilisateur' => $type, 'error' => '1']);
    }

    public function update(Request $request)
    {
        $type = TypeAbonnementModel::find($request->id);
        if (is_null($type))
            return response()->json(['message' => 'Utilisateur non disponible', 'error' => '1'], 400);
        $rules = [
            'designation_type_abonnement' => 'string|required',
            'montant' => 'string|required',
            'nombre_chaine' => 'string|required',
            'id_initiateur' => 'string|required',

        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json(['message' => 'erreur 400', 'error' => '1'], 400);
        $type->update($request->all());

        return response()->json(['type' => $type, 'message' => 'Modification effectuée','error' => '0'], 200);
    }

    public function destroy(Request $request)
    {

        $type = DB::table('type_abonnement_models')->where([
            "id" => $request->id,
            "montant" => $request->montant,
            "designation_type_abonnement" => $request->designation_type_abonnement,
            "nombre_chaine" => $request->nombre_chaine,
        ])->get()->first();
        try {
            if ($type != null) {
                $data =  TypeAbonnementModel::find($type->id)->delete();
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
