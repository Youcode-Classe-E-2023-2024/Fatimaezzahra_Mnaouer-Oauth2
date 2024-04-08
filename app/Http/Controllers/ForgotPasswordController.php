<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Traits\HttpResponses as Resp;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        {
            return response()->json([
                'message' => 'check email'
            ], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */

//appelle la méthode sendResetLink de la classe Password, qui fournissent des fonctionnalités de la gestion des mots
// de passe. La méthode sendResetLink est utilisée pour envoyer un lien de réinitialisation de mot de passe à
// l'utilisateur dont l'adresse e-mail est spécifiée dans la requête $request.

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );
// retourn la reponse en fonction de $status si le lien est envoyé va retourné au page precedent
// sinon va retourne la page precedent avec erreur

        return $status === Password::RESET_LINK_SENT
            ? $this->success($status, 'reset link sent')
            : $this->error($status, 'reset link not sent', 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $token)
    {
//a discuter si je dois le faire si ui indiquer la route parce que j'ai deja mis une route get avec index qui affiche check email
//        $email = $request->get('email');
//        return view('auth.reset', compact('token', 'email'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|confirmed|min:8',
        ]);
//fonction de rappel (callback) $user qui représente l'utilisateur dont le mot de passe est réinitialisé
        //$request pour accéder aux données de la demande HTTP
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                //réinitialisation de mot de passe pour un utilisateur spécifique en utilisant les données fournies dans la demande HTTP,
                // puis sauvegarde les modifications apportées à l'utilisateur dans la base de données.
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60)
                ])->save();
            }
        );
        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withInput($request->only('email'))->withErrors(['email' => __($status)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
