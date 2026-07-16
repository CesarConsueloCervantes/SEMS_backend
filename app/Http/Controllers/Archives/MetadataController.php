<?php

namespace App\Http\Controllers;

use App\Models\User\User;
use Illuminate\Http\JsonResponse;

class MetadataController extends Controller
{
    public function indexByUser(User $user): JsonResponse
    {

        return response()->json();
    }
}
