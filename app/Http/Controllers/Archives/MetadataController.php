<?php

namespace App\Http\Controllers\Archives;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Repositories\Archives\MetadataRepositorie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class MetadataController extends Controller
{
    private MetadataRepositorie $repository;

    public function __construct(MetadataRepositorie $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of all metadata records belonging to the specified user,
     * ordered and filtered using the generic repository index method.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function indexByUser(User $user): JsonResponse
    {
        $first = request('first', false);
        $rows = request('rows', false);
        $orderBy = request('orderBy', false);
        $ascending = request('ascending', '1');
        $filters = json_decode(request('filters', '{}'), true);
        $columns = request()->has('columns') ? json_decode(request('columns')) : array_keys($filters);

        $result = $this->repository->index($first, $rows, $orderBy, $ascending, $filters, $columns, $user->metadata());

        return response()->json($result, Response::HTTP_OK);
    }
}
