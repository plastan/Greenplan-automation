<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
class MealPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'breakfast',
        'lunch',
        'dinner',
        'restrictions_note',
        'special_instruction',
        'veg_day',
    ];
    protected $casts = [
        'breakfast' => 'boolean',
        'lunch' => 'boolean',
        'dinner' => 'boolean',
    ];

    public function customers(): HasOne{
        return $this->hasOne(Customers::class);
    }
}
