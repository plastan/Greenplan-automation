<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DinnerSheet implements FromArray, WithHeadings, WithTitle, ShouldAutoSize
{
    protected $dinners;
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('1')->getFont()->setBold(true);
    }
    public function __construct(array $dinners)
    {
        $this->dinners = $dinners;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        return $this->dinners;
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
        return 'Dinners';
    }
}
