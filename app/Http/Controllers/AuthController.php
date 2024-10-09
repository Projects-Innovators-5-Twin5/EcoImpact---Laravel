<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        // Valider la requête
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255', // Ajouter le champ 'name'
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed', // Ajout d'une règle de confirmation
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Créer l'utilisateur
        User::create([
            'name' => $request->name, // Inclure le nom
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirection avec message de succès
        return redirect()->route('login')->with('success', 'Inscription réussie. Veuillez vous connecter.');
    }

    public function login(){
        return View("Auth.login");
    }

    public function forgotPassword(){
        return View("Auth.forgotPassword");
    }

}
