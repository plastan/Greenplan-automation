<?php

namespace App\Imports;

use App\Models\MenuItems;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
class MenuItemImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $week_start = Carbon::parse($row['meal_date'])->startofweek();
        if ($row['dish_name'] == null) {
            return null;
        }
        return new MenuItems([
            'week_start_date' => $week_start,
            'meal_date' => $row['meal_date'],
            'name' => $row['dish_name'],
            'description' => $row['dish_discription'],
            'category' => $row['meal_type'],
            'dietary_type' => $row['meal_plan'],
            'calories' => $row['cal'],
            'fat' => $row['fat'],
            'carbs' => $row['carb'],
            'protein' => $row['prot']
        ]);
    }
}
