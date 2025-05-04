<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;

class BreakfastSheet implements FromArray, WithHeadings, WithTitle, ShouldAutoSize,WithStyles, WithEvents
{
    protected $breakfasts;


    public function __construct(array $breakfasts)
    {
        $this->breakfasts = $breakfasts;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        return $this->breakfasts;
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
        return 'Breakfasts';
    }
    public function styles(Worksheet $sheet) { }



    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {

                $event->sheet->getStyle('A1:H1')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'D3D3D3',
                        ],
                    ],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        ],
                    ],
                ]);



                    $sheet = $event->sheet->getDelegate();
                    $data = $this->breakfasts;
                    $rowCount = count($data) + 1; // +1 for heading row
                    $columnCount = count($this->headings());
                // Loop through all cells
                    for ($row = 2; $row <= $rowCount; $row++) {
                        for ($col = 1; $col <= $columnCount; $col++) {
                            $cell = $sheet->getCellByColumnAndRow($col, $row);
                            if ($cell->getValue() === 2) {
                                $coordinate = $cell->getCoordinate();
                                $sheet->getStyle($coordinate)->applyFromArray([
                                    'fill' => [
                                        'fillType' => Fill::FILL_SOLID,
                                        'startColor' => ['rgb' => 'FF0000'],
                                    ],
                                ]);
                            }
                        }
                    }




            },
        ];
    }
}



