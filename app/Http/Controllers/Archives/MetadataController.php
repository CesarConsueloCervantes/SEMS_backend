<?php

namespace App\Http\Controllers\Archives;

use App\Http\Controllers\Controller;
use App\Repositories\Archives\MetadataRepositorie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
     * @return JsonResponse
     */
    public function indexByUser(): JsonResponse
    {
        /** @var \App\Models\User\User $user */
        $user = Auth::user();

        $first = request('first', false);
        $rows = request('rows', false);
        $orderBy = request('orderBy', false);
        $ascending = request('ascending', '1');
        $filters = json_decode(request('filters', '{}'), true);
        $columns = request()->has('columns') ? json_decode(request('columns')) : array_keys($filters);

        $result = $this->repository->index($first, $rows, $orderBy, $ascending, $filters, $columns, $user->metadata());

        return response()->json($result, Response::HTTP_OK);
    }

    public function filtersOptions(): JsonResponse
    {
        /** @var \App\Models\User\User $user */
        $user = Auth::user();

        $filters = $this->repository->getFiltersoptions($user->metadata);

        return response()->json($filters, Response::HTTP_OK);
    }
}
