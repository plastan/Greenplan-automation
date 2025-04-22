<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\MenuItems;
use Illuminate\Database\Seeder;
use App\Models\Customers;
use App\Models\MealPlan;
use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {






        $customers = Customers::factory(10)->create();

        for ($i = 0; $i < 10; $i++) {
            $mealPlans = MealPlan::factory(1)->create([
                'customer_id' => $customers[$i],
            ]);
            $addresses = Address::factory(1)->create([
                'customer_id' => $customers[$i]
            ]);
        }
        MenuItems::factory()->forPastMonth();





        $user1 = User::create([
            'name' => 'superAdmin',
            'email' => 'admin@super.com',
            'password' => Hash::make('12345'),
        ]);
        $user2  = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345'),
        ]);
        $chef_user = User::create([
            'name' => 'chef1',
            'email' => 'chef1@chef.com',
            'password' => Hash::make('12345'),
        ]);


        $role1 = Role::create(['name' => 'superAdmin']);
        $user1->assignrole($role1);
        $role2 = Role::create(['name' => 'admin']);
        $user2->assignrole($role2);
        $role_chef = Role::create(['name' => 'chef']);
        $chef_user->assignrole($role_chef);
    }
}
