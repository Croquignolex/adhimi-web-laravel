<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\GroupResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Group;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $groups = Group::orderBy('name')->get();

        return response()->json(GroupResource::collection($groups));
    }
}
