<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerMealAssignments extends Model
{
    protected $fillable = [
        'customer_id',
        'menu_item_id',
        'meal_type',
        'delivery_date',
        'status',
        'special_instructions',
    ];
    protected  $casts = [
        'delivery_date' => 'date',
    ];
}
