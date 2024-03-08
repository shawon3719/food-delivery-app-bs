<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiderLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'rider_id',
        'service_name',
        'lat',
        'long',
        'capture_time',
    ];

    public function rider(): BelongsTo
    {
        return $this->belongsTo(Rider::class, 'rider_id');
    }
}
