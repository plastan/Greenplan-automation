<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HeadCountSheet implements FromArray, WithHeadings, WithTitle, ShouldAutoSize
{
    protected $headCounts;

    public function __construct(array $headCounts)
    {
        $this->headCounts = $headCounts;
    }

    /**
     * @return array
     */

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('1')->getFont()->setBold(true);
    }
    public function array(): array
    {

        return $this->headCounts;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Date',
            'Weight Loss',
            'Muscle Gain',
            'Diabetic',
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'HeadCount';
    }
}
