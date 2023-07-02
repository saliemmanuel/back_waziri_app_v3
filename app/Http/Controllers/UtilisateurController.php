<?php

namespace App\Http\Controllers;

use App\Models\CodeAdministrationModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;
use Illuminate\Validation\ValidationException;

class UtilisateurController extends Controller
{

    public function index()
    {
        $utilisateur = User::all();
        if (!isNull($utilisateur))
            return response()->json(['response' => 'Aucun Utilisateur disponible', 'error' => '1'], 400);
        return response()->json(['utilisateur' => $utilisateur, 'error' => '0'], 200);
    }


    public function store(Request $request)
    {
        $rules = [
            'nom_utilisateur' => 'string|required',
            'prenom_utilisateur' => 'string|required',
            'email' => 'string|required',
            'password' => 'string|required',
            'telephone_utilisateur' => 'string|required',
            'role_utilisateur' => 'string|required',
            'zone_utilisateur' => 'string|required',
            'id_utilisateur_initiateur' => 'string|required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $utilisateurModel = User::create(
                [
                    'nom_utilisateur' => $request->nom_utilisateur,
                    'prenom_utilisateur' => $request->prenom_utilisateur,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'telephone_utilisateur' => $request->telephone_utilisateur,
                    'role_utilisateur' => $request->role_utilisateur,
                    'zone_utilisateur' => $request->zone_utilisateur,
                    'id_utilisateur_initiateur' => $request->id_utilisateur_initiateur
                ]
            );
            // initialisation du code administration par défaut
            CodeAdministrationModel::create(
                [
                    'code_admin' => Hash::make("000000"),
                    'remember_code_admin' => "000000",
                    'id_admin' => $utilisateurModel->id
                ]
            );

            return response()->json(['message' => 'Utilisateur créer avec succes', 'utilisateur' => $utilisateurModel], 200);
        } catch (\Throwable $th) {
            return response()->json(['response' => "E-mail déjà utiliser.", 'error' => '1'], 400);
        }
    }


    public function show($id)
    {
        $utilisateur = User::find($id);
        if (is_null($utilisateur))
            return response()->json(['message' => 'Utilisateur non disponible', 'error' => '1'], 400);
        return response()->json(['Utilisateur' => $utilisateur, 'error' => '1']);
    }



    public function update(Request $request)
    {
        $Utilisateur = User::find($request->id);
        if (is_null($Utilisateur))
            return response()->json(['message' => 'Utilisateur non disponible ', 'error' => '1'], 400);
        $rules = [
            'nom_utilisateur' => 'string|required',
            'prenom_utilisateur' => 'string|required',
            'email' => 'string|required',
            'telephone_utilisateur' => 'string|required',
            'role_utilisateur' => 'string|required',
            'zone_utilisateur' => 'string|required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json(['message' => 'erreur 400', 'error' => '1'], 400);
        $Utilisateur->update($request->all());

        return response()->json(['Utilisateur' => $Utilisateur, 'message' => 'Modification effectuée', 'error' => '0'], 200);
    }


    public function destroy(Request $request)
    {

        $user = DB::table('users')->where([
            'id' => $request->id,
            'email' => $request->email
        ])->get()->first();
        try {
            if ($user != null) {
                $data = User::find($user->id)->delete();
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

    public function connexion(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'E-mail ou mots de passe incorrect.'
            ], 400);
        }
        return response()->json([
            "message" => "Connexion effectuée",
            "token" => $user->createToken($request->device_name)->plainTextToken
        ], 200);
    }

    public function deconnexion(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json(["message" => "Déconnexion effectuée"]);
    }

    public function dataUser(Request $request)
    {
        return $request->user();
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'new_password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Ancient mots de passe incorrect.'], 202);
        }
        $user->update(['password' => bcrypt($request->new_password)]);
        return response()->json(['Utilisateur' => $user, 'message' => 'Modification effectuée', 'error' => '0'], 200);
    }


}