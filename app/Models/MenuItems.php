<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItems extends Model
{
    use HasFactory;
    protected $fillable = [
        'week_start_date',
        'meal_date',
        'name',
        'description',
        'category',
        'dietary_type',
        'calories',
        'fat',
        'carbs',
        'protein',
    ];
    protected $casts = [
        'week_start_date' => 'date',
        'meal_date' => 'date',
        'calories' => 'float',
        'fat' => 'float',
        'carbs' => 'float',
        'protein' => 'float',
    ];

    public function customers(): HasMany
    {
        return $this->hasMany(Customers::class);
    }

    public function mealPlan(): HasMany
    {
        return $this->hasMany(MealPlan::class);
    }
    //
}
