<?php

namespace App\Http\Controllers;

use App\Models\ChargeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class ChargeController extends Controller
{
    public function index()
    {
        $charge = DB::select("SELECT * FROM `charge_models` WHERE 1");
        if (!isNull($charge))
            return response()->json(['response' => 'Aucun charge disponible', 'error' => '1'], 400);
        return response()->json(['charges' => $charge, 'error' => '0'], 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'designation_charge' => 'string|required',
            'description_charge' => 'string|required',
            'date_charge' => 'string|required',
            'somme_verser' => 'string|required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $charge = ChargeModel::create(
                [
                    'designation_charge' => $request->designation_charge,
                    'description_charge' => $request->description_charge,
                    'date_charge' => $request->date_charge,
                    'somme_verser' => $request->somme_verser
                ]
            );
            return response()->json(['message' => 'charge créer avec succes', 'charge' => $charge], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erreur lors de l\'enrégistrement. ' . $th,
                'error' => '1'
            ], 400);
        }
    }

    public function update(Request $request)
    {
        $secteur = ChargeModel::find($request->id);
        if (is_null($secteur))
            return response()->json(['message' => 'Charge non disponible', 'error' => '1'], 400);
        $rules = [
            'designation_charge' => 'string|required',
            'description_charge' => 'string|required',
            'date_charge' => 'string|required',
            'somme_verser' => 'string|required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json(['message' => 'erreur 400', 'error' => '1'], 400);

        $secteur->update($request->all());

        return response()->json(['Secteur' => $secteur, "message" => "Modification effectuée", 'error' => '0'], 200);
    }


    public function destroy(Request $request)
    {

        $charge = DB::table('charge_models')->where([
            "id" => $request->id,
            'designation_charge' => $request->designation_charge,
            'description_charge' => $request->description_charge,
            'date_charge' => $request->date_charge,
            'somme_verser' => $request->somme_verser
        ])->get()->first();
        try {
            if ($charge != null) {
                $data = ChargeModel::find($charge->id)->delete();
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