<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function locations(): HasMany
    {
        return $this->hasMany(RiderLocation::class, 'rider_id');
    }
}
