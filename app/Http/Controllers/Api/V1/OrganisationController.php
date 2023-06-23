<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\ShopResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Organisation;

class OrganisationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Organisation $organisation
     * @return JsonResponse
     */
    public function freeShops(Organisation $organisation) : JsonResponse
    {
        $shops = $organisation->shops()->enable()->whereDoesntHave('manager')->orderBy('name')->get();

        return response()->json(ShopResource::collection($shops));
    }
}
