<?php

namespace App\Http\Controllers;

use App\Models\Archives\ArchivesProssesed\ArchivesProssesed;
use App\Repositories\Archives\ArchivesProssesedRepositorie;
use Illuminate\Http\JsonResponse;

class ArchivesProssesedController extends Controller
{
    private ArchivesProssesedRepositorie $repository;

    public function __construct(ArchivesProssesedRepositorie $repository)
    {
        $this->$repository = $repository;
    }

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
