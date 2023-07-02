<?php

namespace App\Http\Controllers;

use App\Models\CodeAdministration;
use App\Models\CodeAdministrationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

use function PHPUnit\Framework\isNull;

class CodeAdministrationController extends Controller
{

    public function store(Request $request)
    {
        $rules = [
            'code_admin' => 'string|required',
            'id_admin' => "string|required"
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            CodeAdministrationModel::create(
                [
                    'code_admin' => Hash::make($request->code_admin),
                    'remember_code_admin' => $request->code_admin,
                    'id_admin' => $request->id_admin
                ]
            );
            return response()->json(['message' => 'Code créer avec succes'], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => "Error :" . $request->id_admin,
                'message' => 'Code existant.',
                'error' => '1'
            ], 400);
        }
    }

    public function show(Request $request)
    {

        $request->validate([
            'code_admin' => 'int|required',
            'id_admin' => "int|required"
        ]);

        $code = CodeAdministrationModel::where('id_admin', $request->id_admin)->first();

        if ($code == null) {
            return response()->json([
                "message" => "Vous n'avez pas initié votre code",
                "statut" => false,
            ]);
        } else {
            if (Hash::check($request->code_admin, $code['code_admin'])) {
                return response()->json([
                    "message" => "Succès",
                    "statut" => true,
                ]);
            } else {
                return response()->json([
                    "message" => "Code incorret",
                    "statut" => false,
                ]);
            }
        }

    }

    public function edite(Request $request)
    {
        $request->validate([
            'code_admin' => 'int|required',
            'id_admin' => "int|required",
            'new_code' => "int|required",
        ]);

        $code = CodeAdministrationModel::where('id_admin', $request->id_admin)->first();

        if ($code == null) {
            return response()->json([
                "message" => "Vous n'avez pas initié votre code",
                "statut" => false,
            ], 200);
        } else {
            if (Hash::check($request->code_admin, $code['code_admin'])) {
                $code->update(
                    [
                        'code_admin' => Hash::make($request->new_code),
                        'remember_code_admin' => $request->new_code
                    ]
                );
            } else {
                return response()->json([
                    "message" => "Ancient code incorret",
                    "statut" => false,
                ], 200);
            }
        }
        return response()->json(['message' => 'Modification éffectuée'], 200);

    }
}