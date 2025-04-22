<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Customers;
use App\Models\MenuItems;
use Carbon\Carbon;

use App\Models\CustomerMealAssignments;
use App\Models\Delivery;
use Illuminate\Support\Facades\DB;

class AssignDailyMeals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-daily-meals';
    // sanitize date

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    private function incrementCycleNumber($customer)
    {
        $customer->mealPlan->cycle_number = $customer->mealPlan->cycle_number + 1;
        $customer->mealPlan->save();
    }
    public function handle()
    {
        // $today = Carbon::now();
        $date = CustomerMealAssignments::query('meal_date')->max('meal_date');

        if ($date === null) {
            $date = Carbon::now();
        } else {
            $this->info("date is {$date}");
            $date = Carbon::parse($date);
        }


        $today = $date->copy()->addDay();

        $dayOfWeek = strtolower($today->format('l'));
        $customers = Customers::query()->where('subscription_status', '=', 'active')->get();
        // $this->info("Starting daily meal assignment for {$today->format('Y-m-d')} ({$dayOfWeek})");
        $this->info(" Today => {$today->format('Y-m-d')} ({$today})");





        // TODO:
        // GET Customers
        // CHECK SUBSCRIPTION STATUS
        // GET MEAL PLAN
        // CHECK MEAL PLAN TYPE
        // CHECK Skipping
        foreach ($customers as $customer) {

            $mealPlan = $customer->mealPlan;
            // $isVegDay = ($mealPlan->veg_day === $dayOfWeek);

            $menuItems = MenuItems::query()->where('dietary_type', $mealPlan->type)
                ->whereDate('meal_date', Carbon::today())
                ->get();

            $this->info("Found {$menuItems->count()} menu items for customer ID {$customer->id}");
            if ($menuItems->count() === 0) {
                // TODO: NOTIFY admin
                $this->warn("Customer ID {$customer->id} has no menu items for the current day. Skipping.");
                continue;
            }

            $breakfast = $menuItems->where('category', 'breakfast')->first();
            $lunch = $menuItems->where('category', 'lunch')->first();
            $dinner = $menuItems->where('category', 'dinner')->first();
            // check if exists
            $breakfast_assignment = null;
            $lunch_assignment = null;
            $dinner_assignment = null;
            try {
                if ($customer->mealPlan->breakfast) {
                    $breakfast_assignment =  CustomerMealAssignments::updateOrCreate([
                        'meal_date' => $today->format('Y-m-d'),
                        'customer_id' => $customer->id,
                        'menu_item_id' => $breakfast->id,
                        'delivery_status' => 'preparing',
                    ]);
                }
                if ($customer->mealPlan->lunch) {
                    $lunch_assignment = CustomerMealAssignments::updateOrCreate([
                        'meal_date' => $today->format('Y-m-d'),
                        'customer_id' => $customer->id,
                        'menu_item_id' => $lunch->id,
                        'delivery_status' => 'preparing',
                    ]);
                }
                if ($customer->mealPlan->dinner) {
                    $dinner_assignment = CustomerMealAssignments::updateOrCreate([
                        'meal_date' => $today->format('Y-m-d'),
                        'customer_id' => $customer->id,
                        'menu_item_id' => $dinner->id,
                        'delivery_status' => 'preparing',
                    ]);
                }
                $delivery =   Delivery::create([
                    'breakfast_assignment_id' => $breakfast_assignment ? $breakfast_assignment->id : null,
                    'lunch_assignment_id' => $lunch_assignment ? $lunch_assignment->id : null,
                    'dinner_assignment_id' => $dinner_assignment ? $dinner_assignment->id : null,
                    'icepacks_returned' => True,
                    'is_delivered' => False,
                    'delivery_time' => null,
                ]);
            } catch (\Exception $e) {

                dd($e);
                $this->warn("Error updating or creating assignment for customer ID {$customer->id}: {$e->getMessage()}");
            }

            DB::transaction(function () use ($customer) {
                $cycle_day = $customer->mealPlan->current_day;

                if ($cycle_day == 23) {
                    # TODO: NOTIFY admin
                    # TODO: SEND WHATSAPP NOTIFICATION
                    $this->warn("Customer ID {$customer->id} has reached the end of the cycle. ");
                }

                if ($cycle_day < 26) {

                    $cycle_day = $cycle_day + 1;
                } elseif ($cycle_day === 26) {

                    $cycle_day = 0;

                    $this->incrementCycleNumber($customer);

                    # TODO: NOTIFY admin
                }
                $customer->mealPlan->current_day = $cycle_day;
            });
        }
        return Command::SUCCESS;
    }
}
