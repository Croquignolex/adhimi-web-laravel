<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\CountryResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Country;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $countries = Country::orderBy('name')->get();

        return response()->json(CountryResource::collection($countries));
    }
}
