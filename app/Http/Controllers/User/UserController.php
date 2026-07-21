<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\OauthLoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(): JsonResponse
    {

        return response()->json();
    }

    public function show(): JsonResponse
    {

        return response()->json();
    }

    public function store()
    {

        return;
    }

    public function update(): JsonResponse
    {

        return response()->json();
    }

    public function delete(): JsonResponse
    {

        return response()->json();
    }

    /**
     * Authenticate the user and generate an access token.
     * 
     * @param OauthLoginRequest $request
     * @return JsonResponse
     */
    public function oauthLogin(OauthLoginRequest $request): JsonResponse
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Las credenciales no coinciden con nuestros registros.'
            ], 422);
        }

        /** @var \App\Models\User\User $user */
        $user = Auth::user();

        $user->tokens()->update([
            'revoked' => true,
        ]);

        return response()->json(
            $user->login()
        );
    }

    /**
     * Register a new user, store in the database, and return an access token.
     * 
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        // Crea el nuevo registro del usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Retorna la respuesta de inicio de sesión con el token de acceso
        return response()->json($user->login(), Response::HTTP_CREATED);
    }
}
