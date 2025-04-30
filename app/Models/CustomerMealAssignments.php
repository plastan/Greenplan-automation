<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class CustomerMealAssignments extends Model
{

    protected $fillable = [
        'customer_id',
        'menu_item_id',
        'delivery_status',
        'meal_date',
    ];

    protected $casts = [
        'meal_date' => 'date',
    ];


    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }

    public function menuItem()
    {
        return $this->belongsTo(MenuItems::class);
    }
    public function delivery()

    {

        if ($this->customer->mealplan->breakfast) {
            return $this->hasOne(Delivery::class, 'breakfast_assignment_id', 'id');
        }
        if ($this->customer->mealplan->lunch) {
            return $this->hasOne(Delivery::class, 'lunch_assignment_id', 'id');
        }
        if ($this->customer->mealplan->dinner) {
            return $this->hasOne(Delivery::class, 'dinner_assignment_id', 'id');
        }
    }
}
