<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Services\CustomerService;
use Carbon\Carbon;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
class MonthlyChartExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles,withEvents
{
    protected array $data;
    protected $date;

    public function __construct()
    {
    }

    public function array(): array{

        $this->data = (new CustomerService())->get_monthly_data_all(Carbon::today());

    return array_map(function ($row) {
                return array_map(function ($cell) {
                    return is_array($cell) ? $cell['cycle'] : $cell;
                }, $row);
            }, $this->data);
    }



public function headings(): array
    {
        // Creating the header row with SNO, CLIENT NAME, and day numbers 1-31
        $headers = ['SNO', 'CLIENT NAME'];

        // Add numbers 1 through 31 for days of the month
        if ($this->date) {
            $end_date = Carbon::parse($this->date)->daysInMonth;
        } else {
            $end_date = Carbon::today()->daysInMonth;
        }


        for ($i = 1; $i <= $end_date; $i++) {
            $headers[] = (string) $i;
        }

        // Add total_days at the end
        $headers[] = 'total_days';

        return $headers;
    }
public function styles(Worksheet $sheet){}

 public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {

                $event->sheet->getStyle('A1:AH1')->applyFromArray([
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

                $sheet->getStyle('A1:AH11')->applyFromArray([

                        'borders' => [
                            'outline' => [
                                'borderStyle' => Border::BORDER_THICK,
                            ],
                        ],
                    ]);

                $data = $this->data;
                $rowCount = count($data) + 1; // +1 for heading row
                $columnCount = count($this->headings());
            // Loop through all cells
                for ($row = 2; $row <= $rowCount; $row++) {
                    for ($col = 1; $col <= $columnCount; $col++) {
                        $cell = $sheet->getCellByColumnAndRow($col, $row);
                        if ($cell->getValue() === 'A') {

                            $coordinate = $cell->getCoordinate();
                            $sheet->getStyle($coordinate)->applyFromArray([
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'startColor' => ['rgb' => 'FF0000'],
                                ],
                            ]);
                        }
                        if (is_numeric($cell->getValue())) {
                            $coordinate = $cell->getCoordinate();
                            $sheet->getStyle($coordinate)->applyFromArray([
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'startColor' => ['rgb' => '90EE90'],
                                ],
                            ]);
                        }
                    }
                }




            },
        ];
    }


}
