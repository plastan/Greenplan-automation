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
        'special_note',
        'is_delivered',
        'delivery_time',
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
}
