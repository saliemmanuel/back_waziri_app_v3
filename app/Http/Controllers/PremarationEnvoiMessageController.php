<?php

namespace App\Http\Controllers;

use App\Models\PremarationEnvoiMessageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class PreparationEnvoiMessageController extends Controller
{
    public function index()
    {
        $charge = DB::select("SELECT * FROM `premaration_envoi_message_models` WHERE 1");
        if (!isNull($charge))
            return response()->json(['response' => 'Aucun message disponible', 'error' => '1'], 400);
        return response()->json(['message' => $charge, 'error' => '0'], 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'designation_message' => 'string|required',
            'corps_message' => 'string|required',
            'numeros' => 'string|required',
            'statut_message' => 'string|required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $charge = PremarationEnvoiMessageModel::create(
                [
                    'designation_message' => $request->designation_message,
                    'corps_message' => $request->corps_message,
                    'numeros' => $request->numeros,
                    'statut_message' => $request->statut_message
                ]
            );
            return response()->json(['message' => 'message créer avec succes', 'charge' => $charge], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' =>  'Erreur lors de l\'enrégistrement. ' . $th, 'error' => '1'
            ], 400);
        }
    }
    public function destroy()
    {
        $message = PremarationEnvoiMessageModel::all();
        try {
            if ($message != null) {
                $data =  $message->delete();
                return response()->json([
                    "message" => "Suppréssion effectuée",
                    "data" => $data
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
