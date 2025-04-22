<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class CustomerMealAssignments extends Model
{

    protected $fillable = [
        'meal_date',
        'customer_id',
        'menu_item_id',
        'delivery_status',
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
        return $this->hasOne(Delivery::class);
    }
}
