<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Customers;
use App\Models\MenuItems;
use Carbon\Carbon;

use App\Models\CustomerMealAssignments;



class AssignDailyMeals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-daily-meals';

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
        $today = Carbon::now();
        $dayOfWeek = strtolower($today->format('l'));

        $customers = Customers::query()->where('subscription_status', '=', 'active')->get();

        $this->info("Starting daily meal assignment for {$today->format('Y-m-d')} ({$dayOfWeek})");





        // TODO:
        // GET Customers
        // CHECK SUBSCRIPTION STATUS
        // GET MEAL PLAN
        // CHECK MEAL PLAN TYPE
        // CHECK Skipping

        foreach ($customers as $customer) {
            $mealPlan = $customer->mealPlan;

            if (!$mealPlan) {
                $this->warn("Customer ID {$customer->id} has no meal plan assigned. Skipping.");
                continue;
            }

            // $isVegDay = ($mealPlan->veg_day === $dayOfWeek);
            //

            $menuItems = MenuItems::query()->where('dietary_type', $mealPlan->type)
                ->whereDate('created_at', Carbon::today())
                ->get();
            $this->info("Found {$menuItems->count()} menu items for customer ID {$customer->id}");

            $selectedItem = $menuItems->random();

            CustomerMealAssignments::create([
                'customer_id' => $customer->id,
                'menu_item_id' => $selectedItem->id,
                'delivery_status' => 'delivered',
            ]);
        }
        return Command::SUCCESS;
    }
}
