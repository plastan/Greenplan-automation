<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MealPlan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MealPlan>
 */
class MealPlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = MealPlan::class;
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['muscle gain', 'weight loss', 'diabetic']),
            'breakfast' => $this->faker->boolean(),
            'lunch' => $this->faker->boolean(80), // 80% chance of being true
            'dinner' => $this->faker->boolean(80), // 80% chance of being true
            'restrictions_note' => $this->faker->optional(0.7)->text(100), // 70% chance of having a note
            'special_instruction' => $this->faker->optional(0.5)->sentence(),
            'veg_day' => $this->faker->randomElement(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', null]),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
