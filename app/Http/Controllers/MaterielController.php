<?php

namespace App\Http\Controllers;

use App\Models\materielModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class MaterielController extends Controller
{
    public function index()
    {
        $materiel = DB::select("SELECT * FROM `materiel_models` WHERE 1");
        if (!isNull($materiel))
            return response()->json(['response' => 'Aucun matériel disponible', 'error' => '1'], 400);
        return response()->json(['materiel' => $materiel, 'error' => '0'], 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'designation_materiel' => 'string|required',
            'prix_materiel' => 'string|required',
            'date_achat_materiel' => 'string|required',
            'statut_materiel' => 'string|required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        if ($request->hasFile('image_materiel') && $request->hasFile('facture_materiel')) {

            try {
                $img_mat = $request->file('image_materiel');
                $img_fat = $request->file('facture_materiel');
                $img_path = $img_mat->getClientOriginalName();
                $fat_path = $img_fat->getClientOriginalName();
                $img_mat->move(public_path('/upload/materiels'), $img_path);
                $img_fat->move(public_path('/upload/facture'), $fat_path);
                $materiel = MaterielModel::create(
                    [
                        'designation_materiel' => $request->designation_materiel,
                        'prix_materiel' => $request->prix_materiel,
                        'image_materiel' => '/upload/materiels/' . $img_path,
                        'date_achat_materiel' => $request->date_achat_materiel,
                        'facture_materiel' => '/upload/facture/' . $fat_path,
                        'statut_materiel' => $request->statut_materiel
                    ]
                );
                return response()->json(['message' => 'Materiel créer avec succes', 'materiel' => $materiel], 200);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => 'Erreur lors de la création.',
                    'error' => '1'
                ], 400);
            }
        } else {
            echo 'errorImage';
        }
    }
    public function update(Request $request)
    {
        $materiel = MaterielModel::find($request->id);
        if (is_null($materiel))
            return response()->json(['message' => 'Matériel non disponible', 'error' => '1'], 400);
        $rules = [
            'designation_message' => 'string|required',
            'corps_message' => 'string|required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json(['message' => 'erreur 400', 'error' => '1'], 400);

        if ($request->hasFile('image_materiel')) {

            try {
                $img_mat = $request->file('image_materiel');
                $img_path = $img_mat->getClientOriginalName();
                $img_mat->move(public_path('/upload/materiels'), $img_path);

                $materiel->update([
                    'designation_materiel' => $request->designation_materiel,
                    'prix_materiel' => $request->prix_materiel,
                    'image_materiel' => '/upload/materiels/' . $img_path,
                    'date_achat_materiel' => $request->date_achat_materiel,
                    'statut_materiel' => $request->statut_materiel
                ]);

                return response()->json(['message' => 'Modification effectuée', 'materiel' => $materiel], 200);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => 'Erreur lors de la modification.',
                    'error' => '1'
                ], 400);
            }
        } else
            if ($request->hasFile('facture_materiel')) {

                try {
                    $img_fat = $request->file('facture_materiel');
                    $fat_path = $img_fat->getClientOriginalName();
                    $img_fat->move(public_path('/upload/facture'), $fat_path);

                    $materiel->update([
                        'designation_materiel' => $request->designation_materiel,
                        'prix_materiel' => $request->prix_materiel,
                        'date_achat_materiel' => $request->date_achat_materiel,
                        'facture_materiel' => '/upload/facture/' . $fat_path,
                        'statut_materiel' => $request->statut_materiel
                    ]);

                    return response()->json(['message' => 'Modification effectuée', 'materiel' => $materiel], 200);
                } catch (\Throwable $th) {
                    return response()->json([
                        'message' => 'Erreur lors de la modification.',
                        'error' => '1'
                    ], 400);
                }

            }
        if ($request->hasFile('image_materiel') && $request->hasFile('facture_materiel')) {

            try {
                $img_mat = $request->file('image_materiel');
                $img_fat = $request->file('facture_materiel');
                $img_path = $img_mat->getClientOriginalName();
                $fat_path = $img_fat->getClientOriginalName();
                $img_mat->move(public_path('/upload/materiels'), $img_path);
                $img_fat->move(public_path('/upload/facture'), $fat_path);
                $materiel = MaterielModel::create(
                    [
                        'designation_materiel' => $request->designation_materiel,
                        'prix_materiel' => $request->prix_materiel,
                        'image_materiel' => '/upload/materiels/' . $img_path,
                        'date_achat_materiel' => $request->date_achat_materiel,
                        'facture_materiel' => '/upload/facture/' . $fat_path,
                        'statut_materiel' => $request->statut_materiel
                    ]
                );
                return response()->json(['message' => 'Materiel créer avec succes', 'materiel' => $materiel], 200);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => 'Erreur lors de la création.',
                    'error' => '1'
                ], 400);
            }
        } else if ($request->hasFile('image_materiel') && $request->hasFile('facture_materiel')) {

            try {
                $img_mat = $request->file('image_materiel');
                $img_fat = $request->file('facture_materiel');
                $img_path = $img_mat->getClientOriginalName();
                $fat_path = $img_fat->getClientOriginalName();
                $img_mat->move(public_path('/upload/materiels'), $img_path);
                $img_fat->move(public_path('/upload/facture'), $fat_path);
                $materiel = MaterielModel::create(
                    [
                        'designation_materiel' => $request->designation_materiel,
                        'prix_materiel' => $request->prix_materiel,
                        'image_materiel' => '/upload/materiels/' . $img_path,
                        'date_achat_materiel' => $request->date_achat_materiel,
                        'facture_materiel' => '/upload/facture/' . $fat_path,
                        'statut_materiel' => $request->statut_materiel
                    ]
                );
                return response()->json(['message' => 'Materiel créer avec succes', 'materiel' => $materiel], 200);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => 'Erreur lors de la création.',
                    'error' => '1'
                ], 400);
            }
        } else {
            echo 'errorImage';
        }

    }
    public function destroy(Request $request)
    {

        $materiel = DB::table('materiel_models')->where([
            "id" => $request->id,
            "designation_materiel" => $request->designation_materiel,
            "prix_materiel" => $request->prix_materiel,
            "date_achat_materiel" => $request->date_achat_materiel,
            "created_at" => $request->created_at
        ])->get()->first();
        try {
            if ($materiel != null) {
                $data = MaterielModel::find($materiel->id)->delete();
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