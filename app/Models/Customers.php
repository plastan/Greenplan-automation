<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customers extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'wa_number',
        'meal_plan_id',
        'address_id',
        'subscription_status',
        'age',
        'email',
        'weight',
        'height',
        'cycle',
        'cycle_start_date',
        'first_cycle_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'cycle_start_date' => 'date',
        'first_cycle_date' => 'date',
        'weight' => 'float',
        'height' => 'float',
        'age' => 'integer',
    ];

    /**
     * Get the meal plan that owns the customer.
     */
    public function mealPlan(): BelongsTo
    {
        return $this->belongsTo(MealPlan::class);
    }

    /**
     * Get the address that owns the customer.
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
}
