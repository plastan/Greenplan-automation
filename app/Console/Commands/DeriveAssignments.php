<?php

namespace App\Console\Commands;

use App\Models\CustomerMealAssignments;
use Illuminate\Console\Command;
use Carbon\Carbon;

class DeriveAssignments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'derive:assignements';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $dailyMealAssignments = CustomerMealAssignments::query()->where("meal_date", "=", Carbon::today()->addDay())->get();
        $breakfastes = [];
        $lunches = [];
        $dinners = [];


        foreach ($dailyMealAssignments as $mealAssignment) {

            $customer_id = $mealAssignment->customer_id;
            $meal_date = $mealAssignment->meal_date;
            $dish_name = $mealAssignment->menuItem->name;
            $dish_description = $mealAssignment->menuItem->description;
            $dish_category = $mealAssignment->menuItem->category;
            $dish_calories = $mealAssignment->menuItem->calories;
            $dish_fat = $mealAssignment->menuItem->fat;
            $dish_carbs = $mealAssignment->menuItem->carbs;
            $dish_protein = $mealAssignment->menuItem->protein;

            $item = [
                'customer_id' => $customer_id,
                'meal_date' => $meal_date,
                'dish_category' => $dish_category,
                'dish_name' => $dish_name,
                'dish_description' => $dish_description,
                'dish_calories' => $dish_calories,
                'dish_fat' => $dish_fat,
                'dish_carbs' => $dish_carbs,
                'dish_protein' => $dish_protein,
            ];
            if ($mealAssignment->menuItem->category === 'breakfast') {
                $breakfastes[] = $item;
            } elseif ($mealAssignment->menuItem->category === 'lunch') {
                $lunches[] = $item;
            } elseif ($mealAssignment->menuItem->category === 'dinner') {
                $dinners[] = $item;
            }
        }
        dd($breakfastes, $lunches, $dinners);
        $this->info("Breakfasts:");
        $this->info(json_encode($breakfastes));
        $this->info("Lunches:");
        $this->info(json_encode($lunches));
        $this->info("Dinners:");
        $this->info(json_encode($dinners));
    }
}
