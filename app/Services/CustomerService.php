<?php

namespace App\Services;


use App\Models\Delivery;
use App\Models\CustomerMealAssignments;
use App\Models\Customers;
use Carbon\Carbon;

class CustomerService
{

    public function get_monthly_data(int $customer_id)
    {
        $heatmap_data = [];
        $assignments = CustomerMealAssignments::select()->where('customer_id', $customer_id)->get();



        // dd($assignments);
        foreach ($assignments as $assignment) {
            $delivery = $assignment->delivery;
            if ($delivery) {
                $heatmap_data[] = ["date" => $delivery->meal_date->format('Y-m-d'), 'value' => $delivery->is_delivered ? 1 : 0];
            }
        }
        return $heatmap_data;
    }



    public function get_monthly_data_all( $date=null)
    {
        $month =  Carbon::parse($date);
        if ($month == null) {
            $month = Carbon::now();
        }
        $data = [];
        if ($date == null) {

        }
        $customeres = Customers::query()->orderBy('id','asc')->get();


       $startDate = $month->firstOfMonth()->todate('Y-m-d');
        $endDate = $month->endOfMonth();

        foreach ($customeres as $customer) {
            $monthDates = array();
            $assignments = CustomerMealAssignments::query()->where('customer_id', $customer->id)->whereMonth('meal_date',$month)->get();

            for ($date =Carbon::parse($startDate)->copy(); $date->lte($endDate); $date->addDay()) {
                $monthDates[$date->format('Y-m-d')] = 'A';
            }

            foreach ($assignments as $assignment) {
                // $formattedDate = $assignment->meal_date;

                if (isset($assignment->delivery)){

                    $monthDates[$assignment->meal_date->format('Y-m-d')] = [
                        'value'=>$assignment->delivery->is_delivered ? 'G': 'A',
                        'cycle'=>$assignment->delivery->current_day,
                    ];
                }
            }
            // convert asoociative array to array
            // $monthDates = array_values($monthDates);


            $data[] = [
                 $customer->id,
                 $customer->name,
                ...$monthDates
            ];

        }
        // format = [ cusomter_id, name, status of day1, day2, ...... day 31?]


        return $data;
    }
}
