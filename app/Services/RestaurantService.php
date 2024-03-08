<?php

namespace App\Services;

use App\Models\Restaurant;

class RestaurantService
{
    public function createRestaurant($data) {
        return Restaurant::create($data);
    }
}