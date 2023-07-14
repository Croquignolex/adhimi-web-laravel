<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\ShopResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Shop;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        $free = $request->query('free');

        $shops = Shop::free($free)->orderBy('name')->get();

        return response()->json(ShopResource::collection($shops));
    }
}
