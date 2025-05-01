<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $data;

    public $date;
    public function __construct($data, $date)
    {
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->data);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // Creating the header row with SNO, CLIENT NAME, and day numbers 1-31
        $headers = ['SNO', 'CLIENT NAME'];

        // Add numbers 1 through 31 for days of the month
        if ($$this->date) {
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

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the header row
            1 => [
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => 'D3D3D3',
                    ],
                ],
            ],
        ];
    }
}
