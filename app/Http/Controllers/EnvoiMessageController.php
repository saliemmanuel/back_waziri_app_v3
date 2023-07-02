<?php

namespace App\Http\Controllers;

use App\Models\EnvoiMessageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isNull;

class EnvoiMessageController extends Controller
{
    public function index()
    {
        $charge = DB::select("SELECT * FROM `message_mois` WHERE 1");
        if (!isNull($charge))
            return response()->json(['response' => 'Aucun message disponible', 'error' => '1'], 400);
        return response()->json(['message' => $charge, 'error' => '0'], 200);
    }

    public function update(Request $request)
    {
        $messageMois = EnvoiMessageModel::find($request->id);
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
}