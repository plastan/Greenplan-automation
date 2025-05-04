<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use App\Models\MenuItems;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MenuItemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = MenuItems::class;
    public function definition(): array
    {
        $randomDate = $this->faker->dateTimeBetween('-1 months', '1 week');
        $carbonDate = Carbon::instance($randomDate);
        $weekStartDate = $carbonDate->previous(Carbon::MONDAY);
        if ($carbonDate->dayOfWeek === Carbon::MONDAY) {
            $weekStartDate = $carbonDate;
        }

        $dishNames = [
            'Butter Chicken',
            'Paneer Tikka Masala',
            'Veg Biryani',
            'Chicken Shawarma',
            'Beef Stroganoff',
            'Tofu Stir Fry',
            'Spaghetti Bolognese',
            'Sushi Platter',
        ];

        $descriptions = [
            'A rich and creamy tomato-based curry with tender chicken.',
            'Grilled paneer cubes simmered in spiced gravy.',
            'Aromatic rice cooked with seasonal vegetables and spices.',
            'Grilled chicken wrapped in pita with garlic sauce.',
            'Classic Russian dish with mushrooms and sour cream.',
            'Crispy tofu and vegetables in a savoury soy sauce.',
            'Traditional Italian pasta with a hearty meat sauce.',
            'Assorted fresh sushi rolls with wasabi and soy sauce.',
        ];
        $index = $this->faker->numberBetween(0, count($dishNames) - 1);
        $daysToAdd = rand(-1, 6); // 0 = Monday, 6 = Sunday
        $randomDayInWeek = $weekStartDate->copy()->addDays($daysToAdd);

        return [
            "week_start_date" => $weekStartDate,
            // "meal_date" => $randomDayInWeek,
            "name" => $dishNames[$index],
            "description" => $descriptions[$index],
            // "dietary_type" => $this->faker->randomElement(['diabetic', 'muscle gain', 'weight loss']),
            "calories" => $this->faker->numberBetween(100, 500),
            "fat" => $this->faker->numberBetween(10, 50),
            "carbs" => $this->faker->numberBetween(10, 50),
            "protein" => $this->faker->numberBetween(10, 50),
        ];
    }

    public function forPastMonth(): void
    {

        $categories = ['breakfast', 'lunch', 'dinner'];
        $dietaryTypes = ["regular","diabetic", "muscle_gain", "weight_loss",'veg'];
        $today = Carbon::today()->copy()->addDay(20);
        $startDate = Carbon::today();

        // Loop through each day in the past month
        for ($date = $startDate; $date->lte($today); $date = $date->copy()->addDay()) {
            if ($date->dayOfWeek === Carbon::SUNDAY) {
                continue;
            }
            // Create one menu item for each category on this date
            foreach ($categories as $category) {
                foreach ($dietaryTypes as $dietaryType) {
                    $this->model::factory()->create([
                        'category' => $category,
                        'dietary_type' => $dietaryType,
                        'meal_date' => $date,
                    ]);
                }
            }
        }
    }
}
