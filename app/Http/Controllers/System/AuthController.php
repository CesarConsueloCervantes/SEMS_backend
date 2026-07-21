<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\OauthLoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
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
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(
            $user->login(),
            Response::HTTP_CREATED
        );
    }

    /**
     * Revoke token and logout user.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Sesión cerrada correctamente.'
        ]);
    }
}
