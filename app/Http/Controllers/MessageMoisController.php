<?php

namespace App\Http\Controllers;

use App\Models\MessageMois;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class MessageMoisController extends Controller
{
    public function index()
    {
        $charge = DB::select("SELECT * FROM `message_mois` WHERE 1");
        if (!isNull($charge))
            return response()->json(['response' => 'Aucun message disponible', 'error' => '1'], 400);
        return response()->json(['message' => $charge, 'error' => '0'], 200);
    }


    public function store(Request $request)
    {
        $rules = [
            'designation_message' => 'string|required',
            'corps_message' => 'string|required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $messageMois = MessageMois::create(
                [
                    'designation_message' => $request->designation_message,
                    'corps_message' => $request->corps_message
                ]
            );
            return response()->json(['message' => 'Message Mois enregistré avec succes', 'messageMoi' => $messageMois], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erreur lors de l\'enrégistrement. ' . $th,
                'error' => '1'
            ], 400);
        }
    }

    public function update(Request $request)
    {
        $messageMois = MessageMois::find($request->id);
        if (is_null($messageMois))
            return response()->json(['message' => 'Message Mois non disponible', 'error' => '1'], 400);
        $rules = [
            'designation_message' => 'string|required',
            'corps_message' => 'string|required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json(['message' => 'erreur 400', 'error' => '1'], 400);
        $messageMois->update($request->all());

        return response()->json(['messageMois' => $messageMois, 'message' => 'Modification effectuée', 'error' => '0'], 200);
    }

    public function destroy(Request $request)
    {

        $messageMois = DB::table('message_mois')->where(["id" => $request->id])->get()->first();
        try {
            if ($messageMois != null) {
                $data = MessageMois::find($messageMois->id)->delete();
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