<?php

namespace App\Services;


use App\Models\Delivery;
use App\Models\CustomerMealAssignments;

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



    public function get_monthly_data_all()
    {
        $data = [];

        return $data;
    }
}
