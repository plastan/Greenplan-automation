<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'breakfast_assignment_id',
        'lunch_assignment_id',
        'dinner_assignment_id',
        'icepacks_returned',
        'meal_date',
        'special_note',
        'is_delivered',
        'delivery_time',
    ];
    protected $casts = [
        'meal_date' => 'date',
        'delivery_time' => 'date',
    ];

    public function breakfast()
    {
        return $this->belongsTo(CustomerMealAssignments::class, 'breakfast_assignment_id');
    }
    public function lunch()
    {
        return $this->belongsTo(CustomerMealAssignments::class, 'lunch_assignment_id');
    }
    public function dinner()
    {
        return $this->belongsTo(CustomerMealAssignments::class, 'dinner_assignment_id');
    }
    public function get_customer()
    {
        if ($this->breakfast) {
            return $this->breakfast->customer;
        }
        if ($this->lunch) {
            return $this->lunch->customer;
        }
        if ($this->dinner) {
            return $this->dinner->customer;
        }
    }
}
