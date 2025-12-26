<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AttendanceExport implements WithMultipleSheets
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function sheets(): array
    {
        return [
            new AttendanceSummarySheet($this->filters),
            // Can add more sheets here:
            // new AttendanceByTeacherSheet($this->filters),
            // new AttendanceByClassSheet($this->filters),
        ];
    }
}
