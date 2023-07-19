<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\StateResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\State;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $states = State::with('country')->orderBy('name')->get();

        return response()->json(StateResource::collection($states));

    }
}
