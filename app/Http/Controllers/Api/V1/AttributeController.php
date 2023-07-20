<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\AttributeResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Attribute;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $groups = Attribute::orderBy('name')->get();

        return response()->json(AttributeResource::collection($groups));
    }
}
