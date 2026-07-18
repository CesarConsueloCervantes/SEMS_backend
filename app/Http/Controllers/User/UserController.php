<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\OauthLoginRequest;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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
        $user = User::query()
            ->where('email', $request->email)
            ->first();

        return response()->json($user->login(), Response::HTTP_OK);
    }
}
