<?php

namespace App\Http\Controllers\API\V1;

use App\Data\StatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRiderLocationRequest;
use App\Http\Requests\StoreRiderRequest;
use App\Services\RiderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RiderController extends Controller
{
    public function __construct(private readonly RiderService $riderService)
    {
        //
    }

    /**
     * Store the specified resource in database.
     */
    public function store(StoreRiderRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $req = $request->validated();
            $rider = $this->riderService->createRider($req);

            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $rider,
                'message' => 'Rider has been added successfully!'
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

    /**
     * Store a rider location data in database.
     */
    public function storeRiderLocation(StoreRiderLocationRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $req = $request->validated();
            $rider = $this->riderService->storeRiderLocation($req);

            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $rider,
                'message' => 'Current location info has been added successfully against the rider!'
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

    /**
     * Get nearby rider.
     */
    public function getNearbyRider($restaurantId): JsonResponse
    {
        try {
            $nearbyRider = $this->riderService->getNearByRider($restaurantId);

            return response()->json([
                'success' => true,
                'data' => $nearbyRider,
                'message' => 'Nearby rider has been selected!'
            ])->setStatusCode(StatusCode::HTTP_OK);
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
