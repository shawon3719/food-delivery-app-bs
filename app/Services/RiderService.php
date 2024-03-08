<?php


namespace App\Services;

use App\Models\Restaurant;
use App\Models\Rider;
use App\Models\RiderLocation;
use Carbon\Carbon;

class RiderService
{

    public function createRider($data)
    {
        return Rider::create($data);
    }

    public function storeRiderLocation($data)
    {
        return RiderLocation::create($data);
    }

    public function getNearByRider($restaurantId): array
    {
        $data = [];
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $fiveMinutesBefore = Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s');
        $restaurant = Restaurant::find($restaurantId);

        // get all rider locations of last five minutes
        $ridersOfLastFiveMinutes = RiderLocation::where('capture_time', '<=', $now)
            ->where('capture_time', '>=', $fiveMinutesBefore)
            ->get();

        // group riders with their latest time
        $latestRiderLocations = $ridersOfLastFiveMinutes->groupBy('rider_id')->map(function ($group) {
            return $group->sortByDesc('capture_time')->first();
        });

        // calculate nearest rider
        $nearestRider = null;
        $currentDistance = PHP_INT_MAX;

        foreach ($latestRiderLocations as $rider) {

            // calculate distance of a rider
            $distance = $this->distanceCalculator($restaurant->lat, $rider->lat, $restaurant->long, $rider->long);

            if ($distance < $currentDistance) {
                $currentDistance = $distance;
                $nearestRider = $rider;
            }
        }

        if ($nearestRider) {
            $data['rider_name'] = $nearestRider->rider->name;
            $data['distance'] = $currentDistance;
        }

        return $data;
    }

    public function distanceCalculator($latRes, $latRider, $longRes, $longRider): float|int
    {
        $earthRadius = 6371000;

        // convert from degrees to radians
        $latFrom = deg2rad($latRes);
        $longFrom = deg2rad($longRes);
        $latTo = deg2rad($latRider);
        $longTo = deg2rad($longRider);

        $latDelta = $latTo - $latFrom;
        $longDelta = $longTo - $longFrom;

        // calculate angle
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($longDelta / 2), 2)));

        return $angle * $earthRadius;
    }
}
