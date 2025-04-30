<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MealPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'type',
        'breakfast',
        'lunch',
        'dinner',
        'cycle_number',
        'current_day',
        'restrictions_note',
        'special_instruction',
        'veg_day',
        'is_skiped',
        'skips_used',
    ];
    protected $casts = [
        'customer_id' => 'integer',
        'breakfast' => 'boolean',
        'lunch' => 'boolean',
        'dinner' => 'boolean',
        'is_skiped' => 'boolean',
        'skips_used' => 'integer',
    ];

    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }
}
