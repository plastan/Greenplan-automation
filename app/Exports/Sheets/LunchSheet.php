<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LunchSheet implements FromArray, WithHeadings, WithTitle, ShouldAutoSize


{
    protected $lunches;

    public function __construct(array $lunches)
    {
        $this->lunches = $lunches;
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A')->getFont()->setBold(true);
    }
    /**
     * @return array
     */
    public function array(): array
    {
        return $this->lunches;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Customer id',
            'Name',
            'Meal',
            'dish_calories',
            'dish_protein',
            'dish_carbs',
            'dish_fat',
            'meal_date',
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Lunches';
    }
}
