<?php

namespace App\Http\Controllers\API\V1;

use App\Data\StatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRestaurantRequest;
use App\Services\RestaurantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RestaurantController extends Controller
{
    public function __construct(private readonly RestaurantService $restaurantService)
    {
        //
    }

    /**
     * Store a newly created restaurant in database.
     */
    public function store(StoreRestaurantRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $req = $request->validated();
            $restaurant = $this->restaurantService->createRestaurant($req);

            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $restaurant,
                'message' => 'Restaurant has been added successfully!'
            ])->setStatusCode(StatusCode::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'issue' => $e->getMessage(),
                'message' => 'Something went wrong!'
            ])->setStatusCode(StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
