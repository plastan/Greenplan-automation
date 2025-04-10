<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Address extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'region',
        'emirate',
        'area',
        'building',
        'flat_number',
        'floor',
        'location_url',
    ];

    /**
     * Get the customers for the address.
     */
    public function customers():HasOne
    {
        return $this->hasOne(Customer::class);

    }
}
