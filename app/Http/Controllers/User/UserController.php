<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;


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
}
