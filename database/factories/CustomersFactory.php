<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customers;
use App\Models\MealPlan;
use App\Models\Address;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CustomersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Customers::class;

    public function definition(): array
    {
        $cycleStartDate = $this->faker->dateTimeBetween('-6 months', '+1 month');
        $firstCycleDate = $this->faker->dateTimeBetween('-1 year', $cycleStartDate);
        return [
            'name' => $this->faker->name(),
            'wa_number' => $this->faker->phoneNumber(),
            'subscription_status' => $this->faker->randomElement(['active', 'inactive']),
            'age' => $this->faker->numberBetween(18, 100),
            'email' => $this->faker->unique()->safeEmail(),
            'weight' => $this->faker->numberBetween(50, 200),
            'height' => $this->faker->numberBetween(150, 250),
            'cycle' => $this->faker->numberBetween(1, 10),
            'cycle_start_date' => $cycleStartDate,
            'first_cycle_date' => $firstCycleDate,
            //
        ];
    }
}
