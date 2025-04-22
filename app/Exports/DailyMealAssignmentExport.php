<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Exports\Sheets\BreakfastSheet;
use App\Exports\Sheets\LunchSheet;
use App\Exports\Sheets\DinnerSheet;
use App\Exports\Sheets\HeadCountSheet;
use App\Models\CustomerMealAssignments;
use Carbon\Carbon;
use Filament\Notifications\Notification;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DailyMealAssignmentExport implements WithMultipleSheets, ShouldAutoSize, WithStyles
{
    use Exportable;

    protected $mealAssignments;

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('1')->getFont()->setBold(true);
    }
    public function __construct($date = null)
    {

        if ($date == null) {
            $this->mealAssignments = CustomerMealAssignments::query()->where("meal_date", "=", Carbon::tomorrow())->get();
        } else {
            $this->mealAssignments = CustomerMealAssignments::query()->where("meal_date", "=", $date)->get();
        }
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        if ($this->mealAssignments->isEmpty()) {
            Notification::make()
                ->title('No meal assignments found')
                ->icon('heroicon-o-exclamation-circle')
                ->send();
            return [];
        }
        $breakfasts = [];
        $lunches = [];
        $dinners = [];
        $users_receiving_meals = $this->mealAssignments->pluck('customer_id')->unique();
        // dd($users_receiving_meals);
        $diabetic_meal_count = $this->mealAssignments->where('menuItem.dietary_type', 'diabetic')->count();
        $muscle_gain_meal_count = $this->mealAssignments->where('MenuItem.dietary_type', 'muscle gain')->count();
        $weight_loss_meal_count = $this->mealAssignments->where('MenuItem.dietary_type', 'weight loss')->count();
        $headCounts = [[
            'date' => $this->mealAssignments->first()->meal_date,
            'weight_loss' => $weight_loss_meal_count,
            'muscle_gain' => $muscle_gain_meal_count,
            'diabetic' => $diabetic_meal_count,
        ]];


        $special_instructions = [];

        foreach ($this->mealAssignments as $mealAssignment) {

            $item = [
                'Customer id' => $mealAssignment->customer_id,
                'Name' => $mealAssignment->customer->name,
                'Meal' => $mealAssignment->menuItem->dietary_type,
                // 'Dish Name' => $mealAssignment->menuItem->name,
                'dish_calories' => $mealAssignment->menuItem->calories,
                'dish_protein' => $mealAssignment->menuItem->protein,
                'dish_carbs' => $mealAssignment->menuItem->carbs,
                'dish_fat' => $mealAssignment->menuItem->fat,
                'meal_date' => $mealAssignment->meal_date,
            ];

            $special_instructions[$mealAssignment->customer->name] = $mealAssignment->customer->mealPlan->restrictions_note;

            if ($mealAssignment->menuItem->category === 'breakfast') {
                $breakfasts[] = $item;
            } elseif ($mealAssignment->menuItem->category === 'lunch') {
                $lunches[] = $item;
            } elseif ($mealAssignment->menuItem->category === 'dinner') {
                $dinners[] = $item;
            }
        }

        $normalized_special_instructions = array_map(
            function ($key, $value) {
                return array($key, $value);
            },
            array_keys($special_instructions),
            $special_instructions
        );
        $spaces_row = array_fill(0, 8, " ");

        // Insert it at the 0th index
        array_unshift($normalized_special_instructions, $spaces_row);
        return [
            new BreakfastSheet($breakfasts),
            new LunchSheet($lunches),
            new DinnerSheet($dinners),
            new HeadCountSheet($headCounts + $normalized_special_instructions),

        ];
    }
}
