<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\OrganisationResource;
use App\Http\Resources\ShopResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Organisation;
use Illuminate\Http\Request;

class OrganisationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        $q = $request->query('q');

        $organisations = Organisation::free($q)->orderBy('name')->get();

        return response()->json(OrganisationResource::collection($organisations));
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Organisation $organisation
     * @return JsonResponse
     */
    public function shops(Request $request, Organisation $organisation) : JsonResponse
    {
        $q = $request->query('q');

        $shops = $organisation->shops()->free($q)->orderBy('name')->get();

        return response()->json(ShopResource::collection($shops));
    }
}
