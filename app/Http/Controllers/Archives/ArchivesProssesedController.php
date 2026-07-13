<?php

namespace App\Http\Controllers\Archives;

use App\Http\Controllers\Controller;
use App\Http\Requests\Archives\ArchivesProssesedRequest;
use App\Models\Archives\ArchivesProssesed\ArchivesProssesed;
use App\Repositories\Archives\ArchivesProssesedRepositorie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArchivesProssesedController extends Controller
{
    private ArchivesProssesedRepositorie $repository;

    public function __construct(ArchivesProssesedRepositorie $repository)
    {
        $this->repository = $repository;
    }

    public function index(): JsonResponse
    {

        return response()->json();
    }

    public function show(): JsonResponse
    {

        return response()->json();
    }

    public function store(ArchivesProssesedRequest $request)
    {
        
        return $this->repository->createArchiveProssesed($request->validated());
    }

    public function update(): JsonResponse
    {

        return response()->json();
    }

    public function delete(): JsonResponse
    {

        return response()->json();
    }

    public function consultHashAndNameExists(Request $request): JsonResponse
    {
        $validate = $request->validate([
            'hash' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        $hash_exists = ArchivesProssesed::hashExists($validate["hash"]);
        $name_exists = ArchivesProssesed::nameExists($validate["name"]);

        $message = $hash_exists==true? "El archivo ya existe en la Base de datos": "Archivo valido";
        $new_name = $name_exists==true? "Se cambio el nombre a '". $validate["name"]."-". now()->format("d-m-y")."'": false;
        
        return response()->json([
            "message" => $message,
            "hash" => $hash_exists,
            "name" => $name_exists,
            "new_name" => $new_name
        ], Response::HTTP_OK);
    }
}
