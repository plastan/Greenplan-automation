<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\MenuItems;
use Illuminate\Database\Seeder;
use App\Models\Customers;
use App\Models\MealPlan;
use App\Models\Address;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $mealPlans = MealPlan::factory(10)->create();
        $addresses = Address::factory(10)->create();
        for ($i = 0; $i < 10; $i++) {
            Customers::factory()->create([
                'meal_plan_id' => $mealPlans[$i]->id,
                'address_id' => $addresses[$i]->id,
            ]);
        }

        $menuItems = MenuItems::factory(300)->create();
    }
}
