<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Address;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected  $model = Address::class;
    public function definition(): array
    {
       return [
            'region' => $this->faker->randomElement(['North', 'South', 'East', 'West', 'Central']),
            'emirate' => $this->faker->randomElement(['Dubai', 'Abu Dhabi', 'Sharjah', 'Ajman', 'Fujairah', 'Ras Al Khaimah', 'Umm Al Quwain']),
            'area' => $this->faker->city() . ' ' . $this->faker->citySuffix(),
            'building' => $this->faker->randomElement(['Tower', 'Building', 'Plaza', 'Heights', 'Residence']) . ' ' . $this->faker->lastName(),
            'flat_number' => $this->faker->buildingNumber(),
            'floor' => (string)$this->faker->numberBetween(1, 50),
            'location_url' => $this->faker->optional(0.8)->url(), // 80% chance of having a URL
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
